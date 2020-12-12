<?php

namespace App\Http\Controllers\Web;

use App\Models\Universitas;
use Illuminate\Http\Request;
use App\Imports\UniversitasImport;
use App\Http\Controllers\Controller;
use App\Imports\UniversitasImportBatch;
use App\Models\KelompokPassingGrade;
use Maatwebsite\Excel\Facades\Excel;

class UniversitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $kelompok = KelompokPassingGrade::all();
        if($request->get('keyword') != '') {
            $nama = $request->get('keyword');
            $universitas = Universitas::latest()->where('nama', 'LIKE', "%$nama%")->paginate(10);
        } else {
            $universitas = Universitas::with('passing_grade')->latest()->paginate(10);
        }
        return view('pages.passing-grade.index', compact('universitas', 'kelompok', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Universitas::create($request->all());
            return redirect()->back()->with(['success' => 'Berhasil tambah universitas']);
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
    public function show($id)
    {
        // try {
        //     $universitas = Universitas::find($id);
        //     return view('pages.passing-grade.show', compact('universitas'));
        // } catch(\Exception $e) {
        //     return redirect()->back()->with(['error' => $e->getMessage()]);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
            $universitas = Universitas::find($id);
            $universitas->delete();
            return redirect()->route('universitas.index')->with(['success' => 'Berhasil Hapus Universitas']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function import(Request $request) {
        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx',
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            try {
                Excel::import(new UniversitasImport(), $file);
                return redirect()->back()->with(['success' => 'Import Universitas berhasil']);
                return redirect(route('universitas.index'));
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (!$message == "Start row (2) is beyond highest row (1)") throw $e;
                return \redirect()->back()->with(['error' => $message])->withInput();
            }
        }
        return \redirect()->back()->with(['error' => "Anda belum memilih file"])->withInput();
    }

    public function import_batch(Request $request) {
        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx',
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            try {
                Excel::import(new UniversitasImportBatch(), $file);
                return redirect()->back()->with(['success' => 'Import Universitas berhasil']);
                return redirect(route('universitas.index'));
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (!$message == "Start row (2) is beyond highest row (1)") throw $e;
                return \redirect()->back()->with(['error' => $message])->withInput();
            }
        }
        return \redirect()->back()->with(['error' => "Anda belum memilih file"])->withInput();
    }
}
