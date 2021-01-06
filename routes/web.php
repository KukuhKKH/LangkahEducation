<?php

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

            // Manajemen Role & Permission
            Route::group(['middleware' => ['role:superadmin']], function () {
                Route::resource('role', 'RolePermissionController')->except(['create', 'show']);
                Route::get('permission', 'RolePermissionController@permission')->name('role.permission');
                Route::post('permission/create', 'RolePermissionController@create')->name('permission.create');
                Route::post('permission', 'RolePermissionController@store_permission')->name('permission.store');
                Route::get('permission/attach/{id}', 'RolePermissionController@attach')->name('permission.attach');
                Route::put('/users/permission/{role}', 'RolePermissionController@setRolePermission')->name('users.setRolePermission');
                Route::get('permission/{id}', 'RolePermissionController@edit_permission')->name('permission.edit');
                Route::put('permission/{id}', 'RolePermissionController@update_permission')->name('permission.update');
                Route::delete('permission/{id}', 'RolePermissionController@destroy_permission')->name('permission.destroy');
            });

            // Lain lain
            Route::group(['middleware' => ['role:admin|superadmin']], function() {
                Route::resource('universitas', 'UniversitasController')->except(['create']);
                Route::post('universitas/import/batch', 'UniversitasController@import_batch')->name('universitas.import_batch');
                Route::resource('universitas/passing-grade', 'PassingGradeController');
                Route::resource('pendaftaran', 'PendaftaranController')->except(['create', 'show']);
                Route::resource('pembayaran', 'PembayaranController')->except(['create']);
                Route::get('pembayaran/{id_pembayaran}/detail-admin', 'PembayaranController@get_detail')->name('pembayaran-admin-detail');
                // Route::get('pembayaran/{status}', 'PembayaranController@index')->name('pembayaran.index');
                Route::get('pembayaran-siswa/status/{id}/{status}', 'PembayaranController@set_status');
                Route::resource('gambar', 'GambarController')->except(['create', 'show']);
                Route::resource('rekening', 'BankController')->except(['create', 'show']);
                Route::get('pendaftaran/list/siswa/{id}', 'PendaftaranController@list_siswa')->name('pendaftaran.list');
                Route::get('pendaftaran/list/sekolah/{id}', 'PendaftaranController@list_sekolah')->name('pendaftaran.list.sekolah');
                Route::resource('testimoni', 'TestimoniController');
                Route::get('testimoni/status/{id}/{status}', 'TestimoniController@set_status')->name('testimoni.status');
                Route::resource('layanan', 'LayananController');

                // Integrasi Gelombang Tryout
                Route::get('pendaftaran/tryout/{id}', 'PendaftaranController@integrasi_tryout')->name('pendaftaran.tryout');
                Route::post('pendaftaran/tryout/{id}', 'PendaftaranController@integrasi_tryout_store')->name('pendaftaran.tryout.store');

                // Koreksi Terbaru
                Route::get('koreksi/tryout/{gelombang_id}/{paket_id}', 'Siswa\TryoutController@koreksi_tryout_super_baru');

                // Manajemen Users
                Route::group(['namespace' => 'User'], function () {
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
                    Route::get('sekolah/produk/{id}', 'SekolahController@integrasi_produk')->name('sekolah.produk');
                    Route::post('sekolah/tryout/{id}', 'SekolahController@integrasi_tryout_store')->name('sekolah.tryout.store');
                    Route::post('sekolah/produk/{id}', 'SekolahController@integrasi_produk_store')->name('sekolah.produk.store');
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
                Route::post('pembayaran/export', 'PembayaranController@export_all')->name('pembayaran.export');

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
                Route::get('siswa/hasil/tryout/{gelombang_id}/{slug}', 'TryoutController@hasil')->name('tryout.hasil');
            });

            // Bebas
            Route::get('pemberitahuan', 'PemberitahuanController@index')->name('pemberitahuan.index');

            Route::get('mentoring','MentoringController@index')->name('mentorig.mentor');
            Route::get('mentoringvirtual/{siswa_id}','MentoringController@mentoring')->name('mentorig.mentoring');
            Route::get('mentoring/virtual','MentoringController@siswa')->name('mentorig.siswa');
            Route::get('hasiltryout/siswa/{id}', 'MentoringController@hasil_tryout');
            Route::post('mentoring/kirim/{siswa_id}/{mentor_id}', 'MentoringController@kirim_pesan')->name('kirim_pesan');
            Route::get('hasiltryout/siswa/{id}/{slug}/{user_id?}/detail', 'MentoringController@hasil_tryout_detail')->name('hasil_tryout.detail');
            Route::post('mentoring/komentar/{hasil_id}', 'MentoringController@komentar_store')->name('mentoring.komentar');
            Route::get('mentoring/pembahasan/{paket_id}/{kategori_id}/{hasil_id}', 'MentoringController@pembahasan')->name('mentoring.pembahasan');
            Route::get('mentoring/sekolah', 'MentoringController@mentoring_sekolah')->name('mentoring.sekolah');

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
                Route::get('pembayaran/{pembayaran_id}/delete', 'PembayaranController@siswa_destry')->name('pembayaran.siswa.destroy');

                Route::get('daftar/gelombang', 'PembayaranController@daftar_gelombang')->name('gelombang.siswa');
                Route::get('daftar-gelombang/{id}', 'PembayaranController@daftar_gelombang_store');

                Route::get('riwayat-tryout', 'Siswa\TryoutController@riwayat_tryout')->name('tryout.history');
            });
            
            Route::group(['namespace' => 'Siswa'], function () {
                // Tryout lama
                // Route::get('tryout/{slug}', 'TryoutController@tryout_mulai')->name('tryout.mulai');
                // Route::post('tryout/{paket}', 'TryoutController@tryout_store')->name('tryout.soal.store');
                
                // Tryout baru
                Route::get('tryout/{gelombang_id}/{token}/{slug}/detail', 'TryoutController@tryout_baru_detail')->name('tryout.siswa.detail');
                Route::get('tryout/{gelombang_id}/{token}/{slug}', 'TryoutController@tryout_baru')->name('tryout.mulai');
                Route::post('tryout/{gelombang_id}/{paket}', 'TryoutController@tryout_store_baru')->name('tryout.soal.store');
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
    Route::get('bwang', 'HelperController@clear_kabeh');
    Route::get('to', 'Dev\TryoutController@index');
    Route::get('soal', 'Dev\TryoutController@soal');
    Route::get('siap', 'HomeController@total_siswa_pg');
    Route::get('awdawd', function() {
        $jwb = [ 0 => 9, 1 => 10, 2 => 11, 3 => 12, 4 => 13, 5 => 14, 6 => 23, 7 => 24, 8 => 43, 9 => 44, 10 => 45, 11 => 46,];
        $soal = [ 0 => 9, 1 => 10, 2 => 11, 3 => 12, 4 => 13, 5 => 14, 6 => 23, 7 => 24, 8 => 43, 9 => 44, 10 => 45, 11 => 46, 12 => 58, ];
        dd($jwb, $soal);
         
        $total = count($soal);
        for($i = 0; $i < $total; $i++) {
            if($jwb[$i] != $soal[$i]) {
               array_splice($jwb, $i, 0, 'kosong');
            }
        }
        echo '<hr>';
        dd($jwb);
    });
});