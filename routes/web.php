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

Route::group(['middleware' => ['auth', 'email']], function() {
    Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::group(['namespace' => 'Web'], function () {
        Route::group(['prefix' => 'dashboard'], function() {

            Route::group(['middleware' => ['role:superadmin']], function () {
                Route::resource('role', 'RolePermissionController')->except(['create', 'show']);
                Route::get('permission', 'RolePermissionController@permission')->name('role.permission');
                Route::post('permission/create', 'RolePermissionController@create')->name('permission.create');
                Route::post('permission', 'RolePermissionController@store_permission')->name('permission.store');
                Route::get('permission/attach', 'RolePermissionController@attach')->name('permission.attach');
            });

            Route::group(['namespace' => 'User', 'middleware' => ['role:admin|superadmin']], function() {

                Route::resource('user', 'UserController');
                Route::resource('mentor', 'MentorController');
                Route::resource('sekolah', 'SekolahController');
                Route::resource('admin', 'AdminController');
                Route::resource('superadmin', 'SuperadminController');
                Route::resource('siswa', 'SiswaController');
            });
        });
    });
});

Route::get('/home', 'HomeController@index')->name('home');
