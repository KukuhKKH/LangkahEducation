<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Gelombang;
use App\Models\Pembayaran;
use App\Models\PembayaranBukti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $status)
    {
        try {
            if($status == 'sudah-bayar') {
                if($request->get('keyword') != '') {
                    $pembayaran = Pembayaran::whereHas('user', function($q) use($request) {
                        $nama = $request->get('keyword');
                        $q->where('name', 'LIKE', "%$nama%");
                    })->where('status', 1)->orWhere('status', 2)->orderBy('id', 'DESC')->paginate(10);
                } else {
                    $pembayaran = Pembayaran::where('status', 1)->orWhere('status', 2)->orderBy('id', 'DESC')->paginate(10);
                }
            } else if($status == 'belum-bayar'){
                if($request->get('keyword') != '') {
                    $pembayaran = Pembayaran::whereHas('user', function($q) use($request) {
                        $nama = $request->get('keyword');
                        $q->where('name', 'LIKE', "%$nama%");
                    })->where('status', 0)->orderBy('id', 'DESC')->paginate(10);
                } else {
                    $pembayaran = Pembayaran::where('status', 0)->orderBy('id', 'DESC')->paginate(10);
                }
            }
            else if($status == 'ditolak'){
                if($request->get('keyword') != '') {
                    $pembayaran = Pembayaran::whereHas('user', function($q) use($request) {
                        $nama = $request->get('keyword');
                        $q->where('name', 'LIKE', "%$nama%");
                    })->where('status', 3)->orderBy('id', 'DESC')->paginate(10);
                } else {
                    $pembayaran = Pembayaran::where('status', 3)->orderBy('id', 'DESC')->paginate(10);
                }
            }
            $data = $request->all();
            return view('pages.pembayaran.show', compact('pembayaran', 'data'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function siswa(Request $request) {
        try {
            $pembayaran = Auth::user()->pembayaran()->latest()->paginate(10);
            $data = $request->all();
            return view('pages.pembayaran.siswa', compact('pembayaran', 'data'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function daftar_gelombang() {
        try {
            $user = auth()->user();
            $today = date('Y-m-d H:i');
            $gelombang = Gelombang::where('jenis', 1)
                            ->where('jenis', 1)
                            ->whereDoesntHave('siswa', function($query) use($user) {
                                $query->where('siswa_id', $user->siswa->id);
                            })->get();
            return view('pages.pendaftaran.gelombang_siswa', compact('gelombang', 'today'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function daftar_gelombang_store($id) {
        try {
            $user = auth()->user();
            $gelombang = Gelombang::find($id);
            $gelombang->siswa()->attach($user->siswa->id);
            $pembayaran = Pembayaran::create([
                'user_id' => $user->id,
                'gelombang_id' => $gelombang->id,
                'kode_transfer' => rand(100, 999),
                'status' => 0
            ]);
            return redirect()->route('pembayaran-siswa.detail', $pembayaran->id)->with(['success' => "Berhasil mendaftar gelombang"]);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function detail_pembayaran($id) {
        try {
            $pembayaran = Pembayaran::find($id);
            if($pembayaran->gelombang->harga == 0){
                $rekening = Bank::where('bayar', 0)->orderBy('id', 'DESC')->limit(1)->get();
            }else{
                $rekening = Bank::where('bayar', 1)->get();
            }
            // $rekening = Bank::where('bayar', $bayar);
            return view('pages.pembayaran.pembayaran', compact('pembayaran', 'rekening'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function siswa_show($pembayaran_id, $slug) {
        try {
            $pembayaran = Auth::user()->pembayaran()->with(['user', 'gelombang'])->find($pembayaran_id);
            return view('pages.pembayaran.siswa_show', compact('pembayaran'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function siswa_bayar(Request $request, $id) {
        // $this->validate($request, [
        //     'file' => 'required|mimes:jpg,jpeg,png,gif|max:2000'
        // ]);
        try {
            if($request->hasFile('file')) {
                $foto_name = time().'.'.$request->file->extension();  
                $request->file->move(public_path('upload/bukti/'), $foto_name);
                $request->bukti = $foto_name;
            }
            DB::beginTransaction();
            PembayaranBukti::create([
                'pembayaran_id' => $id,
                'bukti' => $request->bukti
            ]);
            $pembayaran = Pembayaran::find($id);
            $pembayaran->update([
                'status' => 1
            ]);
            DB::commit();
            return redirect()->route('pembayaran.siswa')->with(['success' => 'Berhasil upload bukti transfer']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function siswa_edit($id) {
        try {
            $pembayaran = Pembayaran::with(['user', 'gelombang'])->find($id);
            return view('pages.pembayaran.siswa_edit', compact('pembayaran'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function siswa_update(Request $request, $id) {
        try {
            $pembayaran = Pembayaran::find($id);
            if($request->hasFile('file')) {
                if(file_exists(public_path('upload/bukti/'.$pembayaran->pembayaran_bukti->first()->bukti))){
                    unlink(public_path('upload/bukti/'.$pembayaran->pembayaran_bukti->first()->bukti));
                }
                $foto_name = time().'.'.$request->file->extension();  
                $request->file->move(public_path('upload/bukti/'), $foto_name);
                $request->file = $foto_name;
            }
            DB::beginTransaction();
            $pembayaran_bukti = PembayaranBukti::where('pembayaran_id', $id)->first();
            $pembayaran_bukti->update([
                'bukti' => $request->file
            ]);
            DB::commit();
            return redirect()->route('pembayaran.siswa')->with(['success' => 'Berhasil edit bukti transfer']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function set_status($id, $jenis) {
        try {
            DB::beginTransaction();
            $pembayaran = Pembayaran::find($id);
            if($jenis == 'terima') {
                $status = 2;
            } elseif($jenis == 'tolak') {
                $status = 3;
                DB::table('siswa_has_gelombang')
                    ->where('siswa_id', '=', $pembayaran->user->siswa->id)
                    ->where('gelombang_id', '=', $pembayaran->gelombang->id)
                    ->delete();
            }
            $pembayaran->update([
                'status' => $status
            ]);
            DB::commit();
            return redirect()->route('pembayaran.show', 'sudah-bayar')->with(['success' => "Berhasil $jenis bukti transfer"]);
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function siswa_destry($id) {
        try {
            DB::beginTransaction();
            $pembayaran = Pembayaran::find($id);
            DB::table('siswa_has_gelombang')
                ->where('siswa_id', '=', $pembayaran->user->siswa->id)
                ->where('gelombang_id', '=', $pembayaran->gelombang->id)
                ->delete();
            $pembayaran->delete();
            DB::commit();
            return redirect()->route('pembayaran.siswa')->with(['success' => "Membatalkan pembelian"]);
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
