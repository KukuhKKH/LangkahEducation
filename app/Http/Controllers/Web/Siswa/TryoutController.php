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
use App\Models\KelompokPassingGrade;
use App\Models\Komentar;
use App\Models\Pembayaran;
use App\Models\TempProdi;
use App\Models\Universitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TryoutController extends Controller
{
    public function index() {
        $user = Auth::user();
        $status_bayar = 0;
        $kosong = true;
        $sekolah = false;
        $produk_gelombang = [];
        $produk_sekolah = [];
        $raw_to_id_selesai = TryoutHasil::where('user_id', $user->id)->get();
        $paket_id_selesai = [];
        $gelombang_id_selesai = [];
        foreach ($raw_to_id_selesai as $key => $value) {
            $paket_id_selesai[] = $value->tryout_paket_id;
            $gelombang_id_selesai[] = $value->gelombang_id;
        }
        if($user->siswa->batch == 1) {
            $produk_sekolah = $user->siswa->sekolah->first()->gelombang;
            $cek_gelombang = Gelombang::wherehas('siswa', function($query) use($user) {
                $query->where('siswa_id', $user->siswa->id);
            })->whereHas('pembayaran', function($q) use($user) {
                $q->where('status', 2)->where('user_id', $user->id);
            })->get();

            // Jika membeli produk sendiri
            if(count($cek_gelombang) > 0) {
                $produk_gelombang = $cek_gelombang;
            }
            $status_bayar = 1;
        } else if($user->siswa->batch == 0) {
            $cek_gelombang = Gelombang::wherehas('siswa', function($query) use($user) {
                $query->where('siswa_id', $user->siswa->id);
            })->whereHas('pembayaran', function($q) use($user) {
                $q->where('status', 2)->where('user_id', $user->id);
            })->get();

            // Sudah Daftar Gelombang
            if(count($cek_gelombang) > 0) {
                $produk_gelombang = $cek_gelombang;
                // INI TIDAK JADI BRUH
                // 
                // $gelombang = $user->siswa->gelombang()->get()->pluck('id');
                // $id_gelombang = [];
                // foreach ($gelombang as $key => $value) {
                //     $pembayaran = Pembayaran::where('gelombang_id', $value)->where('user_id', $user->id)->first();
                //     if($pembayaran->status == 2) {
                //         $id_gelombang[] = $pembayaran->gelombang_id;
                //     }
                // }
                // $id_tryout = DB::table('gelombang_tryout')
                //                 ->select('tryout_paket_id')
                //                 ->whereIn('gelombang_id', $id_gelombang)->get()->pluck('tryout_paket_id');
                // $gelombang_data = Gelombang::whereIn('id', $id_gelombang)->with('tryout')->get();
                // // dd($gelombang_data);
                // $raw_paket = [];
                // foreach ($gelombang_data as $key => $value) {
                //     $raw_paket[] = $value->tryout;
                // }
                // $paket = [];
                // foreach ($raw_paket as $key => $value) {
                //     foreach ($value as $key2 => $value2) {
                //         $paket[] = $value2;
                //     }
                // }
                // dd($paket, $raw_paket);
                // $paket = TryoutPaket::whereIn('id', $id_tryout)->get();
                $status_bayar = 1;
            } else {
                $paket = [];
            }
        }
        $user_token = Crypt::encrypt($user->api_token);
        return view('pages.siswa.tryout.index',compact('produk_sekolah', 'produk_gelombang', 'kosong', 'status_bayar', 'user_token', 'paket_id_selesai', 'gelombang_id_selesai', 'sekolah'));
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
            return redirect()->route('siswa.tryout.index')->with(['success' => "Terima kasih telah melaksanakan tryout"]);
        // } catch(\Exception $e) {
        //     DB::rollback();
        //     return redirect()->route('siswa.tryout.index')->with(['error' => $e->getMessage()]);
        // }
    }
    // End Tryout Lama

    public function tryout_baru_detail(Request $request, $gelombang_id, $token, $slug) {
        try {
            $paket = TryoutPaket::findSlug($slug);
            $detail = DB::table('tryout_soal')
                            ->selectRaw('tryout_kategori_soal.nama as nama, count(tryout_soal.id) as total, tryout_kategori_soal.waktu as waktu, tryout_kategori_soal.tipe as tipe')
                            ->join('tryout_kategori_soal', 'tryout_soal.tryout_kategori_soal_id', '=', 'tryout_kategori_soal.id', 'LEFT')
                            ->where('tryout_paket_id', $paket->id)
                            ->orderBy('tryout_kategori_soal.tipe', 'DESC')
                            ->groupBy('tryout_soal.tryout_kategori_soal_id')
                            ->get();
            $user_token = $token;
            $kelompok = KelompokPassingGrade::all();
            $universitas = Universitas::all();
            $gelombang_id = $gelombang_id;
            return view('tryout.detail',compact('detail', 'paket', 'user_token', 'universitas', 'kelompok', 'gelombang_id'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show Tryout baru
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function tryout_baru(Request $request, $gelombang_id, $token, $slug) {
        $yt = "";
        try {
            $gelombang_id = $gelombang_id;
            $cek_token = Crypt::decrypt($token);
            if(auth()->user()->api_token == $cek_token) {
                $paket = TryoutPaket::findSlug($slug);
                if($request->get('prodi-1')) {
                    TempProdi::updateOrCreate([
                        'paket_id' => $paket->id,
                        'gelombang_id' => $gelombang_id,
                        'user_id' => auth()->user()->id,
                        'passing_grade_id' => $request->get('prodi-1'),
                        'kelompok_passing_grade_id' => $request->get('kelompok'),
                    ], [
                        'paket_id' => $paket->id,
                        'gelombang_id' => $gelombang_id,
                        'user_id' => auth()->user()->id,
                        'passing_grade_id' => $request->get('prodi-1'),
                        'kelompok_passing_grade_id' => $request->get('kelompok'),
                    ]);
                    TempProdi::updateOrCreate([
                        'paket_id' => $paket->id,
                        'gelombang_id' => $gelombang_id,
                        'user_id' => auth()->user()->id,
                        'passing_grade_id' => $request->get('prodi-2'),
                        'kelompok_passing_grade_id' => $request->get('kelompok'),
                    ], [
                        'paket_id' => $paket->id,
                        'gelombang_id' => $gelombang_id,
                        'user_id' => auth()->user()->id,
                        'passing_grade_id' => $request->get('prodi-2'),
                        'kelompok_passing_grade_id' => $request->get('kelompok'),
                    ]);
                }
                $index = 0;
                if($request->session()->has($gelombang_id.'-'.$slug.'-'."kelompok_passing_grade")) {
                    $kelompok_passing_grade = $request->session()->has($gelombang_id.'-'.$slug.'-'."kelompok_passing_grade");
                } else {
                    $request->session()->put($gelombang_id.'-'.$slug.'-'."kelompok_passing_grade", $request->get('kelompok'));
                }
                if($request->session()->has($gelombang_id.'-'.$slug.'-'."index_kategori")) {
                    $index = $request->session()->get($gelombang_id.'-'.$slug.'-'."index_kategori");
                } else {
                    $request->session()->put($gelombang_id.'-'.$slug.'-'."index_kategori", $index);
                }
                if(!$request->session()->has($gelombang_id.'-'.$slug.'-'.'kategori_id')) {
                    $kelompok = KelompokPassingGrade::find($request->get('kelompok'));
                    if($kelompok->nama == 'saintek') {
                        $kategori_soal_id = TryoutKategoriSoal::where('tipe', 'umum')->orWhere('tipe', 'saintek')->orderBy('tipe', 'DESC')->get()->pluck('id')->toArray();
                    } elseif($kelompok->nama == 'soshum') {
                        $kategori_soal_id = TryoutKategoriSoal::where('tipe', 'umum')->orWhere('tipe', 'soshum')->orderBy('tipe', 'DESC')->get()->pluck('id')->toArray();
                    } else {
                        $kategori_soal_id = TryoutKategoriSoal::all()->pluck('id')->toArray();
                    }
                    $raw_kategori_id = $paket->soal()
                                        ->distinct()
                                        ->select('tryout_kategori_soal_id')
                                        ->whereIn('tryout_kategori_soal_id', $kategori_soal_id)
                                        ->get()->pluck('tryout_kategori_soal_id')
                                        ->toArray();
                    $inter_kategori_id = array_intersect($kategori_soal_id, $raw_kategori_id);
                    $kategori_id = [];
                    foreach($inter_kategori_id as $key => $value) {
                        $kategori_id[] = $value;
                    }
                    $request->session()->put($gelombang_id.'-'.$slug.'-'.'kategori_id', $kategori_id);
                } else {
                    $kategori_id = $request->session()->get($gelombang_id.'-'.$slug.'-'.'kategori_id');
                }
                if($index > 0) {
                    $temp_index = $index;
                    $kategori_satu = TryoutKategoriSoal::find($kategori_id[$temp_index])->tipe;
                    $kategori_dua = TryoutKategoriSoal::find($kategori_id[$temp_index - 1])->tipe;
                    if($kategori_satu != $kategori_dua) {
                        if(empty($request->get('lanjut'))) {
                            $waktu = 10;
                            $user_token = $token;
                            if($kategori_satu == 'saintek') {
                                // $yt = "https://www.youtube.com/embed/tgbNymZ7vqY?autoplay=1";
                                $yt = $paket->url_youtube_saintek;
                            } else {
                                // $yt = "https://www.youtube.com/embed/tgbNymZ7vqY?autoplay=1";
                                $yt = $paket->url_youtube_soshum;
                            }
                            return view('tryout.jeda', compact('gelombang_id', 'paket', 'waktu', 'user_token', 'yt'));
                        }
                    }
                }
                $cek = $paket->whereHas('hasil', function($q) {
                    $q->where('user_id', auth()->user()->id);
                })->get();
                // if(count($cek) > 0) {
                //     return redirect()->back()->with(['error' => 'Anda sudah mengerjakan tryout ini']);
                // } else {
                    $soal = TryoutSoal::where('tryout_paket_id', $paket->id)
                                        // ->inRandomOrder()
                                        ->where('tryout_kategori_soal_id', $kategori_id[$index])
                                        ->get();
                    $waktu = TryoutKategoriSoal::where('id', $kategori_id[$index])->first()->waktu;
                    return view('tryout.new', compact('soal', 'paket', 'waktu', 'gelombang_id'));
                // }
            } else {
                return redirect()->route('siswa.tryout.index')->with(['error' => 'Link tidak valid']);
            }
        } catch(\Exception $e) {
            dd($e);
            if($e->getMessage() == 'The payload is invalid.') {
                return redirect()->route('siswa.tryout.index')->with(['error' => 'Link tidak valid'])->withInput();
            }
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function tryout_store_baru(Request $request, $gelombang_id, $paket_slug) {
        $paket_id = TryoutPaket::findSlug($paket_slug)->id;

        $data_hasil = Auth::user()->tryout_hasil()->firstOrCreate([
            'tryout_paket_id' => $paket_id,
            'gelombang_id' => $gelombang_id,
        ],[
            'kelompok_passing_grade_id' => $request->session()->get($gelombang_id.'-'.$paket_slug.'-'."kelompok_passing_grade"),
            'nilai_awal' => 0,
            'nilai_sekarang' => 0,
            'nilai_maksimal' => 0
        ]);
        $nilai_sekarang = $data_hasil->nilai_sekarang ?? 0;
        $nilai_maksimal = $data_hasil->nilai_maksimal ?? 0;
        $hasil_detail = [];
        
        $kosong = false;
        $kosong_asli = false;
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
                $kosong = false;
                $kosong_asli = true;
            } else {
                $kosong = true;
            }
        }

        // Set nilai Maksimal
        if($kosong == false && $kosong_asli = true) {
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
                'nilai_sekarang' => 0,
                'nilai_maksimal' => $nilai_maksimal
            ]);
        }
            
        $index_kategori = $request->session()->get($gelombang_id.'-'.$paket_slug.'-'."index_kategori");
        $kategori_id = $request->session()->get($gelombang_id.'-'.$paket_slug.'-'.'kategori_id');
        if($index_kategori == (count($kategori_id) - 1)) {
            $request->session()->forget($gelombang_id.'-'.$paket_slug.'-'.'kategori_id');
            $request->session()->forget($gelombang_id.'-'.$paket_slug.'-'."index_kategori");
            $request->session()->forget($gelombang_id.'-'.$paket_slug.'-'."kelompok_passing_grade");
            return redirect()->route('siswa.tryout.index')->with(['success' => "Terima kasih telah melaksanakan tryout"]);
        } else {
            $index_sekarang = $index_kategori + 1;
            $request->session()->put($gelombang_id.'-'.$paket_slug.'-'."index_kategori", $index_sekarang);
        }
        $user_token = Crypt::encrypt(Auth::user()->api_token);
        return redirect()->route('tryout.mulai', ['gelombang_id' => $gelombang_id, 'slug' => $paket_slug, 'token' => $user_token])->withInput();
    }

    // End Tryout Baru

    // Analisa Tryout
    public function hasil(Request $request, $gelombang_id, $slug) {
        try {
            $user = auth()->user();
            $paket = TryoutPaket::findSlug($slug);
            // dd($this->isFuture($paket->tgl_akhir));
            if($this->isFuture($paket->tgl_akhir)) {
                return redirect()->back()->with(['error' => 'Waktu tryout belum selesai']);
            }
            if($paket->koreksi) {
                $tryout = TryoutHasil::with(['user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'])
                                    ->where('user_id', auth()->user()->id)
                                    ->where('tryout_paket_id', $paket->id)
                                    ->where('gelombang_id', $gelombang_id)->first();
                if($tryout->nilai_maksimal_new == 0) {
                    return redirect()->back()->with(['error' => 'Tryout belum dikoreksi sistem']);
                }
                if(count($user->siswa->mentor) > 0) {
                    $komentar = Komentar::where('tryout_hasil_id', $tryout->id)
                                        ->where('mentor_id', $user->siswa->mentor()->first()->id)
                                        ->first();
                    if($komentar) {
                        $komentar->update([
                            'status' => 1
                        ]);
                    }
                }
                $raw_kelompok = $request->get('kelompok');
                $tryout_kategori_soal = [];
                if($raw_kelompok) {
                    $kelompok = KelompokPassingGrade::find($raw_kelompok);
                    $passing_grade = PassingGrade::with('universitas')->whereHas('kelompok', function($q) use($kelompok) {
                        $q->where('id', $kelompok->id);
                    })->latest()->get();
                    if($kelompok->nama == 'saintek') {
                        $kategori_soal_id = TryoutKategoriSoal::where('tipe', 'umum')->orWhere('tipe', 'saintek')->get()->pluck('id');
                    } elseif($kelompok->nama == 'soshum') {
                        $kategori_soal_id = TryoutKategoriSoal::where('tipe', 'umum')->orWhere('tipe', 'soshum')->get()->pluck('id');
                    } else {
                        $kategori_soal_id = TryoutKategoriSoal::all()->pluck('id');
                    }
                } else {
                    $kelompok = '';
                    $passing_grade = PassingGrade::with('universitas')->latest()->get();
                }
                $id_soal_kategori = TryoutSoal::where('tryout_paket_id', $paket->id)->distinct()->pluck('tryout_kategori_soal_id')->toArray();
                $result_kategori_id = array_intersect($kategori_soal_id->toarray(), $id_soal_kategori);
                // $saingan = TryoutHasil::where('tryout_paket_id', $paket->id)->with(['user'])->orderBy('nilai_awal', 'ASC')->get();
                $tryout_kategori_soal = TryoutKategoriSoal::orderBy('tipe', 'DESC')->whereIn('id', $result_kategori_id)->get();
                $hasil_to_kategori_id = $tryout->tryout_hasil_detail()->pluck('tryout_kategori_soal_id')->toArray();
                // Data Grafik Userra
                $nilai_by_user = TryoutHasil::with(['user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'])->where('user_id', auth()->user()->id)->get();
                if($raw_kelompok) {
                    if($raw_kelompok != 3) {
                        $nilai_by_user = TryoutHasil::with([
                                    'user', 'tryout_hasil_jawaban', 'tryout_hasil_detail', 'paket.temp'
                                    ])
                                    ->whereHas('paket.temp', function($q) use($raw_kelompok, $user) {
                                        $q->where('kelompok_passing_grade_id', $raw_kelompok)->where('user_id', $user->id);
                                    })->where('user_id', auth()->user()->id)->get();
                        // dd($raw_kelompok, $nilai_by_user);

                        $saingan = TryoutHasil::where('kelompok_passing_grade_id', $raw_kelompok)->where('gelombang_id', $gelombang_id)->where('tryout_paket_id', $paket->id)->with(['user'])->orderBy('nilai_awal', 'ASC')->get();
                    }
                }
                // dd($saingan);
                
                $nilai_grafik = [];
                $nama_paket = [];
                foreach ($nilai_by_user as $key => $value) {
                    if($value->nilai_maksimal_new > 0) {
                        $nilai_grafik[] = round(($value->nilai_sekarang/$value->nilai_maksimal_new)*100, 2);
                        $nama_paket[] = $value->paket->nama;
                    }
                }
    
                // Data Grafik Saingan
                $nama_saingan = [];
                $nilai_saingan = [];
                foreach ($saingan as $key => $value) {
                    $nama_saingan[] = $value->user->name;
                    $nilai_saingan[] = $value->nilai_sekarang;
                }
    
                if($request->get('prodi-1') && $request->get('prodi-2')) {
                    $pg1 = PassingGrade::find($request->get('prodi-1'));
                    $pg2 = PassingGrade::find($request->get('prodi-2'));
                    $nilai_awal = (int)$tryout->nilai_sekarang;
                    $nilai_max = (int)$tryout->nilai_maksimal_new;
                    $nilai_user = round($nilai_awal/$nilai_max * 100, 2);
                    $nilai_pg1 = (double)trim($pg1->passing_grade);
                    $nilai_pg2 = (double)trim($pg2->passing_grade);
                    // $nil_pg1 = ($nilai_pg1/100)*$nilai_max;
                    // $nil_pg2 = ($nilai_pg2/100)*$nilai_max;
                    $nil_pg1 = $nilai_pg1;
                    $nil_pg2 = $nilai_pg2;
                    $raw_temp = TempProdi::where('gelombang_id', $gelombang_id)->where('paket_id', $paket->id)->where('user_id', $user->id)->get();
                    $raw_temp[0]->update([
                        'passing_grade_id' => $request->get('prodi-1')
                    ]);
                    $raw_temp[1]->update([
                        'passing_grade_id' => $request->get('prodi-2')
                    ]);
                } else {
                    $pg1 = $pg2 = $nilai_user = $nil_pg1 = $nil_pg2 = 0;
                }
                $komentar = Komentar::where('tryout_hasil_id', $tryout->id)->first();
                $kelompok_all = KelompokPassingGrade::all();
                $universitas = Universitas::all();
                $gelombang = Gelombang::find($gelombang_id);
                return view('pages.tryout.hasil-analisis.index', compact('tryout','paket', 'passing_grade', 'nama_saingan', 'nilai_saingan', 'pg1', 'pg2', 'nilai_user', 'nilai_grafik', 'nama_paket', 'komentar', 'nil_pg1', 'nil_pg2', 'kelompok', 'kelompok_all', 'universitas', 'tryout_kategori_soal', 'hasil_to_kategori_id', 'gelombang'));
            } else {
                return redirect()->back()->with(['error' => 'Tryout belum dikoreksi sistem']);
            }
        } catch(\Exception $e) {
            // dd($e);
            return redirect()->route('siswa.tryout.index')->with(['error' => 'URL tidak valid']);
        }
    }

    // Koreksi Sistem baru

    public function koreksi_tryout_super_baru($gelombang_id, $paket_id) {
        $paket = TryoutPaket::find($paket_id);
        // $hasil = TryoutHasil::where('gelombang_id', $gelombang_id)->where('tryout_paket_id', $paket_id)->first();
        // $detail = $hasil->tryout_hasil_jawaban()->with(['hasil.user', 'soal.kategori_soal' => function($q) {
        //         $q->orderBy('tipe', 'DESC');
        //     }])->get();
        // foreach($detail as $value) {
        //     echo $value->soal->kategori_soal->nama;
        //     echo "<br>";
        // }
        // die;
        
        $hasil = TryoutHasil::where('gelombang_id', $gelombang_id)->where('tryout_paket_id', $paket_id)->get();
        $detail = [];
        foreach ($hasil as $key => $value) {
            $detail[] = $value->tryout_hasil_jawaban()->with(['hasil.user', 'soal.kategori_soal' => function($q) {
                                    $q->orderBy('tipe', 'DESC');
                                }])
                                ->orderBy('tryout_soal_id', 'ASC')
                                ->groupBy('tryout_soal_id')
                                ->get();
        }
        $id_soal = TryoutSoal::where('tryout_paket_id', $paket->id)->get()->pluck('id')->toArray();
        $id_soal_saintek = TryoutSoal::whereHas('kategori_soal', function($q) {
            $q->where('tipe', 'umum')->orwhere('tipe', 'saintek')->orderBy('tipe', 'DESC');
        })->where('tryout_paket_id', $paket->id)->get()->pluck('id')->toArray();
        $id_soal_soshum = TryoutSoal::whereHas('kategori_soal', function($q) {
            $q->where('tipe', 'umum')->orwhere('tipe', 'soshum')->orderBy('tipe', 'DESC');
        })->where('tryout_paket_id', $paket->id)->get()->pluck('id')->toArray();
        $data = [];
        $i = 0;

        $indeks_detail = 0;
        $user_id = 0;
        foreach ($detail as $key => $value) {
            $kategori_to = TryoutHasil::find($value[0]->tryout_hasil_id)->kelompok_passing_grade_id;
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
            // dd($value->pluck('soal.id')->toArray());

            for ($i=0; $i < $total_jawaban; $i++) {
                if(isset($value[$i])) {
                    $user_id = $value[$i]->hasil->user_id;
                    if($id_soal[$i] != $value[$i]->tryout_soal_id) {
                        $temp_raw = [
                            'status' => 'kosong',
                            'user_id' => $user_id,
                            'kategori_soal_id' => $value[$i]->soal->tryout_kategori_soal_id ?? ''
                        ];
                        $raw_splice = (object) $temp_raw;
                        // array_splice($detail[$indeks_detail], $i, 0, [$raw_splice]);
                        $detail[$indeks_detail]->splice($i, 0, [$raw_splice]);
                    }
                } else {
                    if(isset($value[$i-1]->hasil)) {
                        $temp_raw = [
                            'status' => 'kosong',
                            'user_id' => $user_id,
                            'kategori_soal_id' => $value[$i]->soal->tryout_kategori_soal_id ?? ''
                        ];
                        $raw_splice = (object) $temp_raw;
                        $detail[$indeks_detail]->splice($i, 0, [$raw_splice]);
                    } else {
                        $temp_raw = [
                            'status' => 'kosong',
                            'user_id' => $user_id,
                            'kategori_soal_id' => $value[$i]->soal->tryout_kategori_soal_id ?? ''
                        ];
                        $raw_splice = (object) $temp_raw;
                        $detail[$indeks_detail]->splice($i, 0, [$raw_splice]);
                    }
                }
            }
            $user_id = 0;
            $indeks_detail++;
        }

        $raw_jumlah = [];
        $raw_benar = [];
        $raw_presentase = [];
        $raw_poin = [];
        
        // Normalisasi benar jadi 1 salah / kosong jadi 0
        foreach ($detail as $key => $value) {
            if($value->first()->status) {
                $user_id = $value->first()->user_id;
            } else {
                $user_id = $value->first()->hasil->user_id;
            }
            $kategori_to = TempProdi::where('gelombang_id', $gelombang_id)->where('paket_id', $paket_id)->where('user_id', $user_id)->first()->kelompok_passing_grade_id;
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
                // empty($id_user) ? $id_user = $value[$i]->hasil->user_id : $id_user = $id_user;
                empty($id_user) ? $id_user = $user_id : $id_user = $id_user;
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
                if(empty($raw_jumlah[$k])) {
                    $raw_jumlah[$k] = 1;
                } else {
                    $raw_jumlah[$k] += 1;
                }

                if(empty($raw_benar[$k])) {
                    if($v == 1) {
                        $raw_benar[$k] = 1;
                    } else {
                        $raw_benar[$k] = 0;
                    }
                } else {
                    if($v == 1) {
                        $raw_benar[$k] += 1;
                    }
                }
            }
        }
        
        foreach ($raw_benar as $key => $value) {
            if($raw_jumlah[$key] != 1){
                $raw_presentase[$key] = ceil($raw_benar[$key]/$raw_jumlah[$key] * 100);
            }else{
                $raw_presentase[$key] = 50;
            }
        }
        
        // Menghitung Poin setiap soal bwang
        foreach ($raw_presentase as $key => $value) {
            if($value >= 0 && $value <= $paket->poin_4) {
                $raw_poin[$key] = 4;
            } elseif($value > $paket->poin_4 && $value <= $paket->poin_3) {
                $raw_poin[$key] = 3;
            } elseif($value > $paket->poin_3 && $value <= $paket->poin_2) {
                $raw_poin[$key] = 2;
            } elseif($value > $paket->poin_2 && $value <= $paket->poin_1) {
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
            // $temp_nilai = 0;
            // $temp_benar = 0;
            // $temp_salah = 0;
            // $temp_soal = 0;
            // $temp_kosong = 0;
            $data_detail = [];
            $temp_id_kategori = null;
            $user_id = null;
            $raw_tryout_hasil_id = null;
            foreach ($value as $k => $v) {
                // dd($value);
                if($v->status == 'kosong') {
                    $user_id = $v->user_id;
                    if($v->kategori_soal_id) {
                        $kategori_soal_sementara = $v->kategori_soal_id;
                    } else {
                        $kategori_soal_sementara = $temp_id_kategori;
                    }
                    empty($data_detail[$kategori_soal_sementara]['temp_soal']) ? $data_detail[$kategori_soal_sementara]['temp_soal'] = 1 : $data_detail[$kategori_soal_sementara]['temp_soal'] += 1;
                    // $temp_soal += 1;
                } else {
                    $raw_tryout_hasil_id = $v->tryout_hasil_id;
                    if($k > 0) {
                        if($temp_id_kategori != $v->soal->tryout_kategori_soal_id) {
                            // $temp_nilai = 0;
                            // $temp_benar = 0;
                            // $temp_salah = 0;
                            // $temp_soal = 0;
                        }
                    }
                    $user_id = $v->hasil->user_id;
                    $kategori_soal_id = $v->soal->kategori_soal->id;
                    $temp_id_kategori = $kategori_soal_id;
                    if(TryoutJawaban::find($v->tryout_jawaban_id)->benar) {
                        empty($data_detail[$kategori_soal_id]['temp_nilai']) ? $data_detail[$kategori_soal_id]['temp_nilai'] = $raw_poin[$v->tryout_soal_id] : $data_detail[$kategori_soal_id]['temp_nilai'] += $raw_poin[$v->tryout_soal_id];
                        empty($data_detail[$kategori_soal_id]['temp_benar']) ? $data_detail[$kategori_soal_id]['temp_benar'] = 1 : $data_detail[$kategori_soal_id]['temp_benar'] += 1;
                        empty($data_detail[$kategori_soal_id]['temp_soal']) ? $data_detail[$kategori_soal_id]['temp_soal'] = 1 : $data_detail[$kategori_soal_id]['temp_soal'] += 1;
                        // $temp_nilai += $raw_poin[$v->tryout_soal_id];
                        // $temp_benar += 1;
                        // $temp_soal += 1;
                    } else {
                        empty($data_detail[$kategori_soal_id]['temp_nilai']) ? $data_detail[$kategori_soal_id]['temp_nilai'] = -$v->soal->salah : $data_detail[$kategori_soal_id]['temp_nilai'] -= $v->soal->salah;
                        empty($data_detail[$kategori_soal_id]['temp_salah']) ? $data_detail[$kategori_soal_id]['temp_salah'] = 1 : $data_detail[$kategori_soal_id]['temp_salah'] += 1;
                        empty($data_detail[$kategori_soal_id]['temp_soal']) ? $data_detail[$kategori_soal_id]['temp_soal'] = 1 : $data_detail[$kategori_soal_id]['temp_soal'] += 1;
                        // $temp_nilai -= $v->soal->salah;
                        // $temp_salah += 1;
                        // $temp_soal += 1;
                    }
                    if(isset($data_detail[$kategori_soal_id]['temp_benar']) && isset($data_detail[$kategori_soal_id]['temp_salah'])) {
                        $data_detail[$kategori_soal_id]['temp_kosong'] = $data_detail[$kategori_soal_id]['temp_soal'] - ($data_detail[$kategori_soal_id]['temp_benar'] + $data_detail[$kategori_soal_id]['temp_salah']);
                    }
                }
                if($user_id == 2650) {
                    dd($data_detail);
                }
                // isset($temp_detail[$kategori_soal_id]) ? $temp_detail[$kategori_soal_id] = $temp_detail[$kategori_soal_id] : $temp_detail[$kategori_soal_id] = [];
                // $data_detail[$kategori_soal_id]['temp_kosong'] = $data_detail[$kategori_soal_id]['temp_soal'] - ($data_detail[$kategori_soal_id]['temp_benar'] + $data_detail[$kategori_soal_id]['temp_salah']);
                
                // $temp_detail[$user_id][$kategori_soal_id] = $temp_nilai;
                
                // $data_detail['kategori_soal_id'] = $kategori_soal_id;
                // $data_detail['temp_nilai'] = $temp_nilai;
                // $data_detail['temp_benar'] = $temp_benar;
                // $data_detail['temp_salah'] = $temp_salah;
                // $data_detail['temp_kosong'] = $temp_kosong;
                
                // array_push($temp_detail[$user_id], $data_detail);
            }
            
            // $total = count($temp_detail[$user_id]);
            // foreach($temp_detail[$user_id] as $key => $value){
            //     if($total - 1 > $key) {
            //         if($value['kategori_soal_id'] == $temp_detail[$user_id][$key+1]['kategori_soal_id']) {
            //             unset($temp_detail[$user_id][$key]);
            //         }
            //     }
            // }
            // $nilai_sekarang[$user_id] = 0;
            // foreach($temp_detail[$user_id] as $key => $value){
            //     $nilai_sekarang[$user_id] += $value['temp_nilai'];
            // }
            
            // $nilai_sekarang[$user_id] = \array_sum($temp_detail[$user_id]['temp_nilai']);
            // $nilai_sekarang[$user_id] = $temp_nilai;
            // Harus e di sini Update Nilai mulai detail sama hasil detail
            // Update Detail per kategori
            // if($user_id == 97) {
                // dd($value);
                // dd($temp_detail[$user_id]);
            // }
            foreach ($data_detail as $key => $value) {
                // TryoutHasilDetail::where('tryout_paket_id', $paket_id)
                //             ->where('tryout_kategori_soal_id', $key)
                //             ->where('user_id', $user_id)
                //             ->update([
                //                 'nilai' => $value
                //             ]);
                $total_soal = TryoutSoal::where('tryout_paket_id', $paket_id)->where('tryout_kategori_soal_id', $key)->count();
                $total_benar = $value['temp_benar'] ?? 0;
                $total_salah = $value['temp_salah'] ?? 0;
                TryoutHasilDetail::updateOrCreate([
                    'tryout_paket_id' => $paket_id,
                    'tryout_kategori_soal_id' => $key,
                    'user_id' => $user_id,
                    'tryout_hasil_id' => $raw_tryout_hasil_id
                ], [
                    'benar' => $total_benar,
                    'salah' => $total_salah,
                    'kosong' => $total_soal - ($total_benar + $total_salah),
                    'nilai' => $value['temp_nilai']
                ]);
            }
            $kategori_to = TempProdi::where('gelombang_id', $gelombang_id)
                            ->where('paket_id', $paket_id)
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
            $nilai_user_iki_bro = TryoutHasilDetail::where('tryout_paket_id', $paket_id)
                            ->where('user_id', $user_id)
                            ->where('tryout_hasil_id', $raw_tryout_hasil_id)
                            ->groupBy('tryout_kategori_soal_id')->get();
            $nilai_sekarang[$user_id] = 0;
            foreach($nilai_user_iki_bro as $value) {
                 $nilai_sekarang[$user_id] += $value['nilai'];
            }
            TryoutHasil::where('gelombang_id', $gelombang_id)
                            ->where('tryout_paket_id', $paket_id)
                            ->where('user_id', $user_id)
                            ->update([
                                'nilai_sekarang' => $nilai_sekarang[$user_id],
                                'nilai_maksimal_new' => $nilai_maksimal[$index_nilai_max]
                            ]);
        }
        TryoutPaket::find($paket_id)->update([
            'koreksi' => 1
        ]);
        $nama_gelombang = Gelombang::find($gelombang_id)->nama;
        return redirect()->back()->with(['success' => "Paket $paket->nama pada gelombang $nama_gelombang berhasil dikoreksi"]);
    }

    public function riwayat_tryout() {
        $user = auth()->user();
        $riwayat = TryoutHasil::with(['user', 'paket', 'gelombang'])->where('user_id', $user->id)->latest()->paginate(9);
        return view('pages.siswa.tryout.riwayat', compact('riwayat'));
    }

    public function isFuture($time) {
        return (strtotime($time) > time());
    }
}
