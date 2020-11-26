<?php

namespace App\Http\Controllers\Web\Siswa;

use App\Models\TryoutPaket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TryoutController extends Controller
{
    public function index() {
        $user = Auth::user();
        $paket = $user->siswa->sekolah->first()->tryout;
        return view('pages.siswa.tryout.index',compact('paket'));
    }

    public function paket($slug) {
        $paket = TryoutPaket::first();
        return view('pages.siswa.tryout.kategori',compact('paket'));
    }
}
