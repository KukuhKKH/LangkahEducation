<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Siswa\SiswaCreateRequest;
use App\Http\Requests\Siswa\SiswaUpdateRequest;
use App\Imports\SiswaImport;
use App\Models\Sekolah;
use Illuminate\Validation\ValidationException as ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Instanceof_;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nama = false;
        $nisn = false;
        $asal = false;
        if($request->q == 'nama') {
            $nama = $request->keyword;
        } else if($request->q == 'nisn') {
            $nisn = $request->keyword;
        } else if($request->q == 'asal') {
            $asal = $request->keyword;
        }

        $siswa = Siswa::when($request->q, function($siswa) use($nama, $nisn, $asal) {
            if($nama) $siswa->whereHas('user', function($q) use ($nama) {
                $q->where('name', 'LIKE', "%$nama%");
            });
            if($nisn) $siswa->where('nisn', 'LIKE', "%$nisn%");
            if($asal) $siswa->where('asal_sekolah', 'LIKE', "%$asal%");
        })->latest()->paginate(10);
        $sekolah = [];
        if(auth()->user()->getRoleNames()->first() != 'sekolah') {
            $sekolah = Sekolah::all('nama');
        }
        $data = $request->all();
        return view('pages.users.siswa.index', compact('siswa', 'sekolah', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiswaCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->merge([
                'is_active' => 1,
                'password' => $request->nisn,
                'email_verified_at' => date('Y-m-d')
            ]);
            $tgl = explode('/',$request->tanggal_lahir);
            $tgl_lahir = "$tgl[1]/$tgl[0]/$tgl[2]";
            $request->tanggal_lahir = $tgl_lahir;
            $user = User::create($request->all());
            $user->siswa()->create($request->all());
            $user->assignRole('siswa');
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil tambah siswa']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
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
        $user = Siswa::with('user')->find($id);
        $tgl = explode('/',$user->tanggal_lahir);
        $user->tanggal_lahir = "$tgl[1]/$tgl[0]/$tgl[2]";
        return view('pages.users.siswa.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiswaUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $siswa = Siswa::with('user')->find($id);
            $foto = $siswa->user->foto;
            if($request->hasFile('foto')) {
                if($siswa->user->foto != "") {
                    if(file_exists(public_path('upload/users/'.$siswa->user->foto))){
                        unlink(public_path('upload/users/'.$siswa->user->foto));
                    }
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $foto = $foto_name;
            }
            if($request->password_old) {
                if(!Hash::check($request->password_old, $siswa->user->password)) {
                    return redirect()->back()->with(['error' => 'Password lama tidak cocok']);
                }
            }
            $tgl = explode('/',$request->tanggal_lahir);
            $tgl_lahir = "$tgl[1]/$tgl[0]/$tgl[2]";
            $siswa->update([
                'nisn' => $request->nisn,
                'tanggal_lahir' => $tgl_lahir,
                'asal_sekolah' => $request->asal_sekolah,
                'nomor_hp' => $request->nomor_hp
            ]);
            if($request->password_old) {
                $siswa->user()->update([
                    'name' => $request->name,
                    'password' => $request->password_old,
                    'email' => $request->email,
                    'foto' => $foto
                ]);
            } else {
                $siswa->user()->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'is_active' => $request->is_active,
                    'foto' => $foto
                ]);
            }
            DB::commit();
            return redirect()->route('siswa.index')->with(['success' => 'Berhasil update siswa']);
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
            DB::beginTransaction();
            $user = User::find($id);
            $user->siswa()->delete();
            $user->delete();
            DB::commit();
            return \redirect()->back()->with(['success' => "Berhasil hapus siswa"]);
        } catch(\Exception $e) {
            DB::rollBack();
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
                if(auth()->user()->getRoleNames()->first() != 'sekolah') {
                    $asal_sekolah = $request->sekolah;
                } else {
                    $asal_sekolah = auth()->user()->sekolah()->nama;
                }
                Excel::import(new SiswaImport($asal_sekolah), $file);
                return \redirect()->back()->with(['success' => 'Import siswa berhasil']);
                return redirect(route('siswa.index'));
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (!$message == "Start row (2) is beyond highest row (1)") throw $e;
                return \redirect()->back()->with(['error' => $message])->withInput();
            }
        }
        return \redirect()->back()->with(['error' => "Anda belum memilih file"])->withInput();
    }
}
