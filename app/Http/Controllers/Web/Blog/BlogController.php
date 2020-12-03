<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogCreateRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $artikel = $user->blog;
        return view('pages.halaman.blog.index', compact('artikel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.halaman.blog.create');
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
            $user->blog()->create([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'foto' => $request->foto ?? '',
                'kategori' => $request->kategori,
                'status' => $request->status,
            ]);
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
            $artikel = Blog::find($id);
            return view('pages.halaman.blog.edit', compact('artikel'));
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
                if(file_exists(public_path('upload/blog/'.$blog->foto))){
                    unlink(public_path('upload/blog/'.$blog->foto));
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/blog/'), $foto_name);
                $request->foto = $foto_name;
            }
            $blog->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'foto' => $request->foto ?? $blog->foto,
                'kategori' => $request->kategori,
                'status' => $request->status,
            ]);
            return redirect()->route('blog.index')->with(['success' => 'Berhasil menambah artikel']);
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
            $artikel = Blog::find($id)->delete();
            if(file_exists(public_path('upload/blog/'.$artikel->foto))){
                unlink(public_path('upload/blog/'.$artikel->foto));
            }
            return redirect()->back()->with(['error' => "Berhasil hapus artikel"]);
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => $e->getMessage()]);
        }
    }
}
