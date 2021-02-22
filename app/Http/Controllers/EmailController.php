<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerifikasiEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function verification() {
        $user = Auth::user();
        if($user->email_verified_at != '') {
            return redirect()->route('dashboard');
        }
        return view('auth.verify');
    }

    public function token_baru() {  
        $user = Auth::user();
        $user->update([
            'activate_token' => Str::random(30)
        ]);
        Mail::to($user->email)->send(new VerifikasiEmail($user));
        return redirect()->back()->with(['info' => "Berhasil kirim token baru"]);
    }
}
