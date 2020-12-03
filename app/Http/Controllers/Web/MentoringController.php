<?php

namespace App\Http\Controllers\Web;

use App\Models\Siswa;
use App\Models\Mentor;
use App\Models\Mentoring;
use App\Models\TryoutHasil;
use App\Models\TryoutPaket;
use App\Models\PassingGrade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;

class MentoringController extends Controller
{
    public function __construct() {
        $this->middleware('role:mentor|superadmin|admin', ['only' => ['index', 'mentoring', 'hasil_tryout_detail', 'komentar_store']]);
        $this->middleware('role:siswa', ['only' => ['siswa']]);
    }

    // Mentoring mentor
    public function index() {
        $mentor = Auth::user()->mentor()->first();
        return view('pages.mentoring.mentor', compact('mentor'));
    }

    public function mentoring($id) {
        $user = auth()->user();
        $siswa = Siswa::find($id);
        $chat = Mentoring::where('siswa_id', $id)->where('mentor_id', $user->mentor->id)->get();
        return view('pages.mentoring.index_mentor', compact('user', 'chat', 'siswa'));
    }

    // Mentoring Siswa
    public function siswa() {
        $user = auth()->user();
        $chat = Mentoring::where('siswa_id', $user->siswa->id)->get();
        if(count($user->siswa->mentor)> 0) {
            return view('pages.mentoring.index', compact('user', 'chat'));
        } else {
            return redirect()->back()->with(['error' => 'Anda belum memiliki mentor']);
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
            $hasil = TryoutHasil::with(['paket.temp', 'user.siswa'])->where('user_id', $id)->get();
            return response()->json(['error' => false, 'data' => $hasil], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function hasil_tryout_detail(Request $request, $id, $slug) {
        try {
            $paket = TryoutPaket::findSlug($slug);
            $tryout = TryoutHasil::with([
                                    'user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'
                                ])
                                // ->where('user_id', $id)
                                // ->where('tryout_paket_id', $paket->id)
                                ->find($id);
            $passing_grade = PassingGrade::with('universitas')->latest()->get();
            $saingan = TryoutHasil::where('tryout_paket_id', $paket->id)->with(['user'])->get();

            // Data Grafik User
            $nilai_by_user = TryoutHasil::with([
                                    'user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'
                                ])
                                ->where('user_id', $tryout->user_id)->get();
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
            $komentar = '';
            if(auth()->user()->getRoleNames()->first() == 'mentor') {
                $komentar = Komentar::where('mentor_id', auth()->user()->mentor()->first()->id)->where('tryout_hasil_id', $id)->first();
            }
            return view('pages.mentoring.analisis_mentor', compact('tryout','paket', 'passing_grade', 'nama_saingan', 'nilai_saingan', 'pg1', 'pg2', 'nilai_user', 'nilai_grafik', 'nama_paket' ,'komentar'));
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
}
