<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDataLandingPage;
use App\Models\Gelombang;
use App\Models\LandingPage;
use App\Models\LayananProduk;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function index() {
        $data = LandingPage::find(1);
        $testimoni = Testimoni::where('status', 1)->get();
        $today = date('m/d/Y');
        $gelombang = Gelombang::where('tgl_awal', '<', $today)->where('tgl_akhir', '>', $today)->get();
        $layanan = LayananProduk::all();
        return view('welcome', compact('data', 'testimoni','gelombang', 'layanan'));
    }

    public function landing_page() {
        try {
            $data = LandingPage::findOrFail(1);
            return view('pages.halaman.landing-page.index', compact('data'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function update(UpdateDataLandingPage $request, $id) {
        // https://www.instagram.com/
        try {
            $data = LandingPage::findOrFail(1);
            if($request->hasFile('raw_foto_hero')) {
                // if(file_exists(public_path('landing-page/foto/'.$data->foto_hero))){
                //     unlink(public_path('landing-page/foto/'.$data->foto_hero));
                // }
                $foto_name_hero = time().'.'.$request->raw_foto_hero->extension();
                $request->foto_hero = $foto_name_hero;
                $request->raw_foto_hero->move(public_path('landing-page/foto/'), $foto_name_hero);
            } else {
                $request->foto_hero = $data->foto_hero ?? '';
            }
            if($request->hasFile('raw_foto_tentang_kami')) {
                // if(file_exists(public_path('landing-page/foto/'.$data->foto_tentang_kami))){
                //     unlink(public_path('landing-page/foto/'.$data->foto_tentang_kami));
                // }
                $foto_name_tentang_kami = time().'.'.$request->raw_foto_tentang_kami->extension();  
                $request->foto_tentang_kami = $foto_name_tentang_kami;
                $request->raw_foto_tentang_kami->move(public_path('landing-page/foto/'), $foto_name_tentang_kami);
            } else {
                $request->foto_tentang_kami = $data->foto_tentang_kami ?? '';
            }
            $data->update([
                'headline' => $request->headline,
                'tagline' => $request->tagline,
                'foto_hero' => $request->foto_hero,
                'tentang_kami' => $request->tentang_kami,
                'foto_tentang_kami' => $request->foto_tentang_kami,
                'headline_produk' => $request->headline_produk,
                'headline_blog' => $request->headline_blog,
                'headline_testimoni' => $request->headline_testimoni,
                'deskripsi' => $request->deskripsi,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'noHP' => $request->noHP,
                'akunIG' => $request->akunIG,
                'urlIG' => $request->urlIG,
                'akunFB' => $request->akunFB,
                'urlFB' => $request->urlFB,
                'akunTwitter' => $request->akunTwitter,
                'urlTwitter' => $request->urlTwitter,
                'akunLine' => $request->akunLine,
                'urlLine' => $request->urlLine,
                'akunYoutube' => $request->akunYoutube,
                'urlYoutube' => $request->urlYoutube,
            ]);
            return redirect()->back()->with(['success' => "Berhasil update data landing page"])->withInput();
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
