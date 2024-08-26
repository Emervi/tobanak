<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CustomerChartController;
use App\Http\Controllers\CustomerCoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TestController;

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

// TEST AREA
Route::get('/test', [TestController::class, 'index'])->name('TEST');
Route::put('/test/put', [TestController::class, 'put'])->name('TEST.PUT');
// \TEST AREA

// ADMIN
Route::middleware('admin')->group(function () {

    // dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');



    // ADMIN.BARANG
    // halaman daftar barang
    Route::get('/admin/dashboard/barang', [BarangController::class, 'daftarBarang'])->name('admin.daftarBarang');
    // cari barang
    Route::post('/admin/dashboard/barang', [BarangController::class, 'cariBarang']);

    // route untuk get harga 
    Route::post('/get-harga', [BarangController::class, 'getHarga'])->name('get.harga');

    // halaman tambah barang
    Route::get('/admin/dashboard/barang/tambahBarang', [BarangController::class, 'tambahBarang'])->name('admin.tambahBarang');
    // halaman update barang
    Route::get('/admin/dashboard/barang/tambahBarang/{id_barang}/edit', [BarangController::class, 'editBarang'])->name('admin.editBarang');
    // store barang
    Route::post('/admin/dashboard/barang/tambahBarang', [BarangController::class, 'storeBarang']);
    // distribusi barang
    Route::put('/admin/dashboard/barang/distribusiBarang', [BarangController::class, 'distribusiBarang'])->name('admin.distribusiBarang');
    // tarik barang
    Route::put('/admin/dashboard/barang/tarikBarang', [BarangController::class, 'tarikBarang'])->name('admin.tarikBarang');
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
    
    // halaman tambah user
    Route::get('/admin/dashboard/user/tambahUser', [AdminController::class, 'tambahUser'])->name('admin.tambahUser');
    // store user
    Route::post('/admin/dashboard/user/tambahUser', [AdminController::class, 'storeUser']);

    // halaman ubah password user
    Route::get('/admin/dashboard/user/{id_user}/ubahPassword', [AdminController::class, 'ubahPassword'])->name('admin.ubahPassword');
    // update password user
    Route::put('/updatePassword/{id_user}', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

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



    // ADMIN.CABANG
    // halaman daftar cabang
    Route::get('/admin/dashboard/cabang', [CabangController::class, 'daftarCabang'])->name('admin.daftarCabang');
    // cari cabang
    Route::post('/admin/dashboard/cabang', [CabangController::class, 'cariCabang']);

    // halaman tambah cabang
    Route::get('/admin/dashboard/cabang/tambahCabang', [CabangController::class, 'tambahCabang'])->name('admin.tambahCabang');
    // halaman update cabang
    Route::get('/admin/dashboard/cabang/{id_cabang}/editCabang', [CabangController::class, 'editCabang'])->name('admin.editCabang');
    // store cabang
    Route::post('/admin/dashboard/cabang/tambahCabang', [CabangController::class, 'storeCabang']);
    // update cabang
    Route::put('/admin/dashboard/cabang/{id_cabang}', [CabangController::class, 'updateCabang'])->name('admin.updateCabang');
    // hapus cabang
    Route::delete('/admin/dashboard/cabang/{id_cabang}', [CabangController::class, 'destroyCabang'])->name('admin.hapusCabang');
    // \ADMIN.CABANG

    // ADMIN.EKSPEDISI
    // halaman daftar ekspedisi
    Route::get('/admin/dashboard/ekspedisi', [EkspedisiController::class, 'daftarEkspedisi'])->name('admin.daftarEkspedisi');
    // cari ekspedisi
    Route::post('/admin/dashboard/ekspedisi', [EkspedisiController::class, 'cariEkspedisi']);

    // halaman tambah ekspedisi
    Route::get('/admin/dashboard/ekspedisi/tambahEkspedisi', [EkspedisiController::class, 'tambahEkspedisi'])->name('admin.tambahEkspedisi');
    // halaman update ekspedisi
    Route::get('/admin/dashboard/ekspedisi/{id_ekspedisi}/editEkspedisi', [EkspedisiController::class, 'editEkspedisi'])->name('admin.editEkspedisi');
    // store ekspedisi
    Route::post('/admin/dashboard/ekspedisi/tambahEkspedisi', [EkspedisiController::class, 'storeEkspedisi']);
    // update ekspedisi
    Route::put('/admin/dashboard/ekspedisi/{id_ekspedisi}', [EkspedisiController::class, 'updateEkspedisi'])->name('admin.updateEkspedisi');
    // hapus ekspedisi
    Route::delete('/admin/dashboard/ekspedisi/{id_ekspedisi}', [EkspedisiController::class, 'destroyEkspedisi'])->name('admin.hapusEkspedisi');
    // \ADMIN.EKSPEDISI

});

// \ADMIN

// Halaman Kasir
Route::middleware('kasir')->group(function () {
    Route::get('/home', [KasirController::class, 'homeKasir'])->name('homeKasir');


    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/kurangi', [KeranjangController::class, 'kurangi'])->name('keranjang.kurangi');
    Route::post('/keranjang/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');


    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');
    Route::post('/proses-checkout', [TransaksiController::class, 'prosesCheckout'])->name('transaksi.prosesCheckout');

    Route::get('/detail-produk/{id_barang}', [KasirController::class, 'show'])->name('detailProduk');

    Route::get('/kasir/pesananBerhasil', [KasirController::class, 'notifikasiBerhasil'])->name('kasir.pesananBerhasil');


    Route::get('/distribusi', [DistribusiController::class, 'index'])->name('distribusi');
    Route::post('/distribusi/update-status/{id_barang}', [DistribusiController::class, 'updateStatus'])->name('distribusi.updateStatus');

    Route::get('/kasir/pesanan', [KasirController::class, 'daftarPesanan'])->name('kasir.daftarPesanan');
    Route::get('/kasir/pesanan/{id_transaksi}/detail', [KasirController::class, 'detailPesanan'])->name('kasir.detailPesanan');
    Route::put('/kasir/pesanan/kirimkanBarang/{id_transaksi}', [KasirController::class, 'kirimBarang'])->name('kasir.kirimBarang');
    Route::put('/kasir/pesanan/batalkanBarang/{id_transaksi}', [KasirController::class, 'batalBarang'])->name('kasir.batalBarang');
});
// Penutup Halaman Kasir

// CUSTOMER
Route::middleware('customer')->group(function () {

    Route::get('/customer/home', [CustomerController::class, 'index'])->name('customer.home');
    Route::get('/customer/detail-produk/{id_barang}', [CustomerController::class, 'show'])->name('customer.detail');

    Route::get('/customer/keranjang', [CustomerChartController::class, 'index'])->name('customer.keranjang');
    Route::post('/customer/keranjang/tambah', [CustomerChartController::class, 'tambah'])->name('customerKeranjang.tambah');
    Route::post('/customer/keranjang/kurangi', [CustomerChartController::class, 'kurangi'])->name('customerKeranjang.kurangi');
    Route::post('/customer/keranjang/hapus', [CustomerChartController::class, 'hapus'])->name('customerKeranjang.hapus');

    Route::get('/customer/checkout', [CustomerCoController::class, 'index'])->name('customer.checkout');
    Route::post('/customer/checkout/update-ekspedisi', [CustomerCoController::class, 'updateEkspedisi'])->name('update.ekspedisi');

    
    Route::post('/update-alamat', [CustomerCoController::class, 'updateAlamat'])->name('update.alamat');
    Route::post('/reset-address', [CustomerCoController::class, 'resetAlamat'])->name('reset.alamat');


    
    Route::post('/update-alamat', [CustomerCoController::class, 'updateAlamat'])->name('update.alamat');
    Route::post('/reset-address', [CustomerCoController::class, 'resetAlamat'])->name('reset.alamat');
    
});
// \CUSTOMER

// GUEST
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
// \GUEST

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// \LOGOUT