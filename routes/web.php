<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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

// LOGIN
Route::get('/login', [LoginController::class, 'tampilLogin'])->name('auth.login');
Route::post('/login', [LoginController::class, 'login']);
// \LOGIN

// REGISTER
Route::get('/register', [RegisterController::class, 'halamanRegister'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'storeRegister']);
// \REGISTER

Route::get('/', function () {
    return view('home');
});

// Halaman User

Route::get('/home', [UserController::class, 'homeUser'])->name('homeUser');
Route::get('/keranjang', [UserController::class, 'keranjang'])->name('keranjang');

// Penutup Halaman User
