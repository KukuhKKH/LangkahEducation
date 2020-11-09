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

Route::group(['namespace' => 'Web'], function() {
    Route::resource('role', 'RolePermissionController')->except(['create', 'show']);
    Route::group(['namespace' => 'User'], function() {
        Route::resource('user', 'UserController');
        Route::resource('mentor', 'MentorController');
        Route::resource('sekolah', 'SekolahController');
        Route::resource('admin', 'AdminController');
        Route::resource('superadmin', 'SuperadminController');
        Route::resource('siswa', 'SiswaController');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
