<?php

namespace App\Http\Controllers\Web\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Kategori;
use App\Models\KomentarBlog;
use App\Models\User;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{

    public function __construct() {
        $this->middleware('auth', ['only' => ['komentar']]);
        View::share('kategori', Kategori::all());
    }

    public function index() {
        $kategori = Kategori::all();
        $artikel = Blog::where('status', 1)->latest()->paginate(10);
        return view('pages.blog.list', compact('artikel', 'kategori'));
    }

    public function detail($slug) {
        try {
            $artikel = Blog::findSlug($slug);
            $komentar = KomentarBlog::where('blog_id', $artikel->id)->latest()->get();
            $kategori = $artikel->kategori()->pluck('nama')->toArray();
            Blog::wherehas('kategori', function($q) use($kategori) {
                $q->whereIn('nama', $kategori);
            })->where('id', '!=', $artikel->id)->latest()->limit(5)->get();
            $lainnya = $this->artikel_lainnya($artikel->user_id, $artikel->id);
            $terkait = $this->artikel_terkait($kategori, $artikel->id);
            return view('pages.blog.detail', compact('artikel', 'lainnya', 'terkait', 'komentar'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function detail_author($kode) {
        try {
            $user = User::where('api_token', $kode)->first();
            $artikel = Blog::where('user_id', $user->id)->latest()->get();
            $lainnya = $this->artikel_lainnya($user->id);
            return view('pages.blog.author-profile', compact('artikel', 'user'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function kategori($kategori) {
        try {
            $artikel = Blog::whereHas('kategori', function($q) use($kategori) {
                $q->where('nama', 'LIKE', "%$kategori%");
            })->latest()->paginate(10);
            return view('pages.blog.kategori', compact('artikel'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function komentar(Request $request, $id) {
        try {
            $artikel = Blog::find($id);
            $artikel->komentar()->create([
                'user_id' => auth()->user()->id,
                'komentar' => $request->komentar
            ]);
            return redirect()->back()->with(['success' => 'Berhasil menambah komentar']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    private function artikel_lainnya($user_id, $id = null) {
        return Blog::where('user_id', $user_id)->where('id', '!=', $id)->latest()->limit(5)->get();
    }

    private function artikel_terkait($kategori, $id = null) {
        return Blog::wherehas('kategori', function($q) use($kategori) {
            $q->whereIn('nama', $kategori);
        })->where('id', '!=', $id)->latest()->limit(5)->get();
        // return Blog::where('kategori', $kategori)->where('id', '!=', $id)->latest()->limit(5)->get();
    }
}
