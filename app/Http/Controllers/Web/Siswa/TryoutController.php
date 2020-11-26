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
        if($user->siswa->batch == 1) {
            $paket = $user->siswa->sekolah->first()->tryout;
        } else if($user->siswa->batch == 0) {
            $paket = $user->pembayaran->first()->gelombang->tryout;
        }
        $status_bayar = $user->pembayaran()->latest()->first()->status;
        return view('pages.siswa.tryout.index',compact('paket', 'status_bayar'));
    }

    public function paket($slug) {
        $paket = TryoutPaket::first();
        return view('pages.siswa.tryout.kategori',compact('paket'));
    }
}
