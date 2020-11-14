<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

    public function dashboard() {
//        if(Auth::user()->is_active != 1) return redirect('login')->with(['info' => 'Silahkan activasi akun lewat email / hubungi pihak sekolah']);
        return view('pages.dashboard');
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
