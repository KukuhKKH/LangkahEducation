<?php

namespace App\Http\Controllers\Web\Siswa;

use App\Models\TryoutSoal;
use App\Models\TryoutHasil;
use App\Models\TryoutPaket;
use App\Models\PassingGrade;
use Illuminate\Http\Request;
use App\Models\TryoutJawaban;
use App\Models\TryoutHasilDetail;
use App\Models\TryoutKategoriSoal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Gelombang;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TryoutController extends Controller
{
    public function index() {
        $user = Auth::user();
        $status_bayar = 0;
        if($user->siswa->batch == 1) {
            $paket = $user->siswa->sekolah->first()->tryout;
            $status_bayar = 1;
        } else if($user->siswa->batch == 0) {
            $cek_gelombang = Gelombang::wherehas('siswa', function($query) use($user) {
                $query->where('siswa_id', $user->siswa->id);
            })->get();

            // Sudah Daftar Gelombang
            if(count($cek_gelombang) > 0) {
                $gelombang = $user->siswa->gelombang()->get()->pluck('id');
                $id_gelombang = [];
                foreach ($gelombang as $key => $value) {
                    $pembayaran = Pembayaran::where('gelombang_id', $value)->where('user_id', $user->id)->first();
                    if($pembayaran->status == 2) {
                        $id_gelombang[] = $pembayaran->gelombang_id;
                    }
                }
                $id_tryout = DB::table('gelombang_tryout')
                                ->select('tryout_paket_id')
                                ->whereIn('gelombang_id', $id_gelombang)->get()->pluck('tryout_paket_id');
                $paket = TryoutPaket::whereIn('id', $id_tryout)->get();
                $status_bayar = 1;
            } else {
                $paket = [];
            }
        }
        $user_token = Crypt::encrypt($user->api_token);
        return view('pages.siswa.tryout.index',compact('paket', 'status_bayar', 'user_token'));
    }

    /**
     * Show Tryout Lama
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function tryout_mulai($slug) {
        try {
            $paket = TryoutPaket::findSlug($slug);
            $cek = $paket->whereHas('hasil', function($q) {
                $q->where('user_id', auth()->user()->id);
            })->get();
            if(\count($cek) > 0) {
                return redirect()->back()->with(['error' => 'Anda sudah mengerjakan tryout ini']);
            } else {
                $kategori_id = DB::table('tryout_soal')
                                ->distinct()
                                ->select('tryout_kategori_soal_id as id')
                                ->where('tryout_paket_id', '=', $paket->id)
                                ->get();
                $kategori_soal_id = [];
                foreach ($kategori_id as $key => $value) {
                    $kategori_soal_id[] = $value->id;
                }
                $waktu = DB::table('tryout_kategori_soal')
                            ->selectRaw('GROUP_CONCAT(waktu) as waktu')
                            ->selectRaw('GROUP_CONCAT(kode) as kode')
                            ->whereIn('id', $kategori_soal_id)->first();
                $waktu_array = explode(',', $waktu->waktu);
                $kode_array = explode(',', $waktu->kode);
                $soal = TryoutSoal::where('tryout_paket_id', $paket->id)
                            // ->inRandomOrder()
                            ->limit(10)
                            ->orderBy('tryout_kategori_soal_id', 'asc')
                            ->get();
                return view('tryout.index', compact('soal', 'paket', 'waktu_array', 'kode_array'));
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
            // dd($request->jawaban[24]);s
            foreach ($request->input('soal', []) as $key => $value) {
                if(!empty($request->jawaban[$value])) {
                    $soal = TryoutSoal::find($value);
                    $benar = $soal->benar;
                    $salah = $soal->salah;
                    $nilai_maksimal += $benar;
                    $kateogri = TryoutKategoriSoal::find($soal->tryout_kategori_soal_id);
                    if (TryoutJawaban::find($request->jawaban[$value])->benar) {
                        $nilai_sekarang += $benar;
                        empty($hasil_detail[$kateogri->id]['nilai']) ? $hasil_detail[$kateogri->id]['nilai'] = $benar : $hasil_detail[$kateogri->id]['nilai'] += $benar;
                        empty($hasil_detail[$kateogri->id]['benar']) ? $hasil_detail[$kateogri->id]['benar'] = 1 : $hasil_detail[$kateogri->id]['benar'] += 1;
                    } else {
                        $nilai_sekarang -= $salah;
                        empty($hasil_detail[$kateogri->id]['nilai']) ? $hasil_detail[$kateogri->id]['nilai'] = -$salah : $hasil_detail[$kateogri->id]['nilai'] -= $salah;
                        empty($hasil_detail[$kateogri->id]['salah']) ? $hasil_detail[$kateogri->id]['salah'] = 1 : $hasil_detail[$kateogri->id]['salah'] += 1;
                    }
    
                    $data_hasil->tryout_hasil_jawaban()->create([
                        'tryout_soal_id' => $value,
                        'tryout_jawaban_id' => $request->jawaban[$value]
                    ]);
                }
            }
            foreach ($hasil_detail as $key => $value) {
                $total_soal = TryoutSoal::where('tryout_kategori_soal_id', $key)->where('tryout_paket_id', $paket_id)->count();
                TryoutHasilDetail::create([
                    'tryout_paket_id' => $paket_id,
                    'tryout_hasil_id' => $data_hasil->id,
                    'tryout_kategori_soal_id' => $key,
                    'user_id' => Auth::user()->id,
                    'nilai' => $value['nilai'],
                    'benar' => $value['benar'] ?? 0,
                    'salah' => $value['salah'] ?? 0,
                    'kosong' => $total_soal - (($value['benar'] ?? 0) + ($value['salah'] ?? 0)),
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
    // End Tryout Lama

    /**
     * Show Tryout baru
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function tryout_baru(Request $request, $token, $slug) {
        try {
            // dd($request->session());
            // $request->session()->forget('kategori_id');
            // $request->session()->forget('index_kategori');
            $index = 0;
            if($request->session()->has('index_kategori')) {
                $index = $request->session()->get('index_kategori');
            } else {
                $request->session()->put('index_kategori', $index);
            }
            $paket = TryoutPaket::findSlug($slug);
            if(!$request->session()->has('kategori_id')) {
                $kateogri_id = $paket->soal()
                                    ->distinct()
                                    ->select('tryout_kategori_soal_id')
                                    ->get()->pluck('tryout_kategori_soal_id')
                                    ->toArray();
                $request->session()->put('kategori_id', $kateogri_id);
            } else {
                $kateogri_id = $request->session()->get('kategori_id');
            }
            $cek = $paket->whereHas('hasil', function($q) {
                $q->where('user_id', auth()->user()->id);
            })->get();
            // if(count($cek) > 0) {
            //     return redirect()->back()->with(['error' => 'Anda sudah mengerjakan tryout ini']);
            // } else {
                $soal = TryoutSoal::where('tryout_paket_id', $paket->id)
                                    ->inRandomOrder()
                                    ->where('tryout_kategori_soal_id', $kateogri_id[$index])
                                    ->get();
                $waktu = TryoutKategoriSoal::where('id', $kateogri_id[$index])->first()->waktu;
                return view('tryout.new', compact('soal', 'paket', 'waktu'));
            // }
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function tryout_store_baru(Request $request, $paket_slug) {
        $paket_id = TryoutPaket::findSlug($paket_slug)->id;

        $data_hasil = Auth::user()->tryout_hasil()->firstOrCreate([
            'tryout_paket_id' => $paket_id,
        ],[
            'nilai_awal' => 0,
            'nilai_sekarang' => 0,
            'nilai_maksimal' => 0
        ]);
        $nilai_sekarang = $data_hasil->nilai_sekarang ?? 0;
        $nilai_maksimal = $data_hasil->nilai_maksimal ?? 0;
        $hasil_detail = [];
        
        foreach ($request->input('soal', []) as $key => $value) {
            if(!empty($request->jawaban[$value])) {
                $soal = TryoutSoal::find($value);
                $benar = $soal->benar;
                $salah = $soal->salah;
                $kateogri = TryoutKategoriSoal::find($soal->tryout_kategori_soal_id);
                if (TryoutJawaban::find($request->jawaban[$value])->benar) {
                    $nilai_sekarang += $benar;
                    empty($hasil_detail[$kateogri->id]['nilai']) ? $hasil_detail[$kateogri->id]['nilai'] = $benar : $hasil_detail[$kateogri->id]['nilai'] += $benar;
                    empty($hasil_detail[$kateogri->id]['benar']) ? $hasil_detail[$kateogri->id]['benar'] = 1 : $hasil_detail[$kateogri->id]['benar'] += 1;
                } else {
                    $nilai_sekarang -= $salah;
                    empty($hasil_detail[$kateogri->id]['nilai']) ? $hasil_detail[$kateogri->id]['nilai'] = -$salah : $hasil_detail[$kateogri->id]['nilai'] -= $salah;
                    empty($hasil_detail[$kateogri->id]['salah']) ? $hasil_detail[$kateogri->id]['salah'] = 1 : $hasil_detail[$kateogri->id]['salah'] += 1;
                }

                $data_hasil->tryout_hasil_jawaban()->create([
                    'tryout_soal_id' => $value,
                    'tryout_jawaban_id' => $request->jawaban[$value]
                ]);
            }
        }

        // Set nilai Maksimal
        $all_soal = TryoutSoal::where('tryout_kategori_soal_id', $soal->tryout_kategori_soal_id)->get();
        foreach ($all_soal as $key => $value) {
            $nilai_maksimal += $value->benar;
        }
        foreach ($hasil_detail as $key => $value) {
            $total_soal = TryoutSoal::where('tryout_kategori_soal_id', $key)
                                    ->where('tryout_paket_id', $paket_id)
                                    ->count();
            TryoutHasilDetail::create([
                'tryout_paket_id' => $paket_id,
                'tryout_hasil_id' => $data_hasil->id,
                'tryout_kategori_soal_id' => $key,
                'user_id' => Auth::user()->id,
                'nilai' => $value['nilai'],
                'benar' => $value['benar'] ?? 0,
                'salah' => $value['salah'] ?? 0,
                'kosong' => $total_soal - (($value['benar'] ?? 0) + ($value['salah'] ?? 0)),
            ]);
        }
        $data_hasil->update([
            'nilai_awal' => $nilai_sekarang,
            'nilai_sekarang' => $nilai_sekarang,
            'nilai_maksimal' => $nilai_maksimal
        ]);
        $index_kategori = $request->session()->get('index_kategori');
        $kategori_id = $request->session()->get('kategori_id');
        if($index_kategori == (count($kategori_id) - 1)) {
            $request->session()->forget('kategori_id');
            $request->session()->forget('index_kategori');
            return redirect()->route('siswa.tryout.index')->with(['success' => "Termikasih telah melaksanakan tryout"]);
        } else {
            $index_sekarang = $index_kategori + 1;
            $request->session()->put('index_kategori', $index_sekarang);
        }
        return redirect()->route('tryout.mulai', $paket_slug)->withInput();
    }

    // End Tryout Baru

    // Analisa Tryout
    public function hasil(Request $request, $slug) {
        $paket = TryoutPaket::findSlug($slug);
        $tryout = TryoutHasil::with(['user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'])->where('user_id', auth()->user()->id)->where('tryout_paket_id', $paket->id)->first();
        $passing_grade = PassingGrade::with('universitas')->latest()->get();
        $saingan = TryoutHasil::where('tryout_paket_id', $paket->id)->with(['user'])->get();

        // Data Grafik User
        $nilai_by_user = TryoutHasil::with(['user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'])->where('user_id', auth()->user()->id)->get();
        $nilai_grafik = [];
        $nama_paket = [];
        foreach ($nilai_by_user as $key => $value) {
            $nilai_grafik[] = $value->nilai_awal;
            $nama_paket[] = $value->paket->nama;
        }

        // Data Grafik Saingan
        $nama_saingan = [];
        $nilai_saingan = [];
        foreach ($saingan as $key => $value) {
            $nama_saingan[] = $value->user->name;
            $nilai_saingan[] = $value->nilai_awal;
        }

        if($request->get('prodi-1') && $request->get('prodi-2')) {
            $pg1 = PassingGrade::find($request->get('prodi-1'));
            $pg2 = PassingGrade::find($request->get('prodi-2'));
            $nilai_awal = $tryout->nilai_awal;
            $nilai_max = $tryout->nilai_maksimal;
            $nilai_user = round($nilai_awal/$nilai_max * 100, 2);
        } else {
            $pg1 = $pg2 = $nilai_user = 0;
        }
        return view('pages.tryout.hasil-analisis.index', compact('tryout','paket', 'passing_grade', 'nama_saingan', 'nilai_saingan', 'pg1', 'pg2', 'nilai_user', 'nilai_grafik', 'nama_paket'));
    }
}
