<?php

namespace App\Http\Controllers\Web\Tryout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tryout\Soal\SoalCreate;
use App\Models\TryoutPaket;
use App\Models\TryoutSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'kategori_id' => $request->kategori_id,
                'soal' => $request->soal,
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
        //
    }
}
