<?php

use App\Http\Controllers\RegisterController;
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

// REGISTER
Route::get('/register', [RegisterController::class, 'halamanRegister'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'storeRegister']);
// \REGISTER

Route::get('/', function () {
    return view('welcome');
});
