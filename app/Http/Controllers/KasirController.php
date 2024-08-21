<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KasirController extends Controller
{

    public function homeKasir(Request $request)
    {

        $id_kasir = session('kasir')->id_user;
        $cabang_kasir = session('kasir')->id_cabang;
        $cabangs = Cabang::where('id_cabang', $cabang_kasir)->first();


        $totalJumlah = Keranjang::where('id_user', $id_kasir)
        ->sum('kuantitas');


        $filter = $request->query('filter');
        $kategori = Barang::where('id_cabang', $cabang_kasir)
        ->where('distribusi', 'Diterima')
        ->distinct()
        ->pluck('kategori_barang');


        $query = Barang::where('id_cabang', $cabang_kasir)
            ->where('distribusi', 'Diterima');

        if ($filter) {
            $query->where('kategori_barang', $filter);
        }

        $barangs = $query->get();

        // Menghitung harga asli untuk setiap barang
        foreach ($barangs as $barang) {
            $bahan = $barang->bahan;
            switch ($bahan) {
                case 'Tebal':
                    $modal = 20000 * 10;
                    break;
                case 'Street':
                    $modal = 19000 * 10;
                    break;
                case 'Sedang':
                    $modal = 18000 * 10;
                    break;
                default:
                    $modal = 17000 * 10;
                    break;
            }

            $bebanProduksi = (2 / 100) * $modal;
            $keuntungan = (25 / 100) * $modal;
            $hargaJual = $modal + $bebanProduksi + $keuntungan;

            $barang->harga_asli = $hargaJual; // Menyimpan harga asli dalam objek barang
        }

       

        return view('kasir.home', compact('barangs', 'kategori', 'totalJumlah', 'cabangs'));
    }

    public function keranjang()
    {
        return view('kasir.keranjang');
    }

    public function show($id_barang)
    {
        $id_kasir = session('kasir')->id_user;

        $barang = Barang::where('id_barang', $id_barang)->firstOrFail();

        $totalJumlah = Keranjang::where('id_user', $id_kasir)
        ->sum('kuantitas');

        $bahan = $barang->bahan;

        switch ($bahan) {
            case 'Tebal':
                $modal = 20000 * 10;
                break;
            case 'Street':
                $modal = 19000 * 10;
                break;
            case 'Sedang':
                $modal = 18000 * 10;
                break;
            default:
                $modal = 17000 * 10;
                break;
        }

        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $bebanProduksi + $keuntungan;

        $barang->harga_asli = $hargaJual;

        return view('kasir.detail', compact('barang', 'totalJumlah'));
    }

    // Penutup Halaman User

    // notifikasi pesanan berhasil
    public function notifikasiBerhasil()
    {
        $cabang_kasir = session('kasir')->id_cabang;
        $cabangs = Cabang::where('id_cabang', $cabang_kasir)->first();

        return view('kasir.notifikasiPesananBerhasil', compact('cabangs'));
    }
    // \notifikasi pesanan berhasil
}


