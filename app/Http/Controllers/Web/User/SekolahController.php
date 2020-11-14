<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\SekolahImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Sekolah\SekolahCreateRequest;
use App\Http\Requests\Sekolah\SekolahUpdateRequest;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sekolah = Sekolah::paginate(10);
        $data = $request->all();
        return view('pages.users.sekolah.index', compact('sekolah', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SekolahCreateRequest $request)
    {
        try {
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
        $sekolah = Sekolah::with(['user', 'siswa'])->find($id);
        $id_siswa = DB::table('siswa_has_sekolah')->select('siswa_id')->get();
        $id = [];
        foreach($id_siswa as $value) {
            $id[] = $value->siswa_id;
        }
        $siswa = Siswa::with(['user'])->whereNotIn('id', $id)->get();
        $hapus = false;
        return view('pages.users.sekolah.show', compact('sekolah', 'siswa', 'hapus'));
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
    public function update(SekolahUpdateRequest $request, $id)
    {
        try {
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

    public function import(Request $request) {
        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx',
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            try {
                Excel::import(new SekolahImport(), $file);
                return \redirect()->back()->with(['success' => 'Import sekolah berhasil']);
                return redirect(route('sekolah.index'));
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (!$message == "Start row (2) is beyond highest row (1)") throw $e;
                return \redirect()->back()->with(['error' => $message])->withInput();
            }
        }
        return \redirect()->back()->with(['error' => "Anda belum memilih file"])->withInput();
    }

    public function integrasi(Request $request, $id) {
        try {
            $sekolah = Sekolah::find($id);
            $sekolah->siswa()->attach($request->siswa);
            return redirect()->route('sekolah.index')->with(['success' => 'Berhasil integrasi siswa ke sekolah']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
        }
    }

    public function hapus_integrasi(Request $request, $id) {
        try {
            DB::table('siswa_has_sekolah')
                ->where('sekolah_id', $id)
                ->whereIn('siswa_id', $request->siswa)
                ->delete();
            return redirect()->route('sekolah.index')->with(['success' => 'Berhasil hapus integrasi siswa ke sekolah']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
        }
    }
}
