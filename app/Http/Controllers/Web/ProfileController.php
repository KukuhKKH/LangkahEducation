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
            $user = User::with('siswa')->find($id);
            return view('pages.profile.edit', compact('user'));
        } catch(\Exception $e) {
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
