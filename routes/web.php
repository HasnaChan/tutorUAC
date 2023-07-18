<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;

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

Route::group(['prefix' => 'developer', 'middleware' => 'CheckDeveloper'], function(){
        Route::get('/', [UserController::class, 'developerIndex']);

        Route::get('/add-game', [GameController::class, 'create']);
        Route::get('/add-game/{locale?}', [GameController::class, 'create']);
        Route::post('/add-game', [GameController::class, 'store']);
        Route::get('edit-game/{game_id}', [GamPeController::class, 'edit']);
        Route::put('update-game', [GameController::class, 'update']);
});




//buyer
// Route::get('/buyer', function () {
//     return view('buyer.home');
// })->middleware('CheckBuyer');

Route::group(['prefix' => 'buyer', 'middleware' => 'CheckBuyer'], function(){
        Route::get('/', [UserController::class, 'buyerIndex']);
        Route::put('/top-up', [UserController::class, 'topup']);
        Route::get('/buy-game', [GameController::class, 'show']);
        Route::post('/buy-game', [TransactionController::class, 'store']);
});
