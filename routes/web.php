<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
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

// ADMIN
// dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');

// ADMIN.BARANG
// halaman daftar barang
Route::get('/admin/dashboard/barang', [BarangController::class, 'daftarBarang'])->name('admin.daftarBarang');
// cari barang
Route::post('/admin/dashboard/barang', [BarangController::class, 'cariBarang']);

// halaman tambah barang
Route::get('/admin/dashboard/barang/tambahBarang', [BarangController::class, 'tambahBarang'])->name('admin.tambahBarang');
// halaman update barang
Route::get('/admin/dashboard/barang/tambahBarang/{id_barang}/edit', [BarangController::class, 'editBarang'])->name('admin.editBarang');
// store barang
Route::post('/admin/dashboard/barang/tambahBarang', [BarangController::class, 'storeBarang']);
// update barang
Route::put('/admin/dashboard/barang/tambahBarang/{id_barang}', [BarangController::class, 'updateBarang'])->name('admin.updateBarang');
// hapus barang
Route::delete('/admin/dashboard/barang/{id_barang}', [BarangController::class, 'destroyBarang'])->name('admin.hapusBarang');
// \ADMIN.BARANG

// ADMIN.USER
// halaman daftar user
Route::get('/admin/dashboard/user', [AdminController::class, 'daftarUser'])->name('admin.daftarUser');
// cari user
Route::post('/admin/dashboard/user', [AdminController::class, 'cariUser']);

// halaman update user
Route::get('/admin/dashboard/user/{id_user}/editUser', [AdminController::class, 'editUser'])->name('admin.editUser');
// update user
Route::put('/admin/dashboard/user/{id_user}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
// hapus barang
Route::delete('/admin/dashboard/user/{id_user}', [AdminController::class, 'destroyUser'])->name('admin.hapusUser');

// \ADMIN.USER



// \ADMIN

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

Route::get('/detail-produk/{id_barang}', [UserController::class, 'show'])->name('detailProduk');

// Penutup Halaman User
