<?php

namespace App\Http\Controllers\Web\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Kategori;
use App\Models\KomentarBlog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{

    public function __construct() {
        $this->middleware('auth', ['only' => ['komentar']]);
        View::share('kategori', Kategori::all());
    }

    public function index(Request $request) {
        if($request->get('urut')) {
            $artikel = Blog::withCount('like')->with('like')->where('status', 1)->orderBy('like_count', 'DESC')->paginate(10);
        } else {
            $artikel = Blog::where('status', 1)->latest()->paginate(10);
        }
        return view('pages.blog.list', compact('artikel'));
    }

    public function detail($slug) {
        try {
            $artikel = Blog::with(['like', 'user'])->findSlug($slug);
            $komentar = KomentarBlog::where('blog_id', $artikel->id)->latest()->get();
            $kategori = $artikel->kategori()->pluck('nama')->toArray();
            Blog::wherehas('kategori', function($q) use($kategori) {
                $q->whereIn('nama', $kategori);
            })->where('id', '!=', $artikel->id)->latest()->limit(5)->get();
            $lainnya = $this->artikel_lainnya($artikel->user_id, $artikel->id);
            $terkait = $this->artikel_terkait($kategori, $artikel->id);
            $btn_like = 0;
            if(auth()->user()) {
                $blog_like = DB::table('blog_like')
                ->where('blog_id', '=', $artikel->id)
                ->where('user_id', '=', auth()->user()->id)->get();
                if(count($blog_like) > 0) {
                    $btn_like = 1;
                }
            }
            return view('pages.blog.detail', compact('artikel', 'lainnya', 'terkait', 'komentar', 'btn_like'));
        } catch(\Exception $e) {
            dd($e);
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

    public function set_like($blog_id, $user_id, $status) {
        if($status) {
            DB::table('blog_like')
                    ->insert([
                        'blog_id' => $blog_id,
                        'user_id' => $user_id
                    ]);
            return response()->json(true,200);
        } else {
            // Blog::find($blog_id)->like()->detach();
            DB::table('blog_like')
                    ->where('blog_id', '=', $blog_id)
                    ->where('user_id', '=', $user_id)
                    ->delete();
            return response()->json(true,200);
        }
    }
}
