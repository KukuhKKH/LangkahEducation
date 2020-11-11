<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuperadminController extends Controller
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('permission:create superadmin', ['only' => ['store']]);
        $this->middleware('permission:read superadmin',   ['only' => ['index']]);
        $this->middleware('permission:update superadmin', ['only' => ['update']]);
        $this->middleware('permission:delete superadmin', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $superadmin = User::whereHas('roles', function($q){
            $q->where('name', 'superadmin');
        })->paginate(10);
        return view('pages.users.superadmin.index', compact("superadmin"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|confirmed',
                'foto' => 'nullable'
            ]);

            $request->merge([
                'is_active' => 1
            ]);
            if($request->file('foto')) {
                $foto_name = time().'-'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $request->foto = $foto_name;
            }
            $user = User::create($request->all());
            $user->assignRole('superadmin');
            return redirect()->back()->with(['success' => 'Berhasil tambah superadmin']);
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
            $superadmin = User::find($id);
            return view('pages.users.superadmin.edit', compact('superadmin'));
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
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users,email,'.$id,
                'password_old' => 'nullable',
                'password' => 'nullable|confirmed',
                'foto' => 'nullable|mimes:jpg,jpeg,gif,png|max:2000',
                'is_active' => 'required'
            ]);
            $admin = User::find($id);
            if($request->password_old) {
                if(!Hash::check($request->password_old, $admin->password)) {
                    return redirect()->back()->with(['error' => 'Password lama tidak cocok']);
                }
            }
            if($request->file('foto')) {
                if(file_exists(public_path('upload/users/'.$admin->foto))){
                    unlink(public_path('upload/users/'.$admin->foto));
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $request->foto = $foto_name;
            }
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'foto' => $request->foto,
                'is_active' => $request->is_active,
            ]);
            $admin->save();
            return redirect()->route('superadmin.index')->with(['success' => 'Berhasil ubah superadmin']);
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
            User::find($id)->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus superadmin"]);
        } catch(\Exception $e) {
            return \redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
