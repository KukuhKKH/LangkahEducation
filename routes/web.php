<?php

use App\Models\LandingPage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Web\PageController@index')->name('landing-page');

Route::group(['prefix' => 'filemanager'], function() {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Auth::routes();

Route::get('verify/{token}', 'HomeController@verifyUserRegistration')->name('user.verify');

Route::group(['middleware' => ['auth', 'status_user', 'status_email']], function() {
    Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::group(['namespace' => 'Web'], function () {

        Route::group(['prefix' => 'dashboard'], function() {

            Route::get('profil', 'ProfileController@index')->name('profile.index');
            Route::get('profil/{user}/edit', 'ProfileController@edit')->name('profile.edit');
            Route::put('profil/{user}', 'ProfileController@update')->name('profile.update');
            Route::post('profil/kode_referal/{user}', 'ProfileController@kode_referal')->name('profil.kode_referal');

            Route::get('landing-page', 'PageController@landing_page')->name('landing_page.index');
            Route::post('landing-page/{id}', 'PageController@update')->name('landing_page.update');

            Route::group(['middleware' => ['role:superadmin']], function () {
                // Manajemen Role & Permission
                Route::resource('role', 'RolePermissionController')->except(['create', 'show']);
                Route::get('permission', 'RolePermissionController@permission')->name('role.permission');
                Route::post('permission/create', 'RolePermissionController@create')->name('permission.create');
                Route::post('permission', 'RolePermissionController@store_permission')->name('permission.store');
                Route::get('permission/attach/{id}', 'RolePermissionController@attach')->name('permission.attach');
                Route::put('/users/permission/{role}', 'RolePermissionController@setRolePermission')->name('users.setRolePermission');
            });

            Route::group(['middleware' => ['role:admin|superadmin']], function() {
                // Lain lain
                Route::resource('universitas', 'UniversitasController')->except(['create']);
                Route::post('universitas/import/batch', 'UniversitasController@import_batch')->name('universitas.import_batch');
                Route::resource('universitas/passing-grade', 'PassingGradeController');
                Route::resource('pendaftaran', 'PendaftaranController')->except(['create', 'show']);
                Route::resource('pembayaran', 'PembayaranController')->except(['create']);
                // Route::get('pembayaran/{status}', 'PembayaranController@index')->name('pembayaran.index');
                Route::get('pembayaran-siswa/status/{id}/{status}', 'PembayaranController@set_status');
                Route::resource('gambar', 'GambarController')->except(['create', 'show']);
                Route::resource('rekening', 'BankController')->except(['create', 'show']);
                Route::get('pendaftaran/list/siswa/{id}', 'PendaftaranController@list_siswa')->name('pendaftaran.list');
                Route::resource('testimoni', 'TestimoniController');
                Route::get('testimoni/status/{id}/{status}', 'TestimoniController@set_status')->name('testimoni.status');
                Route::resource('layanan', 'LayananController');

                // Integrasi Gelombang Tryout
                Route::get('pendaftaran/tryout/{id}', 'PendaftaranController@integrasi_tryout')->name('pendaftaran.tryout');
                Route::post('pendaftaran/tryout/{id}', 'PendaftaranController@integrasi_tryout_store')->name('pendaftaran.tryout.store');

                Route::group(['namespace' => 'User'], function () {
                    // Manajemen Users
                    Route::resource('mentor', 'MentorController');
                    Route::resource('sekolah', 'SekolahController')->except(['create']);
                    Route::resource('admin', 'AdminController')->except(['create', 'show']);
                    Route::resource('superadmin', 'SuperadminController')->except(['create', 'show']);
                    Route::resource('siswa', 'SiswaController')->except(['create', 'show']);
                    Route::resource('author', 'AuthorController')->except(['create', 'show']);
                    Route::resource('daftar/sekolah/nisn', 'SekolahNisnController');
    
                    // Integrasi Data
                    Route::post('sekolah/integrasi/{id}', 'SekolahController@integrasi')->name('sekolah.integrasi');
                    Route::post('sekolah/integrasi/{id}/hapus', 'SekolahController@hapus_integrasi')->name('sekolah.integrasi.hapus');
                    Route::post('mentor/integrasi/{id}', 'MentorController@integrasi')->name('mentor.integrasi');
                    Route::post('mentor/integrasi/{id}/hapus', 'MentorController@hapus_integrasi')->name('mentor.integrasi.hapus');
                    Route::get('sekolah/tryout/{id}', 'SekolahController@integrasi_tryout')->name('sekolah.tryout');
                    Route::post('sekolah/tryout/{id}', 'SekolahController@integrasi_tryout_store')->name('sekolah.tryout.store');
                });
            });

            Route::group(['middleware' => ['role:admin|superadmin|sekolah']], function () {
                // Import dan Eksport
                Route::post('siswa/import', 'User\SiswaController@import')->name('siswa.import');
                Route::post('sekolah/import', 'User\SekolahController@import')->name('sekolah.import');
                Route::post('mentor/import', 'User\MentorController@import')->name('mentor.import');
                route::post('universitas/import', 'UniversitasController@import')->name('universitas.import');
                route::post('passing-grade/import', 'PassingGradeController@import')->name('passing-grade.import');
                Route::post('sekolah/nisn/import', 'User\SekolahNisnController@import')->name('sekolah.nisn.import');

                // Tryout Route
                Route::group(['namespace' => 'Tryout', 'prefix' => 'tryout'], function () {
                    Route::resource('kategori-soal', 'KategoriSoalController')->except(['create', 'show']);
                    Route::resource('soal', 'TryoutController')->except(['create']);
                    Route::get('soal/create/{slug}', 'TryoutController@create')->name('soal.create');
                    Route::resource('paket', 'PaketController')->except(['create']);
                    Route::get('tryout/paket/{id}/detail', 'PaketController@show_soal')->name('paket.soal.detail');

                    // Import
                    Route::post('soal/import/batch', 'TryoutController@import_batch')->name('soal.import_batch');
                });
            });
            
            // Tryout Siswa
            Route::group(['middleware' => 'role:siswa', 'namespace' => 'Siswa'], function () {
                Route::get('siswa/tryout', 'TryoutController@index')->name('siswa.tryout.index');
                Route::get('siswa/tryout/{paket}', 'TryoutController@paket')->name('siswa.tryout.paket');
                Route::get('siswa/hasil/tryout/{slug}', 'TryoutController@hasil')->name('tryout.hasil');
            });

            // Bebas
            Route::get('pemberitahuan', 'PemberitahuanController@index')->name('pemberitahuan.index');

            Route::get('mentoring','MentoringController@index')->name('mentorig.mentor');
            Route::get('mentoringvirtual/{siswa_id}','MentoringController@mentoring')->name('mentorig.mentoring');
            Route::get('mentoring/virtual','MentoringController@siswa')->name('mentorig.siswa');
            Route::get('hasiltryout/siswa/{id}', 'MentoringController@hasil_tryout');
            Route::post('mentoring/kirim/{siswa_id}/{mentor_id}', 'MentoringController@kirim_pesan')->name('kirim_pesan');
            Route::get('hasiltryout/siswa/{id}/{slug}/detail', 'MentoringController@hasil_tryout_detail')->name('hasil_tryout.detail');
            Route::post('mentoring/komentar/{hasil_id}', 'MentoringController@komentar_store')->name('mentoring.komentar');
            Route::get('mentoring/pembahasan/{paket_id}/{kategori_id}', 'MentoringController@pembahasan')->name('mentoring.pembahasan');

            Route::get('bank/{id}', 'BankController@show_bank');

            Route::group(['namespace' => 'Blog'], function () {
                Route::resource('blog', 'BlogController');
                Route::resource('kategori-blog', 'BlogKategoriController');
            });
        });
        // End Prefix Dashboard

        Route::group(['middleware' => 'role:siswa'], function () {
            Route::group(['prefix' => 'dashboard'], function() {
                Route::get('pembayaran-siswa', 'PembayaranController@siswa')->name('pembayaran.siswa');
                Route::get('pembayaran-siswa/{pembayaran_id}/{slug}', 'PembayaranController@siswa_show')->name('pembayaran.siswa.show');
                Route::post('pembayaran-siswa/{pembayaran_id}', 'PembayaranController@siswa_bayar')->name('pembayaran.siswa.bayar');
                Route::get('pembayaran-siswa/{pembayaran_id}', 'PembayaranController@siswa_edit')->name('pembayaran.siswa.edit');
                Route::put('pembayaran-siswa/{pembayaran_id}', 'PembayaranController@siswa_update')->name('pembayaran.siswa.update');
                Route::get('pembayaran/{pembayaran_id}/detail', 'PembayaranController@detail_pembayaran')->name('pembayaran-siswa.detail');

                Route::get('daftar/gelombang', 'PembayaranController@daftar_gelombang')->name('gelombang.siswa');
                Route::get('daftar-gelombang/{id}', 'PembayaranController@daftar_gelombang_store');
            });
            
            Route::group(['namespace' => 'Siswa'], function () {
                // Tryout lama
                // Route::get('tryout/{slug}', 'TryoutController@tryout_mulai')->name('tryout.mulai');
                // Route::post('tryout/{paket}', 'TryoutController@tryout_store')->name('tryout.soal.store');
                
                // Tryout baru
                Route::get('tryout/{token}/{slug}/detail', 'TryoutController@tryout_baru_detail')->name('tryout.siswa.detail');
                Route::get('tryout/{token}/{slug}', 'TryoutController@tryout_baru')->name('tryout.mulai');
                Route::post('tryout/{paket}', 'TryoutController@tryout_store_baru')->name('tryout.soal.store');
            });
        });
    });
});

Route::group(['prefix' => 'blog', 'namespace' => 'Web\Blog'], function () {
    Route::get('/', 'PageController@index')->name('page.blog.index');
    Route::get('/{slug}', 'PageController@detail')->name('page.blog.detail');
    Route::get('/author/{kode}', 'PageController@detail_author')->name('page.blog.author');
    Route::get('/kategori/{kategori}', 'PageController@kategori')->name('page.blog.kategori');
    Route::post('blog/komentar/{blog_id}', 'PageController@komentar')->name('page.blog.komentar.store');
});

Route::get('/home', 'HomeController@dashboard')->name('home');

// URL COBA COBA
Route::group(['prefix' => 'dev'], function() {
    Route::get('email', function() {
        $user = new stdClass;
        $user->name = "siapa";
        $user->activate_token = "awdawdawd";
        return view('emails.register', compact('user'));
    });
    Route::get('blog', function() {
        return view('pages.blog.author-profile');
    });
    Route::get('detail', function() {
        return view('pages.blog.list');
    });
});