<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    
    // halaman daftar transaksi
    public function daftarTransaksi()
    {
        $perPage = 5;

        $transaksis = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
        ->join('barangs', 'transaksis.id_barang', '=', 'barangs.id_barang')
        ->select('transaksis.*', 'users.name', 'barangs.nama_barang')
        ->latest()
        ->paginate($perPage);

        $currentPage = $transaksis->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarTransaksi', compact('transaksis', 'offset'));
    }

    // cari transaksi
    public function cariTransaksi(Request $request)
    {
        $perPage = 5;

        $query = $request->keyword_transaksi;
        $transaksis = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
        ->join('barangs', 'transaksis.id_barang', '=', 'barangs.id_barang')
        ->select('transaksis.*', 'users.name', 'barangs.nama_barang')
        ->where('tanggal', $query)
        ->paginate($perPage);

        $currentPage = $transaksis->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarTransaksi', compact('transaksis', 'offset'));
    }

    // destroy transaksi
    public function destroyTransaksi($id_transaksi)
    {
        Transaksi::where('id_transaksi', $id_transaksi)
        ->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }

}
