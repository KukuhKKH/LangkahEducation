<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\HelperController;
use App\Models\LandingPage;
use App\Models\Pembayaran;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('layouts.dashboard-app', function($view) {
            $user = auth()->user();
            $role = $user->getRoleNames()->first();
            if($role == 'siswa') {
                $total_pembayaran = Pembayaran::where('user_id', $user->id)->where('status', 0)->count();
                $view->with('total_pembayaran', $total_pembayaran);
            } elseif($role == 'superadmin' || $role == 'admin') {
                $pembayaran_notif = Pembayaran::selectRaw("COALESCE(count(CASE WHEN status = 0 THEN id END), 0) as total_belum, COALESCE(count(CASE WHEN status = 1 THEN id END), 0) as total_sudah, COALESCE(count(CASE WHEN status = 3 THEN id END), 0) as total_tolak")->first();
                $view->with('pembayaran_notif', $pembayaran_notif);
            }
        });
        view()->composer('layouts.app', function($view) {
            if(request()->segment(1) == 'blog') {
                $data = LandingPage::find(1);
                $view->with('data', $data);
            }
        });
    }
}
