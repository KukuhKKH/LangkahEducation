<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LayananProduk;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layanan = LayananProduk::latest()->paginate(10);
        return view('pages.halaman.layanan.index', compact('layanan'));
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
            'deskripsi' => 'required',
            'foto' => 'nullable|mimes:jpg,jpeg,gif,png|max:2024'
        ]);
        try {
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/layanan/'), $foto_name);
            }
            LayananProduk::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'foto' => $foto_name ?? ''
            ]);
            return redirect()->back()->with(['success' => "Berhasil membuat layanan"]);
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
            $layanan = LayananProduk::find($id);
            return view('pages.halaman.layanan.edit', compact('layanan'));
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
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|mimes:jpg,jpeg,gif,png|max:2024'
        ]);
        try {
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/layanan/'), $foto_name);
            }
            $layanan = LayananProduk::find($id);
            $layanan->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'foto' => $foto_name ?? $layanan->foto
            ]);
            return redirect()->route('layanan.index')->with(['success' => "Berhasil update layanan"]);
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
            LayananProduk::find($id)->delete();
            return redirect()->back()->with(['success' => "Berhasil hapus layanan"]);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
