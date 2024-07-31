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

        foreach ($barangs as $barang) {
            $bahan = $barang->bahan;
            if ($bahan == 'tebal') {
                $modal = 20000 * 10;
            } else if ($bahan == 'street') {
                $modal = 19000 * 10;
            } else if ($bahan == 'sedang') {
                $modal = 18000 * 10;
            } else {
                $modal = 17000 * 10;
            }

            $bebanProduksi = (2 / 100) * $modal;
            $keuntungan = (25 / 100) * $modal;
            $hargaJual = $modal + $keuntungan + $bebanProduksi;

            $barang->harga_asli = $hargaJual; // Menyimpan harga asli dalam objek barang
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


        $bahan = $barang->bahan;

        if ($bahan == 'tebal') {
            $modal = 20000 * 10;
        } else if ($bahan == 'street') {
            $modal = 19000 * 10;
        } else if ($bahan == 'sedang') {
            $modal = 18000 * 10;
        } else {
            $modal = 17000 * 10;
        }

        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $bebanProduksi + $keuntungan;

        $barang->harga_asli = $hargaJual;

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
