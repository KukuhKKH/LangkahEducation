<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
    Route::group(['namespace' => 'Api\V1'], function () {
        Route::get('get-prodi/{kelompok_id}/{universitas_id}', 'DataTryoutController@get_prodi');
    });
    Route::post('blog/like/status/{blog_id}/{user_id}/{status}', 'Web\Blog\PageController@set_like');
});