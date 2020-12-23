<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StatusUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->is_active == 1) return $next($request);
        Auth::logout();
        $request->session()->flash('info', 'Akun tidak aktif silahkan hubungi Admin / Cek Email anda');
        return redirect()->route('login')->withInput();
    }
}
