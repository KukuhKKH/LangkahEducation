<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $user = User::find($id);
            $sekolah = Sekolah::where('kode_referal', $request->kode_referal)->first();
            $sekolah->siswa()->attach($user->siswa->id);
            return redirect()->back()->with(['success' => 'Berhasil memakai kode referal']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()])->withInput();
        }
    }
}
