<?php

namespace App\Http\Controllers\Web\Siswa;

use App\Models\TryoutSoal;
use App\Models\TryoutPaket;
use Illuminate\Http\Request;
use App\Models\TryoutJawaban;
use App\Models\TryoutHasilDetail;
use App\Models\TryoutKategoriSoal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TryoutController extends Controller
{
    public function index() {
        $user = Auth::user();
        if($user->siswa->batch == 1) {
            $paket = $user->siswa->sekolah->first()->tryout;
            $status_bayar = 1;
        } else if($user->siswa->batch == 0) {
            $paket = $user->pembayaran->first()->gelombang->tryout;
            $status_bayar = $user->pembayaran()->latest()->first()->status;
        }
        return view('pages.siswa.tryout.index',compact('paket', 'status_bayar'));
    }

    public function tryout_mulai($slug) {
        try {
            $paket = TryoutPaket::findSlug($slug);
            $cek = $paket->whereHas('hasil', function($q) {
                $q->where('user_id', auth()->user()->id);
            })->get();
            if(\count($cek) > 0) {
                return redirect()->back()->with(['error' => 'Anda sudah mengerjakan tryout ini']);
            } else {
                $soal = TryoutSoal::where('tryout_paket_id', $paket->id)
                            // ->inRandomOrder()
                            ->limit(10)
                            ->orderBy('tryout_kategori_soal_id', 'asc')
                            ->get();
                return view('tryout.index', compact('soal', 'paket'));
            }
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function tryout_store(Request $request, $paket_slug) {
        // try {
        //     DB::beginTransaction();
            $paket_id = TryoutPaket::findSlug($paket_slug)->id;

            $data_hasil = Auth::user()->tryout_hasil()->create([
                'tryout_paket_id' => $paket_id,
                'nilai_awal' => 0,
                'nilai_sekarang' => 0,
                'nilai_maksimal' => 0
            ]);
            $nilai_sekarang = 0;
            $nilai_maksimal = 0;
            $hasil_detail = [];
            foreach ($request->input('soal', []) as $key => $value) {
                $soal = TryoutSoal::find($value);
                $benar = $soal->benar;
                $salah = $soal->salah;
                $nilai_maksimal += $benar;
                $kateogri = TryoutKategoriSoal::find($soal->tryout_kategori_soal_id);
                if (TryoutJawaban::find($request->jawaban[$value])->benar) {
                    $nilai_sekarang += $benar;
                    empty($hasil_detail[$kateogri->id]) ? $hasil_detail[$kateogri->id] = $benar : $hasil_detail[$kateogri->id] += $benar;
                    // $hasil_detail[$kateogri->id] += $benar;
                } else {
                    $nilai_sekarang -= $salah;
                    empty($hasil_detail[$kateogri->id]) ? $hasil_detail[$kateogri->id] = -$salah : $hasil_detail[$kateogri->id] -= $salah;
                    // $hasil_detail[$kateogri->id] -= $salah;
                }

                $data_hasil->tryout_hasil_jawaban()->create([
                    'tryout_soal_id' => $value,
                    'tryout_jawaban_id' => $request->jawaban[$value]
                ]);
            }
            foreach ($hasil_detail as $key => $value) {
                TryoutHasilDetail::create([
                    'tryout_paket_id' => $paket_id,
                    'tryout_hasil_id' => $data_hasil->id,
                    'tryout_kategori_soal_id' => $key,
                    'user_id' => Auth::user()->id,
                    'nilai' => $value,
                ]);
            }
            $data_hasil->update([
                'nilai_awal' => $nilai_sekarang,
                'nilai_sekarang' => $nilai_sekarang,
                'nilai_maksimal' => $nilai_maksimal
            ]);
            // return "Berhaasil";
        //     DB::commit();
            return redirect()->route('siswa.tryout.index')->with(['success' => "Termikasih telah melaksanakan tryout"]);
        // } catch(\Exception $e) {
        //     DB::rollback();
        //     return redirect()->route('siswa.tryout.index')->with(['error' => $e->getMessage()]);
        // }
    }
}
