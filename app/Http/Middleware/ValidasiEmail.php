<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ValidasiEmail
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
        if(Auth::user()->email_verified_at) return $next($request);
        Auth::logout();
        $request->session()->flash('error', 'Silahkan activasi akun lewat email');
        return redirect()->route('login')->withInput();
    }
}
