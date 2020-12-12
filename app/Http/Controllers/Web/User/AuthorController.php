<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if($request->get('keyword') != '') {
            $author = Author::latest()->whereHas('user', function($q) use($request) {
                $nama = $request->get('keyword');
                $q->where('name', 'LIKE', "%$nama%");
            })->paginate(10);
        } else {
            $author = Author::latest()->paginate(10);
        }

        return view('pages.users.author.index', compact("author", "data"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'deskripsi' => 'nullable'
        ]);
        try {
            $request->merge([
                'is_active' => 1,
                'email_verified_at' => date('Y-m-d')
            ]);
            if($request->hasFile('foto')) {
                $foto_name = time().'-'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $request->foto = $foto_name;
            }
            $author = User::create($request->all());
            Author::create([
                'user_id' => $author->id,
                'deskripsi' => $request->deskripsi
            ]);
            $author->assignRole('author');
            return redirect()->back()->with(['success' => 'Berhasil tambah author']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
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
            $author = Author::find($id);
            return view('pages.users.author.edit', compact('author'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
        $this->validate($request, [
            'deskripsi' => 'nullable'
        ]);
        try {
            $user = User::find($id);
            if($request->password_old) {
                if(!Hash::check($request->password_old, $user->password)) {
                    return redirect()->back()->with(['error' => 'Password lama tidak cocok']);
                }
            }
            $foto = $user->foto;
            if($request->hasFile('foto')) {
                if(file_exists(public_path('upload/users/'.$user->foto))){
                    unlink(public_path('upload/users/'.$user->foto));
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $foto = $foto_name;
            }
            if($request->password_old) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'foto' => $foto,
                    'is_active' => $request->is_active,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'foto' => $foto,
                    'is_active' => $request->is_active,
                ]);
            }
            $user->save();
            return redirect()->route('author.index')->with(['success' => 'Berhasil ubah author']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
            $author = Author::find($id);
            $author->delete();
            $author->user->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus author"]);
        } catch(\Exception $e) {
            return \redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
