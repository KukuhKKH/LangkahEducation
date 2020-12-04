<?php

namespace App\Http\Controllers\Web\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\KomentarBlog;
use App\Models\User;

class PageController extends Controller
{

    public function __construct() {
        
        $this->middleware('auth', ['only' => ['komentar']]);
    }

    public function index() {
        $artikel = Blog::where('status', 1)->latest()->paginate(10);
        return view('pages.blog.list', compact('artikel'));
    }

    public function detail($slug) {
        try {
            $artikel = Blog::findSlug($slug);
            $komentar = KomentarBlog::where('blog_id', $artikel->id)->latest()->get();
            $lainnya = $this->artikel_lainnya($artikel->user_id, $artikel->id);
            $terkait = $this->artikel_terkait($artikel->kategori, $artikel->id);
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
            $artikel = Blog::where('kategori', 'LIKE', "%$kategori%")->latest()->paginate(10);
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
        return Blog::where('kategori', $kategori)->where('id', '!=', $id)->latest()->limit(5)->get();
    }
}
