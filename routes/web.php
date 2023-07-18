<?php

use App\Http\Controllers\LoginController;
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
    return view('home');
});

//ui register
Route::get('/register', function () {
    return view('register');
});

//ui login
Route::get('/login', function () {
    return view('login');
});

//masukin registrasi ke database
Route::post('/register', [LoginController::class,'store']);


//validasi login dari database
Route::post('/login', [LoginController::class,'login']);

//logout
Route::get('/logout', [LoginController::class, 'logout']);


// developer
Route::get('/developer', function () {
    return view('developer.home');
})->middleware('CheckDeveloper');

//buyer
Route::get('/buyer', function () {
    return view('buyer.home');
})->middleware('CheckBuyer');
