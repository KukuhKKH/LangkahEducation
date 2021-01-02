<?php

namespace App\Http\Controllers\Web;

use App\Models\Siswa;
use App\Models\Mentor;
use App\Models\Komentar;
use App\Models\Mentoring;
use App\Models\TryoutSoal;
use App\Models\TryoutHasil;
use App\Models\TryoutPaket;
use App\Models\Universitas;
use App\Models\PassingGrade;
use Illuminate\Http\Request;
use App\Models\TryoutHasilJawaban;
use App\Http\Controllers\Controller;
use App\Models\KelompokPassingGrade;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MentoringController extends Controller
{
    public function __construct() {
        $this->middleware('role:mentor|superadmin|admin', ['only' => ['index', 'mentoring', 'komentar_store']]);
        $this->middleware('role:siswa', ['only' => ['siswa', 'pembahasan']]);
        $this->middleware('role:sekolah', ['only' => ['mentoring_sekolah']]);
    }

    // Mentoring mentor
    public function index(Request $request) {
        $data = $request->all();
        if($request->get('keyword') != '') {
            $mentor = Auth::user()->mentor()->first()->siswa()->whereHas('user', function($q) use($request) {
                $nama = $request->get('keyword');
                $q->where('name', 'LIKE', "%$nama%");
            })->paginate(10);
        } else {
            $mentor = Auth::user()->mentor()->first()->siswa()->paginate(10);
        }
        return view('pages.mentoring.mentor', compact('mentor', 'data'));
    }

    public function mentoring($id) {
        $user = auth()->user();
        $siswa = Siswa::find($id);
        $chat = Mentoring::where('siswa_id', $id)->where('mentor_id', $user->mentor->id)->get();
        Mentoring::where('siswa_id', $id)->where('mentor_id', $user->mentor->id)->where('pengirim', 'siswa')->update([
            'status' => 1
        ]);
        return view('pages.mentoring.index_mentor', compact('user', 'chat', 'siswa'));
    }

    // Mentoring Siswa
    public function siswa() {
        $user = auth()->user();
        $chat = Mentoring::where('siswa_id', $user->siswa->id)->get();
        if(count($user->siswa->mentor)> 0) {
            Mentoring::where('siswa_id', $user->siswa->id)->where('pengirim', 'mentor')->update([
                'status' => 1
            ]);
            return view('pages.mentoring.index', compact('user', 'chat'));
        } else {
            return redirect()->back()->with(['error' => 'Anda belum memiliki mentor']);
        }
    }

    public function pembahasan($paket_id, $kategori_id, $hasil_id) {
        try {
            $paket = TryoutSoal::with(['jawaban', 'paket'])->where('tryout_paket_id', $paket_id)->where('tryout_kategori_soal_id', $kategori_id)->get();
            $detail = TryoutHasil::find($hasil_id);
            $detail_jawaban = TryoutHasilJawaban::where('tryout_hasil_id', $detail->id)->get();
            $jawabanmu = [];
            foreach ($detail_jawaban as $key => $value) {
                $jawabanmu[] = $value->tryout_jawaban_id;
            }
            return view('pages.mentoring.pembahasan', compact('paket', 'jawabanmu'));
        }  catch(\Exception $e) {
            dd($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function kirim_pesan(Request $request, $siswa_id, $mentor_id) {
        try {
            Mentoring::create([
                'siswa_id' => $siswa_id,
                'mentor_id' => $mentor_id,
                'pengirim' => $request->pengirim,
                'pesan' => $request->pesan,
                'status' => 0,
            ]);
            return redirect()->back()->with(['success' => 'Berhasil mengirim pesan']);
        }  catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function hasil_tryout($id) {
        try {
            $hasil = TryoutHasil::with(['gelombang', 'paket.temp', 'user.siswa'])->where('user_id', $id)->get();
            return response()->json(['error' => false, 'data' => $hasil], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function hasil_tryout_detail(Request $request, $id, $slug, $user_id) {
        try {
            $paket = TryoutPaket::findSlug($slug);
            if($this->isFuture($paket->tgl_akhir)) {
                return redirect()->back()->with(['error' => 'Waktu Tryout Belum Selesai']);
            }
            $tryout = TryoutHasil::with([
                                    'user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'
                                ])
                                ->where('user_id', $user_id)
                                ->where('tryout_paket_id', $paket->id)
                                ->find($id);
            if($tryout->nilai_maksimal_new == 0) {
                return redirect()->back()->with(['error' => 'Tryout Belum Dikoreksi sistem']);
            }
            $raw_kelompok = $request->get('kelompok');
            if($raw_kelompok) {
                $kelompok = KelompokPassingGrade::find($raw_kelompok);
                $passing_grade = PassingGrade::with('universitas')->whereHas('kelompok', function($q) use($kelompok) {
                    $q->where('id', $kelompok->id);
                })->latest()->get();
            } else {
                $kelompok = '';
                $passing_grade = PassingGrade::with('universitas')->latest()->get();
            }
            $nilai_by_user = TryoutHasil::with(['user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'])->where('user_id', $user_id)->get();
            if($raw_kelompok) {
                if($raw_kelompok != 3) {
                    $nilai_by_user = TryoutHasil::with([
                                'user', 'tryout_hasil_jawaban', 'tryout_hasil_detail', 'paket.temp'
                                ])
                                ->whereHas('paket.temp', function($q) use($raw_kelompok, $user_id) {
                                    $q->where('kelompok_passing_grade_id', $raw_kelompok)->where('user_id', $user_id);
                                })->where('user_id', auth()->user()->id)->get();

                    $saingan = TryoutHasil::whereHas('paket.temp', function($q) use($raw_kelompok) {
                        $q->where('kelompok_passing_grade_id', $raw_kelompok);
                    })->where('tryout_paket_id', $paket->id)->with(['user'])->orderBy('nilai_awal', 'ASC')->get();
                }
            }
            $saingan = TryoutHasil::where('tryout_paket_id', $paket->id)->with(['user'])->get();

            // Data Grafik User
            $nilai_by_user = TryoutHasil::with([
                                    'user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'
                                ])
                                ->where('user_id', $tryout->user_id)->get();
            $user_siswa = User::find($tryout->user_id);
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
            } else {
                $pg1 = $pg2 = $nilai_user = $nil_pg1 = $nil_pg2 = 0;
            }
            $komentar = '';
            if(auth()->user()->getRoleNames()->first() == 'mentor') {
                $komentar = Komentar::where('mentor_id', auth()->user()->mentor()->first()->id)->where('tryout_hasil_id', $id)->first();
            }
            $kelompok_all = KelompokPassingGrade::all();
            $universitas = Universitas::all();
            return view('pages.mentoring.analisis_mentor', compact('tryout','paket', 'passing_grade', 'nama_saingan', 'nilai_saingan', 'pg1', 'pg2', 'nilai_user', 'nilai_grafik', 'nama_paket' ,'komentar', 'nil_pg1', 'nil_pg2', 'kelompok', 'kelompok_all', 'universitas', 'user_siswa'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function komentar_store(Request $request, $hasil_id) {
        $this->validate($request, [
            'komentar' => 'required|max:191'
        ]);
        try {
            Komentar::create([
                'mentor_id' => auth()->user()->mentor()->first()->id,
                'tryout_hasil_id' => $hasil_id,
                'komentar' => $request->komentar
            ]);
            return redirect()->back()->with(['success' => "Berhasil mengirim komentar"]);
        } catch(\Exception $e) {
            return redirect()->back(['error' => $e->getMessage()]);
        }
    }

    public function mentoring_sekolah() {
        $sekolah = Auth::user()->sekolah()->first();
        return view('pages.mentoring.sekolah', compact('sekolah'));
    }

    public function isFuture($time) {
        return (strtotime($time) > time());
    }
}
