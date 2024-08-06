<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
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
Route::middleware('admin')->group(function () {

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

    // // reset harga
    // Route::put('/resetHarga/{id_barang}', [BarangController::class, 'resetHarga'])->name('admin.resetHarga');
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
    // hapus user
    Route::delete('/admin/dashboard/user/{id_user}', [AdminController::class, 'destroyUser'])->name('admin.hapusUser');
    // \ADMIN.USER

    // ADMIN.TRANSAKSI
    // halaman daftar transaksi
    Route::get('/admin/dashboard/transaksi', [TransaksiController::class, 'daftarTransaksi'])->name('admin.daftarTransaksi');
    // cari transaksi
    Route::post('/admin/dashboard/transaksi', [TransaksiController::class, 'cariTransaksi']);

    // detail transaksi
    Route::get('/admin/dashboard/transaksi/{id_transaksi}/detail', [TransaksiController::class, 'detailTransaksi'])->name('admin.detailTransaksi');

    // hapus transaksi
    Route::delete('/admin/dashboard/transaksi/{id_transaksi}', [TransaksiController::class, 'destroyTransaksi'])->name('admin.hapusTransaksi');
    // \ADMIN.TRANSAKSI

});

// \ADMIN

Route::middleware('cek_session_null')->group(function () {

    // landing page
    Route::get('/', function () {
        return view('home');
    })->name('landingPage');
    // \landing page

    // LOGIN
    Route::get('/login', [LoginController::class, 'tampilLogin'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login']);
    // \LOGIN

    // REGISTER
    Route::get('/register', [RegisterController::class, 'halamanRegister'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'storeRegister']);
    // \REGISTER

});

// Halaman User
Route::middleware('user')->group(function () {
    Route::get('/home', [UserController::class, 'homeUser'])->name('homeUser');


    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/kurangi', [KeranjangController::class, 'kurangi'])->name('keranjang.kurangi');
    Route::post('/keranjang/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');


    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');
    Route::post('/proses-checkout', [TransaksiController::class, 'prosesCheckout'])->name('transaksi.prosesCheckout');

    Route::get('/detail-produk/{id_barang}', [UserController::class, 'show'])->name('detailProduk');

    Route::get('/user/pesananBerhasil', [UserController::class, 'notifikasiBerhasil'])->name('user.pesananBerhasil');
    // Penutup Halaman User
});

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// \LOGOUT