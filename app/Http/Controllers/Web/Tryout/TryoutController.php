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
        return view('pages.tryout.soal.create', compact('paket'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SoalCreate $request)
    {
        try {
            DB::beginTransaction();
            $soal = Auth::user()->soal()->create([
                'tryout_paket_id' => $request->tryout_paket_id,
                'soal' => $request->soal,
                'subbab' => $request->subbab,
                'pembahasan' => $request->pembahasan,
                'benar' => $request->nilai_benar,
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
        $data = $request->all();
        return view('pages.tryout.soal.show', compact('tryout', 'paket', 'data'));
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
            $soal = TryoutSoal::find($id);
            $jawaban = [];
            $benar = 'pilihan';
            foreach ($soal->jawaban as $key => $value) {
                $jawaban[] = $value->jawaban;
                if($value->benar == 1) {
                    $benar .= $key+1;
                }
            }
            return view('pages.tryout.soal.edit', compact('soal', 'jawaban', 'benar'));
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
        // dd($request->input());
        try {
            DB::beginTransaction();
            $soal = TryoutSoal::findOrFail($id);
            
            $soal->update([
                'soal' => $request->soal,
                'subbab' => $request->subbab,
                'pembahasan' => $request->pembahasan,
                'benar' => $request->nilai_benar,
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

    public function tryout_store(Request $request, $paket_slug, $kategori_slug) {
        $kategori_id = TryoutKategori::findSlug($kategori_slug)->id;
        $paket_id = TryoutPaket::findSlug($paket_slug)->id;

        $data_hasil = Auth::user()->tryout_hasil()->create([
            'tryout_kategori_id' => $kategori_id,
            'tryout_paket_id' => $paket_id,
            'nilai_awal' => 0,
            'nilai_sekarang' => 0,
            'nilai_maksimal' => 0
        ]);
        $nilai_sekarang = 0;
        $nilai_maksimal = 0;
        foreach ($request->input('soal', []) as $key => $value) {
            $soal = TryoutSoal::find($value);
            $benar = $soal->benar;
            $salah = $soal->salah;
            $nilai_maksimal += $benar;
            if (TryoutJawaban::find($request->jawaban[$value])->benar) {
                $nilai_sekarang += $benar;
            } else {
                $nilai_sekarang -= $salah;
            }

            $data_hasil->tryout_hasil_jawaban()->create([
                'tryout_soal_id' => $value,
                'tryout_jawaban_id' => $request->jawaban[$value]
            ]);
        }
        $data_hasil->update([
            'nilai_awal' => $nilai_sekarang,
            'nilai_sekarang' => $nilai_sekarang,
            'nilai_maksimal' => $nilai_maksimal
        ]);
        return "Berhaasil";
    }

    public function import_batch(Request $request) {
        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx',
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            try {
                $paket_id = $request->paket_id;
                $kategori_id = $request->kategori_id;
                Excel::import(new SoalImportBatch($kategori_id, $paket_id), $file);
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
