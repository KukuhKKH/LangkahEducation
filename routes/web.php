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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('verify/{token}', 'HomeController@verifyUserRegistration')->name('user.verify');

Route::group(['middleware' => ['auth', 'status_user', 'status_email']], function() {
    Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::group(['namespace' => 'Web'], function () {

        Route::group(['prefix' => 'dashboard'], function() {

            Route::group(['middleware' => ['role:superadmin']], function () {
                // Manajemen Role & Permission
                Route::resource('role', 'RolePermissionController')->except(['create', 'show']);
                Route::get('permission', 'RolePermissionController@permission')->name('role.permission');
                Route::post('permission/create', 'RolePermissionController@create')->name('permission.create');
                Route::post('permission', 'RolePermissionController@store_permission')->name('permission.store');
                Route::get('permission/attach/{id}', 'RolePermissionController@attach')->name('permission.attach');
                Route::put('/users/permission/{role}', 'RolePermissionController@setRolePermission')->name('users.setRolePermission');
            });

            Route::group(['namespace' => 'User', 'middleware' => ['role:admin|superadmin']], function() {
                // Manajemen Users
                Route::resource('mentor', 'MentorController');
                Route::resource('sekolah', 'SekolahController')->except(['create']);
                Route::resource('admin', 'AdminController')->except(['create', 'show']);
                Route::resource('superadmin', 'SuperadminController')->except(['create', 'show']);
                Route::resource('siswa', 'SiswaController')->except(['create', 'show']);

                // Integrasi Data
                Route::post('sekolah/integrasi/{id}', 'SekolahController@integrasi')->name('sekolah.integrasi');
                Route::post('sekolah/integrasi/{id}/hapus', 'SekolahController@hapus_integrasi')->name('sekolah.integrasi.hapus');
                Route::post('mentor/integrasi/{id}', 'MentorController@integrasi')->name('mentor.integrasi');
                Route::post('mentor/integrasi/{id}/hapus', 'MentorController@hapus_integrasi')->name('mentor.integrasi.hapus');
            });

            Route::group(['middleware' => ['role:admin|superadmin|sekolah']], function () {
                // Import dan Eksport
                Route::post('siswa/import', 'User\SiswaController@import')->name('siswa.import');
                Route::post('sekolah/import', 'User\SekolahController@import')->name('sekolah.import');
                Route::post('mentor/import', 'User\MentorController@import')->name('mentor.import');

                // Tryout Route
                Route::group(['namespace' => 'Tryout', 'prefix' => 'tryout'], function () {
                    Route::resource('soal', 'TryoutController');
                    Route::resource('kategori', 'KategoriController');
                    Route::resource('paket', 'PaketController');
                });
            });
        });
    });
});

Route::get('/home', 'HomeController@index')->name('home');

// URL COBA COBA
Route::group(['prefix' => 'dev'], function() {
    Route::get('email', function() {
        $user = new stdClass;
        $user->name = "siapa";
        $user->activate_token = "awdawdawd";
        return view('emails.register', compact('user'));
    });
});