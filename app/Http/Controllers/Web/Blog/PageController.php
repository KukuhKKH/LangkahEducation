<?php

namespace App\Http\Controllers\Web\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index() {
        return view('pages.blog.index', compact('artikel'));
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

    private function artikel_lainnya($user_id, $id) {
        return Blog::where('user_id', $user_id)->where('id', '!=', $id)->latest()->limit(5)->get();
    }

    private function artikel_terkait($kategori, $id) {
        return Blog::where('kategori', $kategori)->where('id', '!=', $id)->latest()->limit(5)->get();
    }
}
