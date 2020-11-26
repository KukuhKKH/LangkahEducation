<?php

namespace App\Http\Controllers\Web\User;

use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;

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
        $author = Author::latest()->paginate(10);
        return view('pages.users.author.index', compact("author", "data"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCreateRequest $request)
    {
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
    public function update(AdminUpdateRequest $request, $id)
    {
        try {
            $user = User::find($request->user_id);
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
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'foto' => $foto,
                'is_active' => $request->is_active,
            ]);
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