<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Sekolah;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\StatistikPengunjung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function dashboard() {
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
            // dd($label, $total);
            return view('pages.dashboard', compact('sekolah', 'siswa', 'belum_bayar', 'pengunjung', 'label', 'total'));
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
