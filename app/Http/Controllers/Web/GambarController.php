<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\GambarSoal;
use Illuminate\Http\Request;

class GambarController extends Controller
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
            $gambar = GambarSoal::latest()->where('nama', 'LIKE', "%$nama%")->paginate(10);
        } else {
            $gambar = GambarSoal::latest()->paginate(10);
        }


        return view('pages.gambar.index', compact('gambar', 'data'));
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
            'foto' => 'required'
        ]);
        try {
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/soal/'), $foto_name);
                $request->foto = $foto_name;
            }
            GambarSoal::create([
                'nama' => $request->nama,
                'gambar' => $request->foto
            ]);
            return redirect()->back()->with(['success' => 'Berhasil tambah gambar']);
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
            $gambar = GambarSoal::find($id);
            return view('pages.gambar.edit', compact('gambar'));
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
            'foto' => 'required'
        ]);

        try {
            $gambar = GambarSoal::find($id);
            if($request->hasFile('foto')) {
                if(file_exists(public_path('upload/soal/'.$gambar->gambar))){
                    unlink(public_path('upload/soal/'.$gambar->gambar));
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/soal/'), $foto_name);
                $request->foto = $foto_name;
            }
            $gambar->update([
                'nama' => $request->nama,
                'gambar' => $request->foto
            ]);
            return redirect()->route('gambar.index')->with(['success' => 'Berhasil update gambar']);
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
            $gambar = GambarSoal::find($id);
            if(file_exists(public_path('upload/soal/'.$gambar->gambar))){
                unlink(public_path('upload/soal/'.$gambar->gambar));
            }
            $gambar->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus gambar"]);
        } catch(\Exception $e) {
            return \redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
