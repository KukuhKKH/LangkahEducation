<?php

namespace App\Http\Controllers\Web\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TryoutKategori;
use App\Models\TryoutPaket;
use Illuminate\Http\Request;

class TryoutController extends Controller
{
    public function index() {
        $kategori = TryoutKategori::latest()->get();
        return view('pages.siswa.tryout.index',compact('kategori'));
    }

    public function kategori($slug) {
        $kategori_id = TryoutKategori::findSlug($slug)->id;
        $paket = TryoutPaket::where('tryout_kategori_id', $kategori_id)->latest()->get();
        return view('pages.siswa.tryout.kategori',compact('paket'));
    }
}
