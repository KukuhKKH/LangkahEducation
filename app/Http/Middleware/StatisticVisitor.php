<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\HelperController;

class StatisticVisitor
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
        $res = $next($request);
        if(!$request->cookie('visitor')) {
            $data = HelperController::kunjungan_user();
            return $res->cookie('visitor', json_encode($data), 1440);
        }
        return $res;
    }
}
