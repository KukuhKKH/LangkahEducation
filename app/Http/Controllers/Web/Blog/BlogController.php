<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Models\Blog;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('permission:create blog', ['only' => ['store']]);
        $this->middleware('permission:read blog',   ['only' => ['index']]);
        $this->middleware('permission:update blog', ['only' => ['update']]);
        $this->middleware('permission:delete blog', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        if($user->getRoleNames()->first() == 'superadmin' || $user->getRoleNames()->first() == 'admin') {
            if($request->get('show') == 'me') {
                if($request->get('keyword') != '') {
                    $judul = $request->get('keyword');
                    $artikel = $user->blog()->latest()->where('judul', 'LIKE', "%$judul%")->paginate(10);
                }else{
                    $artikel = $user->blog()->latest()->paginate(10);
                }
            }else if ($request->get('show') == 'all'){
                if($request->get('keyword') != ''){
                    $judul = $request->get('keyword');
                    $artikel = Blog::where('judul', 'LIKE', "%$judul%")->paginate(10);
                }else{
                    $artikel = Blog::latest()->paginate(10);
                }
            }else{
                $artikel = $user->blog()->latest()->paginate(10);
            }
        }else{
            if($request->get('keyword') != '') {
                $judul = $request->get('keyword');
                $artikel = $user->blog()->latest()->where('judul', 'LIKE', "%$judul%")->paginate(10);
            }else{
                $artikel = $user->blog()->latest()->paginate(10);
            }
        }

        return view('pages.halaman.blog.index', compact('artikel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('pages.halaman.blog.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCreateRequest $request)
    {
        try {
            $user = auth()->user();
            if($request->hasFile('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/blog/'), $foto_name);
                $request->foto = $foto_name;
            }
            $blog = $user->blog()->create([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'foto' => $request->foto ?? '',
                'status' => $request->status,
            ]);
            $blog->kategori()->sync($request->kategori);
            return redirect()->route('blog.index')->with(['success' => 'Berhasil menambah artikel']);
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $kategori = Kategori::all();
            $artikel = Blog::find($id);
            $kategori_id = $artikel->kategori()->pluck('kategori_id')->toArray();
            return view('pages.halaman.blog.edit', compact('artikel', 'kategori', 'kategori_id'));
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::find($id);
            if($request->hasFile('foto')) {
                if($blog->foto != '') {
                    if(file_exists(public_path('upload/blog/'.$blog->foto))){
                        if($blog->foto != "") unlink(public_path('upload/blog/'.$blog->foto));
                    }
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/blog/'), $foto_name);
                $request->foto = $foto_name;
            }
            $blog->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'foto' => $foto_name ?? $blog->foto,
                'kategori' => $request->kategori,
                'status' => $request->status,
            ]);
            $blog->kategori()->sync($request->kategori);
            return redirect()->route('blog.index')->with(['success' => 'Berhasil update artikel']);
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $artikel = Blog::find($id);
            if($artikel->foto != '') {
                if(file_exists(public_path('upload/blog/'.$artikel->foto))){
                    unlink(public_path('upload/blog/'.$artikel->foto));
                }
            }
            $artikel->delete();
            return redirect()->back()->with(['success' => "Berhasil hapus artikel"]);
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => $e->getMessage()]);
        }
    }
}
