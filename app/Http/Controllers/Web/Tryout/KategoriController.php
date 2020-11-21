<?php

namespace App\Http\Controllers\Web\Tryout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tryout\Kategori\KategoriStore;
use App\Models\TryoutKategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategori = TryoutKategori::latest()->paginate(10);
        $data = $request->all();
        return view('pages.tryout.kategori.index', compact('kategori', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriStore $request)
    {
        try {
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/tryout/kategori/'), $foto_name);
                $request->foto = $foto_name;
            }
            $request->merge([
                'user_id' => auth()->user()->id
            ]);
            $kategori = TryoutKategori::create($request->all());
            return redirect()->route('kategori.index')->with(['success' => 'Berhasil menambah kategori']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
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
            $kategori = TryoutKategori::find($id);
            return view('pages.tryout.kategori.edit', compact('kategori'));
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
            $kategori = TryoutKategori::find($id);
            $kategori->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi
            ]);
            return redirect()->route('kategori.index')->with(['success' => 'Berhasil Update Kategori']);
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
            $kategori = TryoutKategori::find($id);
            $kategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Berhasil Hapus Kategori']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
