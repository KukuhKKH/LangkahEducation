<?php

namespace App\Http\Controllers\Web\Tryout;

use App\Models\TryoutSoal;
use App\Models\TryoutPaket;
use Illuminate\Http\Request;
use App\Models\TryoutJawaban;
use App\Models\TryoutKategori;
use App\Imports\SoalImportBatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Tryout\Soal\SoalCreate;
use App\Http\Requests\Tryout\Soal\SoalUpdate;
use App\Models\TryoutKategoriSoal;

class TryoutController extends Controller
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
    public function create($slug)
    {
        $paket = TryoutPaket::where('slug', $slug)->first();
        $kategori_soal = TryoutKategoriSoal::all();
        return view('pages.tryout.soal.create', compact('paket', 'kategori_soal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SoalCreate $request)
    {
        if($request->nilai_salah < 0) {
            return redirect()->back()->with(['error' => 'Nilai salah tidak boleh negatif'])->withInput();
        }
        try {
            DB::beginTransaction();
            $soal = Auth::user()->soal()->create([
                'tryout_paket_id' => $request->tryout_paket_id,
                'soal' => $request->soal,
                'tryout_kategori_soal_id' => $request->tryout_kategori_soal_id,
                'pembahasan' => $request->pembahasan,
                'benar' => 4,
                'salah' => $request->nilai_salah,
            ]);
            foreach ($request->input() as $key => $value) {
                if(strpos($key, 'pilihan') !== false && $value != '') {
                    $benar = $request->input('benar') == $key ? 1 : 0;
                    $soal->jawaban()->create([
                        'jawaban'   => $value,
                        'benar'     => $benar
                    ]);
                }
            }
            $slug = TryoutPaket::find($request->tryout_paket_id)->slug;
            DB::commit();
            return redirect()->route('soal.show', $slug)->with(['success' => "Berhasil menambahkan soal"]);
        } catch(\Exception $e) {
            DB::rollBack();
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
        $tryout = TryoutSoal::whereHas('paket', function($q) use($slug) {
            $q->where('slug', $slug);
        })->latest()->paginate(10);
        $paket = TryoutPaket::where('slug', $slug)->first();
        $paket_soal = TryoutKategoriSoal::all();
        $data = $request->all();
        return view('pages.tryout.soal.show', compact('tryout', 'paket', 'data', 'paket_soal'));
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
            $kategori_soal = TryoutKategoriSoal::all();
            $soal = TryoutSoal::find($id);
            $jawaban = [];
            $benar = 'pilihan';
            foreach ($soal->jawaban as $key => $value) {
                $jawaban[] = $value->jawaban;
                if($value->benar == 1) {
                    $benar .= $key+1;
                }
            }
            return view('pages.tryout.soal.edit', compact('soal', 'jawaban', 'benar', 'kategori_soal'));
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
    public function update(SoalUpdate $request, $id)
    {
        if($request->nilai_salah < 0) {
            return redirect()->back()->with(['error' => 'Nilai salah tidak boleh negatif'])->withInput();
        }
        try {
            DB::beginTransaction();
            $soal = TryoutSoal::findOrFail($id);
            
            $soal->update([
                'soal' => $request->soal,
                'tryout_kategori_soal_id' => $request->tryout_kategori_soal_id,
                'pembahasan' => $request->pembahasan,
                'salah' => $request->nilai_salah
            ]);
            $i = 0;
            foreach ($request->input() as $key => $value) {
                if(strpos($key, 'pilihan') !== false && $value != '') {
                    $benar = $request->input('benar') == $key ? 1 : 0;
                    $soal->jawaban->all()[$i++]->update([
                        'jawaban'   => $value,
                        'benar'     => $benar
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('soal.show', $soal->paket->slug)->with(['success' => "Berhasil menambahkan soal"]);
        } catch(\Exception $e) {
            DB::rollBack();
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
            DB::beginTransaction();

            $soal = TryoutSoal::findOrFail($id);
            // Delete Data Jawaban
            $soal->jawaban()->delete();
            // Delete Data Soal
            $soal->delete();

            DB::commit();
            return redirect()->route('soal.show', $soal->paket->slug)->with(['success' => "Berhasil hapus soal"]);
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function import_batch(Request $request) {
        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx',
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            try {
                $paket_id = $request->paket_id;
                Excel::import(new SoalImportBatch($paket_id), $file);
                return redirect()->back()->with(['success' => 'Import Soal berhasil']);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (!$message == "Start row (2) is beyond highest row (1)") throw $e;
                return \redirect()->back()->with(['error' => $message])->withInput();
            }
        }
        return \redirect()->back()->with(['error' => "Anda belum memilih file"])->withInput();
    }
}
