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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::get('email/verify/{id}', 'Api\VerificationController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\VerificationController@resend')->name('verificationapi.resend');

Route::get('user', 'Api\UserController@index');
Route::get('user/{id}', 'Api\UserController@show');
Route::post('user', 'Api\UserController@store');
Route::put('user/{id}', 'Api\UserController@update');
Route::delete('user/{id}', 'Api\UserController@destroy');

Route::get('pendaftaran', 'Api\PendaftaranController@index');
Route::get('pendaftaran/{id}', 'Api\PendaftaranController@show');
Route::post('pendaftaran', 'Api\PendaftaranController@store');
Route::put('pendaftaran/{id}', 'Api\PendaftaranController@update');
Route::delete('pendaftaran/{id}', 'Api\PendaftaranController@destroy');

Route::get('transaksi_obat', 'Api\TransaksiObatController@index');
Route::get('transaksi_obat/{id}', 'Api\TransaksiObatController@show');
Route::post('transaksi_obat', 'Api\TransaksiObatController@store');
Route::put('transaksi_obat/{id}', 'Api\TransaksiObatController@update');
Route::delete('transaksi_obat/{id}', 'Api\TransaksiObatController@destroy');


Route::group(['middleware' => 'auth:api'], function() {

});

// Route::post('logout', 'Api\AuthController@logout');
