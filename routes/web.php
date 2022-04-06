<?php

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

//Route::get('/home', function () {
//    return view('home');
//});

Route::get('/home',  'App\Http\Controllers\DashboardController@getCountries');
Route::get('/',  'App\Http\Controllers\DashboardController@getCountries');

Route::get('/addAbonnement',  'App\Http\Controllers\addAbonnementController@getAbonnementen')->name('get-abonnementen');
Route::post('/addAbonnement/submit', 'App\Http\Controllers\addAbonnementController@addAbonnement')->name('addAbonnement-form-submit');
Route::post('/addAbonnement/{abonnement_id}/submit', 'App\Http\Controllers\addAbonnementController@editAbonnement')->name('editAbonnement-form-submit');
Route::get('/addAbonnement/{abonnement_id}/submit', 'App\Http\Controllers\addAbonnementController@deleteAbonnement')->name('deleteAbonnement');

//route voor add//edit/delete user page
Route::get('/addUser',  'App\Http\Controllers\addUserController@getUsers')->name('get-users');
Route::post('/addUser/submit', 'App\Http\Controllers\addUserController@addUser')->name('addUser-form-submit');
Route::post('/addUser/{user_id}/submit', 'App\Http\Controllers\addUserController@editUser')->name('editUser-form-submit');
Route::get('/addUser/{user_id}/submit', 'App\Http\Controllers\addUserController@deleteUser')->name('deleteUser');

Route::post('/login/submit', 'App\Http\Controllers\LoginControllerapp@submit')->name('login-form-submit');
Route::post('/login/checklogin', 'App\Http\Controllers\LoginController@checklogin')->name('checklogin');;
Route::get('login/successlogin', 'App\Http\Controllers\LoginController@successlogin');
Route::get('login/logout', 'App\Http\Controllers\LoginController@logout');
