<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('permission:create admin', ['only' => ['store']]);
        $this->middleware('permission:read admin',   ['only' => ['index']]);
        $this->middleware('permission:update admin', ['only' => ['update']]);
        $this->middleware('permission:delete admin', ['only' => ['destroy']]);
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
            $admin = User::whereHas('roles', function($q) use($request) {
                $nama = $request->get('keyword');
                $q->where('name', 'admin')->where('name', 'LIKE', "%$nama%");
            })->paginate(10);
        } else {
            $admin = User::whereHas('roles', function($q){
                $q->where('name', 'admin');
            })->latest()->paginate(10);
        }
        return view('pages.users.admin.index', compact("admin", "data"));
    }

    /**
     * Show halaman integrasi admin ke pembayaran
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            $user = User::find($id);
            $pembayaran = $user->admin_bayar()->paginate(10);
            return view('pages.users.admin.bayar', compact('user', 'pembayaran'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show halaman integrasi admin ke pembayaran
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function integrasi_pembayaran($id) {
        try {
            $user = User::find($id);
            $id_bayar = DB::table('admin_pembayaran')->select('pembayaran_id')->get()->pluck('pembayaran_id')->toArray();
            $pembayaran = Pembayaran::with(['user', 'gelombang'])->whereNotIn('id', $id_bayar)->where('status', '!=', 2)->where('status', '!=', 3)->paginate(10);
            return view('pages.users.admin.integrasi_pembayaran', compact('user', 'pembayaran'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function store_integrasi(Request $request, $id) {
        try {
            $user = User::find($id);
            $user->admin_bayar()->attach($request->pembayaran_id);
            return redirect()->route('admin.show', $id)->with(['success' => 'Berhasil integrasi pembayaran ke admin']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function hapus_integrasi($id) {
        try {
            DB::table('admin_pembayaran')->where('pembayaran_id', '=', $id)->delete();
            return redirect()->back()->with(['success' => 'Berhasil hapus integrasi pembayaran ke admin']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
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
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $request->foto = $foto_name;
            }
            $user = User::create($request->all());
            $user->assignRole('admin');
            return redirect()->back()->with(['success' => 'Berhasil tambah admin']);
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
            $admin = User::find($id);
            return view('pages.users.admin.edit', compact('admin'));
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
            return redirect()->route('admin.index')->with(['success' => 'Berhasil ubah admin']);
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
            DB::table('admin_pembayaran')
                    ->where('user_id', '=', $id)
                    ->delete();
            $admin = User::find($id);
            if($admin->foto != '') {
                if(file_exists(public_path('upload/users/'.$admin->foto))){
                    unlink(public_path('upload/users/'.$admin->foto));
                }
            }
            $admin->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus admin"]);
        } catch(\Exception $e) {
            return \redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
