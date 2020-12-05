<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Sekolah;
use App\Models\Pembayaran;
use App\Models\NisnSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('pages.profile.index', compact('user'));
    }

    public function edit($id) {
        try {
            $user = User::find($id);
            return view('pages.profile.edit', compact('user'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $role = $user->getRoleNames()->first();
            if($request->password_old) {
                if(!Hash::check($request->password_old, $user->password)) {
                    return redirect()->back()->with(['error' => 'Password lama tidak cocok']);
                }
            }
            if($request->hasFile('foto')) {
                // if(file_exists(public_path('upload/users/'.$user->foto))){
                //     unlink(public_path('upload/users/'.$user->foto));
                // }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $foto = $foto_name;
            }
            if($request->password_old) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'foto' => $foto ?? $user->foto,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'foto' => $foto ?? $user->foto,
                ]);
            }
            if($role == 'siswa') {
                $tgl = explode('/',$request->tanggal_lahir);
                $tgl_lahir = "$tgl[1]/$tgl[0]/$tgl[2]";
                $user->siswa()->update([
                    'nisn' => $request->nisn,
                    'asal_sekolah' => $request->asal_sekolah,
                    'tanggal_lahir' => $tgl_lahir,
                    'nomor_hp' => $request->nomor_hp,
                ]);
            }else if($role == 'sekolah') {
                $user->sekolah()->update([
                    'nama' => $request->name,
                    'alamat' => $request->alamat,
                    'logo' => $foto ?? $user->foto,
                    'kode_referal' => $request->kode_referal
                ]);
            } else if($role == 'author') {
                // $user->author()->update([
                //     'deskripsi' => $request->deskripsi
                // ]);
            } else if($role == 'mentor') {
                $user->mentor()->update([
                    'pendidikan_terakhir' => $request->pendidikan_terakhir
                ]);
            }
            DB::commit();
            return redirect()->route('profile.index')->with(['success' => "Berhasil update profile"]);
        } catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function kode_referal(Request $request, $id) {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $sekolah = Sekolah::where('kode_referal', $request->kode_referal)->first();
            $cek = NisnSekolah::where('nisn', $user->siswa->nisn)->get();
            if(count($cek) > 0) {
                $user->siswa()->update([
                    'batch' => 1
                ]);
                Pembayaran::where('user_id', auth()->user()->id)->delete();
                $sekolah->siswa()->attach($user->siswa->id);
                DB::commit();
                return redirect()->back()->with(['success' => 'Berhasil memakai kode referal']);
            }
            return redirect()->back()->with(['error' => 'Nisn anda tidak tergabung pada sekolah ini']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
}
