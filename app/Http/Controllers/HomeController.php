<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\TempProdi;
use App\Models\Pembayaran;
use App\Models\TryoutHasil;
use App\Models\PassingGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\StatistikPengunjung;
use App\Models\KelompokPassingGrade;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['verifyUserRegistration']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard(Request $request) {
        $user = Auth::user();
        // dd($user->getRoleNames()->first());
        if($user->getRoleNames()->first() == 'superadmin' || $user->getRoleNames()->first() == 'admin') {
            $sekolah = Sekolah::count();
            $siswa = Siswa::count();
            $belum_bayar = Pembayaran::where('status', 0)->count();
            $pengunjung = StatistikPengunjung::whereDate('created_at', Carbon::today())->count();
            // ->whereMonth('created_at', date('m')) ->groupByRaw("MONTH(created_at)")
            $raw_grafik = StatistikPengunjung::selectRaw("count(id) as total, DAY(created_at) as tanggal")
            ->whereMonth('created_at', date('m'))->groupByRaw("DAY(created_at)")->get()->toArray();
            $bulan = date('F');
            $label = [];
            $total = [];
            foreach ($raw_grafik as $key => $value) {
                $label[] = $value['tanggal']. " $bulan";
                $total[] = $value['total'];
            }
            return view('pages.dashboard', compact('sekolah', 'siswa', 'belum_bayar', 'pengunjung', 'label', 'total'));
        } elseif($user->getRoleNames()->first() == 'siswa') {
            $pg1 = $pg2 = $nilai_user = $nil_pg1 = $nil_pg2 = 0;
            $nilai_grafik = [];
            $nama_paket = [];
            $kelompok = TempProdi::where('user_id', $user->id)->first();
            $passing_grade = [];
            $nilai_by_user = TryoutHasil::with(['user', 'paket', 'tryout_hasil_jawaban', 'tryout_hasil_detail'])->where('user_id', auth()->user()->id)->get();
            if(count($nilai_by_user) > 0) {
                foreach ($nilai_by_user as $key => $value) {
                    $nilai_grafik[] = $value->nilai_awal;
                    $nama_paket[] = $value->paket->nama;
                }
            }
            if($kelompok) {
                $passing_grade = PassingGrade::where('kelompok_id', $kelompok->kelompok_passing_grade_id)->get();
                if($request->get('prodi-1') && $request->get('prodi-2')) {
                    $pg1 = PassingGrade::find($request->get('prodi-1'));
                    $pg2 = PassingGrade::find($request->get('prodi-2'));
                    $nilai_awal = $nilai_by_user->first()->nilai_awal;
                    $nilai_max = $nilai_by_user->first()->nilai_maksimal;
                    $nilai_user = round($nilai_awal/$nilai_max * 100, 2);
                    $nil_pg1 = ($pg1->passing_grade/100)*$nilai_max;
                    $nil_pg2 = ($pg2->passing_grade/100)*$nilai_max;
                }
            }
            return view('pages.dashboard', compact('kelompok', 'passing_grade', 'nilai_grafik', 'nama_paket', 'pg1', 'pg2', 'nilai_user', 'nil_pg1', 'nil_pg2'));
        } elseif($user->getRoleNames()->first() == 'mentor') {
            $user = auth()->user();
            $total_siswa = $user->mentor->siswa()->count();
            // Iki user_id tapi seng tergabung pada mentor
            $id_siswa = [];
            foreach($user->mentor->siswa as $key => $value) {
                $id_siswa[] = $value->user_id;
            }
            $grafik =  DB::table('temp_prodi_tryout')
                            ->selectRaw("COUNT(temp_prodi_tryout.id) AS total, kelompok_passing_grade.nama")
                            ->join('kelompok_passing_grade', 'temp_prodi_tryout.kelompok_passing_grade_id', '=', 'kelompok_passing_grade.id', 'LEFT')
                            ->whereIn('user_id', $id_siswa)
                            ->groupBy('kelompok_passing_grade_id')
                            ->get();
            $label = [];
            $val = [];
            foreach ($grafik as $key => $value) {
                $label[] = $value->nama;
                $val[] = $value->total;
            }
            $grafik2 = TryoutHasil::selectRaw("count(id) as total, nilai_awal")->whereIn('user_id', $id_siswa)->groupBy('nilai_awal')->get();
            $label2 = [];
            $val2 = [];
            foreach ($grafik2 as $key => $value) {
                $label2[] = $value->nilai_awal;
                $val2[] = $value->total;
            }
            $rata = TryoutHasil::whereIn('user_id', $id_siswa)->avg('nilai_sekarang');
            $nilai_tertinggi = TryoutHasil::whereIn('user_id', $id_siswa)->max('nilai_sekarang');
            return view('pages.dashboard', compact('total_siswa', 'rata', 'nilai_tertinggi', 'label', 'val', 'label2', 'val2'));
        } elseif($user->getRoleNames()->first() == 'author') {
            $user = auth()->user();
            $artikel_publish = Blog::where('user_id', $user->id)->where('status', 1)->count();
            $artikel_draft = Blog::where('user_id', $user->id)->where('status', 0)->count();
            $total_artikel = $artikel_draft + $artikel_publish;
            $artikelmu_like = Blog::withCount('like')->with('like')->where('user_id', $user->id)->where('status', 1)->orderBy('like_count', 'DESC')->limit(3)->get();
            $artikelmu_komentar = Blog::withCount('komentar')->with('komentar')->where('user_id', $user->id)->where('status', 1)->orderBy('komentar_count', 'DESC')->limit(3)->get();
            $artikel_like = Blog::withCount('like')->with('like')->where('status', 1)->orderBy('like_count', 'DESC')->limit(3)->get();
            $artikel_komentar = Blog::withCount('komentar')->with('komentar')->where('status', 1)->orderBy('komentar_count', 'DESC')->limit(3)->get();
            return view('pages.dashboard', compact('artikel_publish', 'artikel_draft', 'total_artikel', 'artikelmu_like', 'artikelmu_komentar', 'artikel_like', 'artikel_komentar'));
        } else {
            return view('pages.dashboard');
        }
    }

    public function verifyUserRegistration($token) {
        $user = User::where("activate_token", $token)->first();
		if ($user) {
            $user->update([
				'activate_token' => null,
                'email_verified_at' => now(),
                'is_active' => 1
			]);
			return redirect()->route('dashboard')->with(['success' => "Berhasil Aktivasi Akun"]);
		}
		return redirect(route('login'))->with(['error' => 'Token salah']);
    }
}
