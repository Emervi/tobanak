<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // Halaman User

    public function homeUser(Request $request)
    {
        $barangs = Barang::all();

        $filter = $request->query('filter');
        $kategori = Barang::select('kategori_barang')->distinct()->pluck('kategori_barang');

        if ($filter) {
            $barangs = Barang::where('kategori_barang', $filter)->get();
        } else {
            $barangs = Barang::all();
        }

        return view('user.home', compact('barangs', 'kategori'));
    }

    public function keranjang()
    {
        return view('user.keranjang');
    }

    public function show($id_barang)
    {
        $barang = Barang::where('id_barang', $id_barang)->firstOrFail();
        return view('user.detail', compact('barang'));
    }


    // Penutup Halaman User

    // notifikasi pesanan berhasil
    public function notifikasiBerhasil()
    {
        return view('user.notifikasiPesananBerhasil');
    }
    // \notifikasi pesanan berhasil

}
