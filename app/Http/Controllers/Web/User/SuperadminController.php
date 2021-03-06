<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\SuperadminCreateRequest;
use App\Http\Requests\Superadmin\SuperadminUpdateRequest;

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
    public function index(Request $request)
    {
        $data = $request->all();

        if($request->get('keyword') != '') {
            $superadmin = User::whereHas('roles', function($q) use($request) {
                $nama = $request->get('keyword');
                $q->where('name', 'superadmin')->where('name', 'LIKE', "%$nama%");
            })->paginate(10);
        } else {
            $superadmin = User::whereHas('roles', function($q){
                $q->where('name', 'superadmin');
            })->latest()->paginate(10);
        }
        return view('pages.users.superadmin.index', compact("superadmin", "data"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuperadminCreateRequest $request)
    {
        try {
            $request->merge([
                'is_active' => 1,
                'email_verified_at' => date('Y-m-d')
            ]);
            if($request->file('foto')) {
                $foto_name = time().'.'.$request->foto->extension();  
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
    public function update(SuperadminUpdateRequest $request, $id)
    {
        try {
            $admin = User::find($id);
            if($request->password_old) {
                if(!Hash::check($request->password_old, $admin->password)) {
                    return redirect()->back()->with(['error' => 'Password lama tidak cocok']);
                }
            }
            $foto = $admin->foto;
            if($request->hasFile('foto')) {
                if($admin->foto != '') {
                    if(file_exists(public_path('upload/users/'.$admin->foto))){
                        unlink(public_path('upload/users/'.$admin->foto));
                    }
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $foto = $foto_name;
            }
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'foto' => $foto,
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
            $admin = User::find($id);
            if($admin->foto != '') {
                if(file_exists(public_path('upload/users/'.$admin->foto))){
                    unlink(public_path('upload/users/'.$admin->foto));
                }
            }
            $admin->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus superadmin"]);
        } catch(\Exception $e) {
            return \redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
