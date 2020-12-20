<?php

namespace App\Http\Controllers\Web\Tryout;

use App\Models\TryoutPaket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tryout\Paket\PaketStore;
use App\Http\Requests\Tryout\Paket\PaketUpdate;
use App\Models\TryoutKategori;

class PaketController extends Controller
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
            $paket = TryoutPaket::latest()->where('nama', 'LIKE', "%$nama%")->paginate(10);
        }else{
            $paket = TryoutPaket::latest()->paginate(10);
        }

        return view('pages.tryout.paket.index', compact('paket', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaketStore $request)
    {
        try {
            $foto_name = '';
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/paket-tryout/'), $foto_name);
            }
            $raw_tgl_awal = \explode('/', $request->tgl_awal);
            $raw_tgl_akhir = \explode('/', $request->tgl_akhir);
            $tgl_awal = "$raw_tgl_awal[2]-$raw_tgl_awal[1]-$raw_tgl_awal[0] $request->jam_awal";
            $tgl_akhir = "$raw_tgl_akhir[2]-$raw_tgl_akhir[1]-$raw_tgl_akhir[0] $request->jam_akhir";
            $request->merge([
                'user_id' => auth()->user()->id,
                // 'tgl_akhir' => date('Y-m-d H:i:s', time() + 24*7*60*60) // 7 Hari
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'deskripsi' => '',
                'image' => $foto_name ?? ''
            ]);
            TryoutPaket::create($request->all());
            return redirect()->back()->with(['success' => 'Berhasil tambah paket tryout']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $paket = TryoutPaket::whereHas('kategori', function($q) use($slug) {
            $q->where('slug', $slug);
        })->latest()->paginate(10);
        $kategori = TryoutKategori::where('slug', $slug)->first();
        $data = $request->all();
        return view('pages.tryout.paket.show', compact('paket', 'data', 'kategori'));
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
            $paket = TryoutPaket::find($id);
            $tgl_awal = \explode(' ', $paket->tgl_awal);
            $tgl_akhir = \explode(' ', $paket->tgl_akhir);
            return view('pages.tryout.paket.edit', compact('paket', 'tgl_awal', 'tgl_akhir'));
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
    public function update(PaketUpdate $request, $id)
    {
        try {
            $foto_name = '';
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/paket-tryout/'), $foto_name);
            }
            $paket = TryoutPaket::find($id);
            $raw_tgl_awal = \explode('/', $request->tgl_awal);
            $raw_tgl_akhir = \explode('/', $request->tgl_akhir);
            $tgl_awal = "$raw_tgl_awal[2]-$raw_tgl_awal[1]-$raw_tgl_awal[0] $request->jam_awal";
            $tgl_akhir = "$raw_tgl_akhir[2]-$raw_tgl_akhir[1]-$raw_tgl_akhir[0] $request->jam_akhir";
            $paket->update([
                'nama' => $request->nama,
                'status' => $request->status,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'image' => $foto_name ?? '',
                'poin_1' => $request->poin_1,
                'poin_2' => $request->poin_2,
                'poin_3' => $request->poin_3,
                'poin_4' => $request->poin_4,
                'url_youtube_saintek' => $request->url_youtube_saintek,
                'url_youtube_soshum' => $request->url_youtube_soshum,
                'interpretasi_1' => $request->interpretasi_1,
                'interpretasi_2' => $request->interpretasi_2,
                'interpretasi_3' => $request->interpretasi_3,
            ]);
            return redirect()->route('paket.index')->with(['success' => 'Berhasil update paket tryout']);
        } catch(\Exception $e) {
            dd($e->getMessage());
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
            $paket = TryoutPaket::find($id);
            $paket->delete();
            return redirect()->back()->with(['success' => 'Berhasil hapus paket tryout']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show_soal($id) {
        try {
            $paket = TryoutPaket::with('soal')->find($id);
            return view('pages.tryout.paket.show_soal', compact('paket'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
