<?php

use App\Http\Controllers\WeatherDataController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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
    return view('home');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/home', function () {
    return view('home');
});
Route::post('/login/submit', 'App\Http\Controllers\LoginControllerapp@submit')->name('login-form-submit');
Route::post('/login/checklogin', 'App\Http\Controllers\LoginController@checklogin')->name('checklogin');
Route::get('login/successlogin', 'App\Http\Controllers\LoginController@successlogin');
Route::get('login/logout', 'App\Http\Controllers\LoginController@logout');

Route::post('/weatherData', 'App\Http\Controllers\WeatherDataController@insertData')->name('weatherData');
