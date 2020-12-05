<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BlogKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $kategori = Kategori::latest()->paginate(10);
        return view('pages.halaman.kategori.index', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'foto' => 'nullable'
        ]);
        try {
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/kategori/'), $foto_name);
                $request->foto = $foto_name;
            }
            Kategori::create([
                'user_id' => auth()->user()->id,
                'nama' => $request->nama,
                'foto' => $foto_name ?? ''
            ]);
            return redirect()->back()->with(['success' => 'Berhasil menambah kategori']);
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
            $kategori = Kategori::find($id);
            return view('pages.halaman.kategori.edit', compact('kategori'));
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
            $kategori = Kategori::find($id);
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/kategori/'), $foto_name);
            }
            $kategori->update([
                'nama' => $request->nama,
                'foto' => $foto_name ?? $kategori->foto
            ]);
            return redirect()->route('kategori-blog.index')->with(['success' => 'Berhasil update kategori']);
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
            $kategori = Kategori::find($id)->delete();
            return redirect()->route('kategori-blog.index')->with(['success' => 'Berhasil hapus kategori']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
