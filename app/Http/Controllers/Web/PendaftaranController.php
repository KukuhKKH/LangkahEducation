<?php

namespace App\Http\Controllers\Web;

use App\Models\Gelombang;
use App\Models\TryoutPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gelombang\GelombangStore;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if($request->get('keyword') != '') {    
            $nama = $request->get('keyword');
            $gelombang = Gelombang::latest()->where('nama', 'LIKE', "%$nama%")->paginate(10);
        } else {
            $gelombang = Gelombang::latest()->paginate(10);
        }
        return view('pages.pendaftaran.index', compact('gelombang', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GelombangStore $request)
    {
        try {
            $raw_tgl_awal = \explode('/', $request->tgl_awal);
            $raw_tgl_akhir = \explode('/', $request->tgl_akhir);
            $tgl_awal = "$raw_tgl_awal[2]-$raw_tgl_awal[1]-$raw_tgl_awal[0] $request->jam_awal";
            $tgl_akhir = "$raw_tgl_akhir[2]-$raw_tgl_akhir[1]-$raw_tgl_akhir[0] $request->jam_akhir";
            $gelombang = Gelombang::latest()->first();
            $data = [
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            ];
            if($gelombang) {
                $data['gelombang'] = $gelombang->gelombang + 1;
            } else {
                $data['gelombang'] = 1;
            }
            Gelombang::create($data);
            return redirect()->back()->with(['success' => 'Berhasil menambah gelombang']);
        } catch(\Exception $e) {
            // dd($e->getMessage());
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
        try {
            $pendaftaran = Gelombang::find($id);
            return view('pages.pendaftaran.edit', compact('pendaftaran'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
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
        try {
            $pendftaran = Gelombang::find($id);
            $raw_tgl_awal = \explode('/', $request->tgl_awal);
            $raw_tgl_akhir = \explode('/', $request->tgl_akhir);
            $tgl_awal = "$raw_tgl_awal[2]-$raw_tgl_awal[1]-$raw_tgl_awal[0] $request->jam_awal";
            $tgl_akhir = "$raw_tgl_akhir[2]-$raw_tgl_akhir[1]-$raw_tgl_akhir[0] $request->jam_akhir";
            $pendftaran->update([
                'jenis' => $request->jenis,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            ]);
            return redirect()->route('pendaftaran.index')->with(['success' => 'Berhasil update gelombang']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Gelombang::find($id)->delete();
            return redirect()->back()->with(['success' => 'Berhasil Hapus Gelombang']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function integrasi_tryout($id) {
        try {
            $gelombang = Gelombang::find($id);
            $tryout = TryoutPaket::where('status', 1)->latest()->get();
            $hasTryout = DB::table('gelombang_tryout')
                                ->select('tryout_paket.nama')
                                ->join('tryout_paket', 'tryout_paket.id', '=', 'gelombang_tryout.tryout_paket_id')
                                ->where('gelombang_id', $gelombang->id)->get()->pluck('nama')->all();
            $to_lewat = DB::table('gelombang_tryout')
                            ->select('tryout_paket.id as id')
                            ->join('tryout_paket', 'tryout_paket.id', '=', 'gelombang_tryout.tryout_paket_id')
                            ->where('gelombang_id', '=', $id)
                            ->whereDate('tryout_paket.tgl_akhir', '<=', date('Y-m-d H:i'))
                            ->get()->pluck('id')->all();
            $sudah_koreksi = '';
            // DB::table('gelombang_tryout')
            //                     ->select('tryout_paket.id as id')
            //                     ->join('tryout_paket', 'tryout_paket.id', '=', 'gelombang_tryout.tryout_paket_id')
            //                     ->where('gelombang_id', '=', $id)
            //                     ->where('tryout_paket.koreksi', '=', 1)
            //                     ->get()->pluck('id')->all();
            return view('pages.pendaftaran.gelombang_tryout', compact('gelombang', 'tryout', 'hasTryout', 'to_lewat', 'sudah_koreksi'));
        } catch(\Exception $e) {
            dd($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function integrasi_tryout_store(Request $request, $id) {
        try {
            $gelombang = Gelombang::find($id);
            $gelombang->tryout()->sync($request->tryout);
            return redirect()->route('pendaftaran.index')->with(['success' => "Tryout berhasil diintegrasikan"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function list_siswa($id) {
        try {
            $gelombang = Gelombang::with('siswa')->find($id);
            return view('pages.pendaftaran.list_siswa', compact('gelombang'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function list_sekolah($id) {
        try {
            $gelombang = Gelombang::with('sekolah')->find($id);
            return view('pages.pendaftaran.list_sekolah', compact('gelombang'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
}
