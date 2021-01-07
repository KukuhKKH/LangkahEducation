<?php

namespace App\Http\Controllers\Web;

use App\Exports\PembayaranExport;
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
            $user = Auth::user();
            $role = $user->getRoleNames()->first();
            $query = Pembayaran::query();
            $nama = $request->get('keyword');
            $bank_id = $request->get('bank_id');
            $gelombang = $request->get('gelombang');
            $time = $request->get('time');
            $admin = "";
            $salah = false;
            if($role == 'admin') {
                $admin = DB::table('admin_pembayaran')->select('pembayaran_id')->where('user_id', '=', $user->id)->get()->pluck('pembayaran_id')->toArray();
                if(empty($admin)) {
                    $admin = [0];
                }
            }
            $query->when($nama, function($q) use($nama) {
                $q->whereHas('user', function($child) use($nama) {
                    $child->where('name', 'LIKE', "%$nama%");
                });
            })->when($gelombang, function($q) use($gelombang){
                $q->where('gelombang_id', $gelombang);
            })->when($bank_id, function($q) use ($bank_id) {
                $q->whereHas('pembayaran_bukti', function($query) use($bank_id) {
                    $query->where('bank_id', $bank_id);
                });
            })->when($admin, function($q) use($admin) {
                $q->whereIn('id', $admin);
            });
            if($status == 'sudah-bayar') {
                $query->where('status', 1);
            } else if($status == 'belum-bayar'){
                $query->where('status', 0);
            } else if($status == 'ditolak'){
                $query->where('status', 3);
            } else if($status == 'sudah-verifikasi') {
                $query->where('status', 2);
            } else {
               $salah = true;
            }
            if($time == 0) {
                $query->orderBy('id', 'DESC');
            } else {
                $query->orderBy('id', 'ASC');
            }
            $pembayaran = $query->paginate(10);
            if($salah) redirect('dashboard');
            $data = $request->all();
            $bank = Bank::where('bayar', 1)->get();
            $gelombang = Gelombang::where('jenis', 1)->get();

            return view('pages.pembayaran.show', compact('pembayaran', 'data',  'bank', 'gelombang'));
        } catch(\Exception $e) {
            return abort(404);
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

    public function get_detail($id) {
        try {
            $pembayaran = PembayaranBukti::with('pembayaran.user')->where('pembayaran_id', $id)->first();
            return view('pages.pembayaran.pembayaran-detail', compact('pembayaran'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function export_all(Request $request) {
        $gelombang = $request->gelombang;
        $query = Pembayaran::query();
        $query->with(['user.siswa', 'pembayaran_bukti.bank', 'gelombang']);
        if($gelombang != 0) {
            $query->whereHas('gelombang', function($q) use($gelombang) {
                $q->where('id', $gelombang);
            });
        }
        $data = $query->where('status', 2)->whereBetween('created_at', [$request->tgl_awal, $request->tgl_akhir])->get();
        return (new PembayaranExport($data))->download(date('d-M-Y')."-pembayaran.xlsx");
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
            dd($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function siswa_show($pembayaran_id, $slug) {
        try {
            $bank = Bank::where('bayar', 1)->get();
            $pembayaran = Auth::user()->pembayaran()->with(['user', 'gelombang'])->find($pembayaran_id);
            return view('pages.pembayaran.siswa_show', compact('pembayaran', 'bank'));
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
                'bukti' => $request->bukti,
                'bank_id' => $request->bank_id ?? 0
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
            $bank = Bank::where('bayar', 1)->get();
            $pembayaran = Pembayaran::with(['user', 'gelombang'])->find($id);
            return view('pages.pembayaran.siswa_edit', compact('pembayaran', 'bank'));
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
                'bukti' => $request->file,
                'bank_id' => $request->bank_id ?? 0
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
