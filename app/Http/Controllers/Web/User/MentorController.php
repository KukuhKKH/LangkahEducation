<?php

namespace App\Http\Controllers\Web\User;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Mentor;
use Illuminate\Http\Request;
use App\Imports\MentorImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Mentor\MentorCreateRequest;
use App\Http\Requests\Mentor\MentorUpdateRequest;

class MentorController extends Controller
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
            $mentor = Mentor::latest()->whereHas('user', function($q) use($request) {
                $nama = $request->get('keyword');
                $q->where('name', 'LIKE', "%$nama%");
            })->paginate(10);
        } else {
            $mentor = Mentor::latest()->paginate(10);
        }
        return view('pages.users.mentor.index', compact('mentor', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MentorCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->merge([
                'is_active' => 1,
                'password' => 123456,
                'email_verified_at' => date('Y-m-d')
            ]);
            if($request->hasFile('image')) {
                $foto_name = time().'.'.$request->image->extension();  
                $request->image->move(public_path('upload/users/'), $foto_name);
                $request->merge([
                    'foto' => $foto_name
                ]);
            }
            $user = User::create($request->all());
            $user->mentor()->create($request->all());
            $user->assignRole('mentor');
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil tambah mentor']);
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
        $mentor = Mentor::with(['user', 'siswa'])->find($id);
        $id_siswa = DB::table('siswa_has_mentor')->select('siswa_id')->get();
        $id = [];
        foreach($id_siswa as $value) {
            $id[] = $value->siswa_id;
        }
        $siswa = Siswa::with(['user'])->whereNotIn('id', $id)->where('batch', 1)->get();
        $hapus = false;
        return view('pages.users.mentor.show', compact('mentor', 'siswa', 'hapus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mentor = Mentor::with('user')->find($id);
        return view('pages.users.mentor.edit', compact('mentor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MentorUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $foto = $request->foto;
            $mentor = Mentor::find($id);
            if($request->password_old) {
                if(!Hash::check($request->password_old, $mentor->user->password)) {
                    return redirect()->back()->with(['error' => 'Password lama tidak cocok']);
                }
            }
            if($request->hasFile('foto')) {
                if($mentor->user->foto != '') {
                    if(file_exists(public_path('upload/users/'.$mentor->user->foto))){
                        unlink(public_path('upload/users/'.$mentor->user->foto));
                    }
                }
                $foto_name = time().'.'.$request->foto->extension();  
                $request->foto->move(public_path('upload/users/'), $foto_name);
                $foto = $foto_name;
            }
            $mentor->update([
                'pendidikan_terakhir' => $request->pendidikan_terakhir
            ]);
            if($request->password_old) {
                $mentor->user()->update([
                    'name' => $request->name,
                    'password' => $request->password_old,
                    'email' => $request->email,
                    'foto' => $foto
                ]);
            } else {
                $mentor->user()->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'is_active' => $request->is_active,
                    'foto' => $foto
                ]);
            }
            DB::commit();
            return redirect()->route('mentor.index')->with(['success' => 'Berhasil update mentor']);
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
            $mentor = Mentor::find($id);
            if($mentor->user->foto != '') {
                if(file_exists(public_path('upload/users/'.$mentor->user->foto))){
                    unlink(public_path('upload/users/'.$mentor->user->foto));
                }
            }
            DB::table('siswa_has_mentor')->where('mentor_id', '=', $id)->delete();
            DB::table('komentar_mentor')->where('mentor_id', '=', $id)->delete();
            $mentor->delete();
            $mentor->user()->delete();
            return \redirect()->back()->with(['success' => "Berhasil hapus mentor"]);
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
                Excel::import(new MentorImport(), $file);
                return \redirect()->back()->with(['success' => 'Import mentor berhasil']);
                return redirect(route('mentor.index'));
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
            $mentor = Mentor::find($id);
            $mentor->siswa()->attach($request->siswa);
            return redirect()->route('mentor.index')->with(['success' => 'Berhasil integrasi siswa ke mentor']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
        }
    }

    public function hapus_integrasi(Request $request, $id) {
        try {
            DB::table('siswa_has_mentor')
                ->where('mentor_id', $id)
                ->whereIn('siswa_id', $request->siswa)
                ->delete();
            return redirect()->back()->with(['success' => 'Berhasil hapus integrasi siswa ke mentor']);
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput($request->all());
        }
    }
}
