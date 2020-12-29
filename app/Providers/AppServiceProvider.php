<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\HelperController;
use App\Models\Komentar;
use App\Models\LandingPage;
use App\Models\Mentoring;
use App\Models\Pembayaran;
use App\Models\TryoutHasil;

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
                $chat_masuk = Mentoring::where('siswa_id', $user->siswa->id)->where('status', 0)->where('pengirim', 'mentor')->get();
                $to_id = TryoutHasil::where('user_id', $user->id)->get()->pluck('id');
                $komentar_mentor = Komentar::with(['hasil'])->whereIn('tryout_hasil_id', $to_id)->where('status', 0)->get();
                $view->with('komentar_mentor', $komentar_mentor);
                $view->with('total_pembayaran', $total_pembayaran);
                $view->with('chat_masuk', $chat_masuk);
            } elseif($role == 'superadmin' || $role == 'admin') {
                $pembayaran_notif = Pembayaran::selectRaw("COALESCE(count(CASE WHEN status = 0 THEN id END), 0) as total_belum, COALESCE(count(CASE WHEN status = 1 THEN id END), 0) as total_sudah, COALESCE(count(CASE WHEN status = 3 THEN id END), 0) as total_tolak")->first();
                $view->with('pembayaran_notif', $pembayaran_notif);
            } elseif($role == 'mentor') {
                $chat_masuk = Mentoring::where('mentor_id', $user->mentor->id)->where('status', 0)->where('pengirim', 'siswa')->get();
                $view->with('chat_masuk', $chat_masuk);
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
