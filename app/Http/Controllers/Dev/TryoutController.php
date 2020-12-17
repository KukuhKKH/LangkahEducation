<?php

namespace App\Http\Controllers\Dev;

use App\Models\TryoutSoal;
use App\Models\TryoutHasil;
use App\Models\TryoutPaket;
use Illuminate\Http\Request;
use App\Models\TryoutJawaban;
use App\Models\TryoutKategoriSoal;
use App\Http\Controllers\Controller;
use App\Models\KelompokPassingGrade;

class TryoutController extends Controller
{
    public function index() {
        $hasil = TryoutHasil::where('gelombang_id', 8)->where('tryout_paket_id', 1)->get();
        $detail = [];
        foreach ($hasil as $key => $value) {
            $detail[] = $value->tryout_hasil_jawaban()->with(['hasil', 'soal'])->orderBy('tryout_soal_id', 'ASC')->get();
        }
        $id_soal = TryoutSoal::where('tryout_paket_id', 1)->get()->pluck('id')->toArray();
        // dd($id_soal);
        $data = [];
        $i = 0;
        foreach ($detail as $key => $value) {
            foreach ($value as $key2 => $value2) {
                // dd($value2->tryout_soal_id, $id_soal);
                // if(array_search($value2->tryout_soal_id, $id_soal)) {
                // if($id_soal[$i] == $value2->tryout_soal_id) {
                    if(TryoutJawaban::find($value2->tryout_jawaban_id)->benar) {
                        $data[$value2->hasil->user_id][$value2->tryout_soal_id] = 2;
                    } else {
                        $data[$value2->hasil->user_id][$value2->tryout_soal_id] = 1;
                    }
                // } else {
                //     $data[$value2->hasil->user_id][$id_soal[$i]] = 0;
                // }
                // $i++;
            }
        }
        dd($data, $id_soal);
    }

    public function soal(Request $request) {
        $kelompok = KelompokPassingGrade::where('kode', 'CDdzzwZGfK')->first();
        if($kelompok->nama == 'saintek') {
            $id_kateogri = TryoutKategoriSoal::where('tipe', 'umum')->orWhere('tipe', 'saintek')->get()->pluck('id');
        } elseif($kelompok->nama == 'soshum') {
            $id_kateogri = TryoutKategoriSoal::where('tipe', 'umum')->orWhere('tipe', 'soshum')->get()->pluck('id');
        } else {
            $id_kateogri = TryoutKategoriSoal::all()->pluck('id');
        }
        $paket = TryoutPaket::findSlug("sma-1-babadan-b");
        $kategori_id = $paket->soal()
                ->distinct()
                ->select('tryout_kategori_soal_id')
                ->whereIn('tryout_kategori_soal_id', $id_kateogri)
                ->get()->pluck('tryout_kategori_soal_id')
                ->toArray();
        dd($kategori_id);
    }
}
