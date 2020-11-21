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
    public function index()
    {
        $paket = TryoutPaket::latest()->paginate(10);
        return view('pages.tryout.paket.index', compact('paket'));
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
            $request->merge([
                'user_id' => auth()->user()->id,
                'tgl_akhir' => date('Y-m-d H:i:s', time() + 24*7*60*60) // 7 Hari
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
            return view('pages.tryout.paket.edit', compact('paket'));
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
            $paket = TryoutPaket::find($id);
            $paket->update([
                'nama' => $request->nama,
                'status' => $request->status
            ]);
            return redirect()->route('paket.show', $paket->kategori->nama)->with(['success' => 'Berhasil update paket tryout']);
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
            $paket = TryoutPaket::find($id);
            $paket->delete();
            return redirect()->route('paket.show', $paket->kategori->nama)->with(['success' => 'Berhasil hapus paket tryout']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
