<?php

namespace App\Http\Controllers\Web\Tryout;

use App\Http\Controllers\Controller;
use App\Models\TryoutKategoriSoal;
use Illuminate\Http\Request;

class KategoriSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = TryoutKategoriSoal::latest()->paginate(10);
        return view('pages.tryout.kategori-soal.index', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            TryoutKategoriSoal::create($request->all());
            return redirect()->back()->with(['success' => "Berhasil menambah kategori soal"]);
        } catch(\Exception $e) {
            dd($e->getMessage());
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
        try{
            $kategori = TryoutKategoriSoal::find($id);
            return view('pages.tryout.kategori-soal.edit', compact('kategori'));
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
        try{
            $kategori = TryoutKategoriSoal::find($id);
            $kategori->update($request->all());
            return redirect()->route('kategori-soal.index')->with(['success' => "Berhasil update kategori soal"]);
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
            $kategori = TryoutKategoriSoal::find($id);
            $kategori->delete();
            return redirect()->back()->with(['success' => 'Berhasil hapus kategori soal tryout']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
