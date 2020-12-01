<?php

namespace App\Http\Controllers\Web\User;

use App\Models\Sekolah;
use App\Models\NisnSekolah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NisnSiswaKeSekolahImport;

class SekolahNisnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nisn' => 'required|numeric',
            'sekolah_id' => 'required|numeric',
        ]);
        try {
            NisnSekolah::create([
                'sekolah_id' => $request->sekolah_id,
                'nisn' => $request->nisn
            ]);
            return redirect()->back()->with(['success' => 'Berhasil tambah nisn']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $sekolah = Sekolah::find($id);
            $nisn_siswa = NisnSekolah::when($request->get('keyword'), function($q) use($request) {
                $q->where('nisn', 'like', '%'.$request->get('keyword').'%');
            })->where('sekolah_id', $id)->latest()->paginate(10);
            $data = $request->all();
            return view('pages.users.nisn.show', compact('sekolah', 'nisn_siswa', 'data'));
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
            $nisn = NisnSekolah::with('sekolah')->find($id);
            return view('pages.users.nisn.edit', compact('nisn'));
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
            'nisn' => 'required|numeric',
        ]);
        try {
            $nisn = NisnSekolah::find($id);
            $nisn->update([
                'nisn' => $request->nisn
            ]);
            return redirect()->route('nisn.show', $nisn->sekolah->id)->with(['success' => 'Berhasil update nisn']);
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
            NisnSekolah::find($id)->delete();
            return redirect()->back()->with(['success' => 'Berhasil hapus nisn']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function import(Request $request) {
        $this->validate($request, [
            'file' => 'required'
        ]);
        if($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                Excel::import(new NisnSiswaKeSekolahImport($request->sekolah_id), $file);
                return \redirect()->back()->with(['success' => 'Import sekolah berhasil']);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (!$message == "Start row (2) is beyond highest row (1)") throw $e;
                return \redirect()->back()->with(['error' => $message])->withInput();
            }
        }
    }
}
