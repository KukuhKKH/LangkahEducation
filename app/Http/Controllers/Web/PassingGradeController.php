<?php

namespace App\Http\Controllers\Web;

use App\Models\Universitas;
use App\Models\PassingGrade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\PassingGrade\PassingGradeStore;
use App\Imports\PassingGradeImport;
use App\Models\KelompokPassingGrade;

class PassingGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
    public function store(PassingGradeStore $request)
    {
        try {
            $cek = PassingGrade::where('prodi', $request->prodi)->where('universitas_id', $request->universitas_id)->first();
            if($cek) {
                return redirect()->back()->with(['error' => "Prodi di universitas ini sudah ada"]);    
            }
            PassingGrade::create($request->all());
            return redirect()->back()->with(['success' => "Berhasil menambah passing grade"]);
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
            $kelompok = KelompokPassingGrade::all();
            $passing_grade = PassingGrade::where('universitas_id', $id)->latest()->paginate(10);
            $universitas = Universitas::find($id);
            $data = $request->all();

            if($request->get('keyword') != '') {
                $nama = $request->get('keyword');
                $kelompok = KelompokPassingGrade::all();
                $passing_grade = PassingGrade::where('universitas_id', $id)->where('prodi', 'LIKE', "%$nama%")->latest()->paginate(10);
                $universitas = Universitas::find($id);
            }

            return view('pages.passing-grade.show', compact('passing_grade','kelompok', 'universitas', 'data'));
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
            $kelompok = KelompokPassingGrade::all();
            $passing_grade = PassingGrade::find($id);
            return view('pages.passing-grade.edit_passing_grade', compact('passing_grade', 'kelompok'));
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
            $PassingGrade = PassingGrade::find($id);
            $PassingGrade->update([
                'kelompok_id' => $request->kelompok_id,
                'prodi' => $request->prodi,
                'passing_grade' => $request->passing_grade,
            ]);
            return redirect()->route('passing-grade.show', $PassingGrade->universitas_id)->with(['success' => "Berhasil update passing grade"]);
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
            $passing_grade = PassingGrade::find($id);
            $passing_grade->delete();
            return redirect()->back()->with(['success' => 'Berhasil Hapus Passing Grade']);
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
                Excel::import(new PassingGradeImport($request->universitas_id), $file);
                return redirect()->back()->with(['success' => 'Import passing grade berhasil']);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (!$message == "Start row (2) is beyond highest row (1)") throw $e;
                return \redirect()->back()->with(['error' => $message])->withInput();
            }
        }
        return \redirect()->back()->with(['error' => "Anda belum memilih file"])->withInput();
    }
}
