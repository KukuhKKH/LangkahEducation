<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gelombang\GelombangStore;
use App\Models\Gelombang;
use Illuminate\Http\Request;

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
                'nama' => $request->nama,
                'kode_referal' => $request->kode_referal,
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
                'nama' => $request->nama,
                'kode_referal' => $request->kode_referal,
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
}
