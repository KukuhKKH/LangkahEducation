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
use App\Models\TempProdi;
use App\Models\TryoutHasilDetail;

class TryoutController extends Controller
{
    public function index() {
        $paket = TryoutPaket::find(1);
        $hasil = TryoutHasil::where('gelombang_id', 8)->where('tryout_paket_id', 1)->get();
        $detail = [];
        foreach ($hasil as $key => $value) {
            $detail[] = $value->tryout_hasil_jawaban()->with(['hasil.user', 'soal'])->orderBy('tryout_soal_id', 'ASC')->get();
        }
        $id_soal = TryoutSoal::where('tryout_paket_id', 1)->get()->pluck('id')->toArray();
        $id_soal_saintek = TryoutSoal::whereHas('kategori_soal', function($q) {
            $q->where('tipe', 'umum')->orWhere('tipe', 'saintek');
        })->where('tryout_paket_id', 1)->get()->pluck('id')->toArray();
        $id_soal_soshum = TryoutSoal::whereHas('kategori_soal', function($q) {
            $q->where('tipe', 'umum')->orWhere('tipe', 'soshum');
        })->where('tryout_paket_id', 1)->get()->pluck('id')->toArray();
        $data = [];
        $i = 0;
        
        foreach ($detail as $key => $value) {
            $kategori_to = TempProdi::where('gelombang_id', 8)->where('paket_id', 1)->where('user_id', $value->first()->hasil->user_id)->first()->kelompok_passing_grade_id;
            $nama_kategori_to = KelompokPassingGrade::find($kategori_to)->nama;
            if($nama_kategori_to == 'saintek') {
                $total_jawaban = count($id_soal_saintek);
                $id_soal = $id_soal_saintek;
            } elseif($nama_kategori_to == 'soshum') {
                $total_jawaban = count($id_soal_soshum);
                $id_soal = $id_soal_soshum;
            } else {
                $total_jawaban = count($id_soal);
            }

            for ($i=0; $i < $total_jawaban; $i++) { 
                if($id_soal[$i] != $value[$i]->tryout_soal_id) {
                    $temp_raw = [
                        'status' => 'kosong',
                        'user_id' => $value[$i]->hasil->user_id
                    ];
                    $raw_splice = (object) $temp_raw;
                    $value->splice($i, 0, [$raw_splice]);
                }
            }
        }

        $raw_jumlah = [];
        $raw_benar = [];
        $raw_presentase = [];
        $raw_poin = [];
        
        // Normalisasi benar jadi 1 salah / kosong jadi 0
        foreach ($detail as $key => $value) {
            $kategori_to = TempProdi::where('gelombang_id', 8)->where('paket_id', 1)->where('user_id', $value->first()->hasil->user_id)->first()->kelompok_passing_grade_id;
            $nama_kategori_to = KelompokPassingGrade::find($kategori_to)->nama;
            if($nama_kategori_to == 'saintek') {
                $total_jawaban = count($id_soal_saintek);
                $id_soal = $id_soal_saintek;
            } elseif($nama_kategori_to == 'soshum') {
                $total_jawaban = count($id_soal_soshum);
                $id_soal = $id_soal_soshum;
            } else {
                $total_jawaban = count($id_soal);
            }
            for ($i=0; $i < $total_jawaban; $i++) {
                empty($id_user) ? $id_user = $value[$i]->hasil->user_id : $id_user = $id_user;
                if(!empty($value[$i])) {
                    if($value[$i]->status == 'kosong') {
                        $data[$id_user][$id_soal[$i]] = 0;
                    } else {
                        if($value[$i]->tryout_soal_id == $id_soal[$i]) {
                            if(TryoutJawaban::find($value[$i]->tryout_jawaban_id)->benar) {
                                $data[$value[$i]->hasil->user_id][$id_soal[$i]] = 1;
                            } else {
                                $data[$value[$i]->hasil->user_id][$id_soal[$i]] = 0;
                            }
                        } else {
                            $data[$value[$i]->hasil->user_id][$id_soal[$i]] = 0;
                        }
                    }
                } else {
                    $data[$id_user][$id_soal[$i]] = 0;
                }
            }
            $id_user = null;
        }

        // total benar dan total soal
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                if(!isset($raw_jumlah[$k])) {
                    $raw_jumlah[$k] = 1;
                } else {
                    $raw_jumlah[$k] = $raw_jumlah[$k]+1;
                }

                if(!isset($raw_benar[$k])) {
                    if($v == 1) {
                        $raw_benar[$k] = 1;
                    } else {
                        $raw_benar[$k] = 0;
                    }
                } else {
                    if($v == 1) {
                        $raw_benar[$k] = $raw_benar[$k]+1;
                    }
                }
            }
        }
        
        foreach ($raw_benar as $key => $value) {
            $raw_presentase[$key] = ceil($raw_benar[$key]/$raw_jumlah[$key] * 100);
        }
        
        // Menghitung Poin setiap soal bwang
        foreach ($raw_presentase as $key => $value) {
            if($value >= 0 && $value < $paket->poin_4) {
                $raw_poin[$key] = 4;
            } elseif($value >= $paket->poin_4 && $value < $paket->poin_3) {
                $raw_poin[$key] = 3;
            } elseif($value >= $paket->poin_3 && $value < $paket->poin_2) {
                $raw_poin[$key] = 2;
            } elseif($value >= $paket->poin_2) {
                $raw_poin[$key] = 1;
            }
        }

        $nilai_maksimal = [];
        $nilai_maksimal['campuran'] = array_sum($raw_poin);
        $nilai_maksimal['saintek'] = 0;
        $nilai_maksimal['soshum'] = 0;
        foreach ($id_soal_saintek as $key => $value) {
            if(isset($raw_poin[$value])) {
                $nilai_maksimal['saintek'] += $raw_poin[$value];
            }
        }
        foreach ($id_soal_soshum as $key => $value) {
            if(isset($raw_poin[$value])) {
                $nilai_maksimal['soshum'] += $raw_poin[$value];
            }
        }

        $nilai_sekarang = [];
        $temp_detail = [];
        foreach ($detail as $key => $value) {
            $temp_nilai = 0;
            $user_id = null;
            foreach ($value as $k => $v) {
                if($v->status == 'kosong') {
                    $user_id = $v->user_id;
                    $temp_nilai -= 0;
                } else {
                    $user_id = $v->hasil->user_id;
                    $kategori_soal_id = $v->soal->kategori_soal->id;
                    if(TryoutJawaban::find($v->tryout_jawaban_id)->benar) {
                        $temp_nilai += $raw_poin[$v->tryout_soal_id];
                    } else {
                        $temp_nilai -= $v->soal->salah;
                    }
                    $temp_detail[$user_id][$kategori_soal_id] = $temp_nilai;
                }
            }
            $nilai_sekarang[$user_id] = $temp_nilai;
            // Harus e di sini Update Nilai mulai detail sama hasil detail
            // Update Detail per kategori
            foreach ($temp_detail[$user_id] as $key => $value) {
                TryoutHasilDetail::where('tryout_paket_id', 1)
                            ->where('tryout_kategori_soal_id', $key)
                            ->where('user_id', $user_id)
                            ->update([
                                'nilai' => $value
                            ]);
            }
            $kategori_to = TempProdi::where('gelombang_id', 8)
                            ->where('paket_id', 1)
                            ->where('user_id', $user_id)
                            ->first()->kelompok_passing_grade_id;
            $nama_kategori_to = KelompokPassingGrade::find($kategori_to)->nama;
            if($nama_kategori_to == 'saintek') {
                $index_nilai_max = 'saintek';
            } elseif($nama_kategori_to == 'soshum') {
                $index_nilai_max = 'soshum';
            } else {
                $index_nilai_max = 'campuran';
            }
            TryoutHasil::where('gelombang_id', 8)
                            ->where('tryout_paket_id', 1)
                            ->where('user_id', $user_id)
                            ->update([
                                'nilai_sekarang' => $nilai_sekarang[$user_id],
                                'nilai_maksimal_new' => $nilai_maksimal[$index_nilai_max]
                            ]);
        }
        return response()->json(['error' => false, 'status' => 'iso cuakkkkk'], 200);
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
