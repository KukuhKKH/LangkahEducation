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
//    return view('welcome');
    $location = \Illuminate\Support\Facades\Request::ip();
    $hasil = \Stevebauman\Location\Facades\Location::get("125.166.7.206");
    dd($hasil);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
