<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sekolah = Sekolah::paginate(10);
        return view('pages.users.sekolah.index', compact('sekolah'));
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
                'email' => 'required|unique:users,email',
                'foto' => 'nullable',
                'alamat' => 'required',
                'kode_referal' => 'nullable',
            ]);
            $request->merge([
                'is_active' => 1,
                'password' => ($request->password) ? $request->password : '123456',
                'email_verified_at' => date('Y-m-d')
            ]);
            if($request->hasFile('foto')) {
                $foto_name = time().'-'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $request->foto = $foto_name;
            }
            $logo = $request->foto;
            $nama_sekolah = $request->name;
            if($request->kode_referal) {
                $kode_referal = $request->kode_referal;
            } else {
                $kode_referal = Str::random(7);
            }
            DB::beginTransaction();
            $user = User::create($request->all());
            $user->sekolah()->create([
                'nama' => $nama_sekolah,
                'alamat' => $request->alamat,
                'logo' => $logo,
                'kode_referal' => $kode_referal
            ]);
            $user->assignRole('sekolah');
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil tambah sekolah']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
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
        $sekolah = Sekolah::with('user')->find($id);
        $id_siswa = DB::table('siswa_has_sekolah')->select('siswa_id')->get();
        $id = [];
        foreach($id_siswa as $value) {
            $id[] = $value->siswa_id;
        }
        $siswa = Siswa::with(['user'])->whereNotIn('id', $id)->get();
        return view('pages.users.sekolah.show', compact('sekolah', 'siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sekolah = Sekolah::with('user')->find($id);
        return view('pages.users.sekolah.edit', compact('sekolah'));
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
                'email' => 'required|unique:users,email,'.$request->user_id,
                'foto' => 'nullable',
                'alamat' => 'required',
                'kode_referal' => 'nullable',
            ]);
            $sekolah = Sekolah::with('user')->find($id);
            if($request->password_old) {
                if(!Hash::check($request->password_old, $sekolah->user->password)) {
                    return redirect()->back()->with(['error' => 'Password lama tidak cocok']);
                }
            }
            $logo = $request->foto;
            if($request->hasFile('foto')) {
                $foto_name = time().'-'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $logo = $foto_name;
            }
            if($request->kode_referal) {
                $kode_referal = $request->kode_referal;
            } else {
                $kode_referal = Str::random(7);
            }
            DB::beginTransaction();
            $sekolah->update([
                'nama' => $request->name,
                'alamat' => $request->alamat,
                'logo' => $logo,
                'kode_referal' => $kode_referal,
            ]);
            $sekolah->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->is_active,
                'foto' => $logo
            ]);
            DB::commit();
            return redirect()->route('sekolah.index')->with(['success' => 'Berhasil update sekolah']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
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
            $sekolah = Sekolah::find($id);
            $sekolah->siswa()->delete();
            $sekolah->delete();
            $sekolah->user()->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus sekolah"]);
        } catch(\Exception $e) {
            return \redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function integrasi(Request $request, $id) {
        try {
            $sekolah = Sekolah::find($id);
            $sekolah->siswa()->sync($request->siswa);
            return redirect()->route('sekolah.index')->with(['success' => 'Berhasil integrasi siswa ke sekolah']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
        }
    }
}
