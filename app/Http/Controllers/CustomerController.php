<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cabang;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $id_user = session('user')->id_user;
        $cabang_user = session('user')->id_cabang;
        $cabangs = Cabang::where('id_cabang', $cabang_user)->first();

        $totalJumlah = Keranjang::where('id_user', $id_user)
            ->sum('kuantitas');

        $filter = $request->query('filter');
        $kategori = Barang::where('distribusi', 'Diterima')
            ->distinct()
            ->pluck('kategori_barang');

        $query = Barang::where('distribusi', 'Diterima');

        if ($filter) {
            $query->where('kategori_barang', $filter);
        }

        // Load 'cabang' relationship
        $barangs = $query->with('cabang')->get();

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

            $barang->harga_asli = $hargaJual;
        }

        return view('customer.home', compact('barangs', 'kategori', 'totalJumlah', 'cabangs'));
    }


    public function keranjang()
    {
        return view('customer.keranjang');
    }

    public function show($id_barang)
    {
        $id_user = session('user')->id_user;

        $barang = Barang::where('id_barang', $id_barang)->firstOrFail();

        $totalJumlah = Keranjang::where('id_user', $id_user)
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

        return view('customer.detail', compact('barang', 'totalJumlah'));
    }

    // Penutup Halaman User

    // notifikasi pesanan berhasil
    public function notifikasiBerhasil()
    {
        $cabang_user = session('user')->id_cabang;
        $cabangs = Cabang::where('id_cabang', $cabang_user)->first();

        return view('user.notifikasiPesananBerhasil', compact('cabangs'));
    }
    // \notifikasi pesanan berhasil
}


