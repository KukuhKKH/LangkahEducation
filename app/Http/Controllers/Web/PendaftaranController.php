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
        $gelombang = Gelombang::latest()->paginate(10);
        $data = $request->all();
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
            $tgl_awal = "$raw_tgl_awal[1]/$raw_tgl_awal[0]/$raw_tgl_awal[2]";
            $tgl_akhir = "$raw_tgl_akhir[1]/$raw_tgl_akhir[0]/$raw_tgl_akhir[2]";
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
            $pendftaran = Gelombang::find($id);
            return view('pages.pendaftaran.edit', compact('pendftaran'));
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
            $tgl_awal = "$raw_tgl_awal[1]/$raw_tgl_awal[0]/$raw_tgl_awal[2]";
            $tgl_akhir = "$raw_tgl_akhir[1]/$raw_tgl_akhir[0]/$raw_tgl_akhir[2]";
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
            return view('pages.pendaftaran.gelombang_tryout', compact('gelombang', 'tryout', 'hasTryout'));
        } catch(\Exception $e) {
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
}
