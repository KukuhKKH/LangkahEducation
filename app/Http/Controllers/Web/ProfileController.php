<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('pages.profile.index', compact('user'));
    }

    public function edit($id) {
        try {
            $user = User::with('siswa')->find($id);
            return view('pages.profile.edit', compact('user'));
        } catch(\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }

    public function kode_referal(Request $request, $id) {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $sekolah = Sekolah::where('kode_referal', $request->kode_referal)->first();
            $user->siswa()->update([
                'batch' => 1
            ]);
            $sekolah->siswa()->attach($user->siswa->id);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil memakai kode referal']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
}
