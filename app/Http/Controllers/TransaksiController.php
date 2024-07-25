<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    
    // halaman daftar transaksi
    public function daftarTransaksi()
    {
        $transaksis = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
        ->join('barangs', 'transaksis.id_barang', '=', 'barangs.id_barang')
        ->select('transaksis.*', 'users.name', 'barangs.nama_barang')
        ->get();

        return view('admin.daftarTransaksi', compact('transaksis'));
    }

    // cari transaksi
    public function cariTransaksi(Request $request)
    {
        $query = $request->keyword_transaksi;
        $transaksis = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
        ->join('barangs', 'transaksis.id_barang', '=', 'barangs.id_barang')
        ->select('transaksis.*', 'users.name', 'barangs.nama_barang')
        ->where('tanggal', $query)
        ->get();

        return view('admin.daftarTransaksi', compact('transaksis'));
    }

    // destroy transaksi
    public function destroyTransaksi($id_transaksi)
    {
        Transaksi::where('id_transaksi', $id_transaksi)
        ->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }

}
