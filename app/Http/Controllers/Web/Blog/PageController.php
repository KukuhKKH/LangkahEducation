<?php

namespace App\Http\Controllers\Web\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;

class PageController extends Controller
{
    public function index() {
        $artikel = Blog::latest()->paginate(10);
        return view('pages.blog.list', compact('artikel'));
    }

    public function detail($slug) {
        try {
            $artikel = Blog::findSlug($slug);
            $lainnya = $this->artikel_lainnya($artikel->user_id, $artikel->id);
            $terkait = $this->artikel_terkait($artikel->kategori, $artikel->id);
            return view('pages.blog.detail', compact('artikel', 'lainnya', 'terkait'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function detail_author($kode) {
        try {
            $user = Author::where('kode', $kode)->first();
            $artikel = Blog::with('user.author', function($q) use($user) {
                $q->where('user_id', $user->user_id);
            })->get();
            $lainnya = $this->artikel_lainnya($artikel->user_id, $artikel->id);
            $terkait = $this->artikel_terkait($artikel->kategori, $artikel->id);
            return view('pages.blog.author-profile', compact('artikel', 'lainnya', 'terkait'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    private function artikel_lainnya($user_id, $id) {
        return Blog::where('user_id', $user_id)->where('id', '!=', $id)->latest()->limit(5)->get();
    }

    private function artikel_terkait($kategori, $id) {
        return Blog::where('kategori', $kategori)->where('id', '!=', $id)->latest()->limit(5)->get();
    }
}
