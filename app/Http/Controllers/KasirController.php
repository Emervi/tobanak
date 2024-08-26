<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangTransaksi;
use App\Models\Cabang;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Carbon\Carbon;
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

    // Penutup Halaman Kasir

    // notifikasi pesanan berhasil
    public function notifikasiBerhasil()
    {
        $cabang_kasir = session('kasir')->id_cabang;
        $cabangs = Cabang::where('id_cabang', $cabang_kasir)->first();

        return view('kasir.notifikasiPesananBerhasil', compact('cabangs'));
    }
    // \notifikasi pesanan berhasil

    // halaman pesanan
    public function daftarPesanan()
    {

        $pesanans = Transaksi::leftJoin('barang_transaksis', 'barang_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->leftJoin('users', 'transaksis.id_user', '=', 'users.id_user')
            ->where('transaksis.status', 'Diproses')
            ->select('transaksis.*', 'users.*')
            ->distinct()
            ->get();

        if( !empty($pesanans[0]) ){

            foreach ($pesanans as $pesanan) {
                $jumlahBarang[] = BarangTransaksi::where('id_transaksi', $pesanan->id_transaksi)
                    ->count();
            }

            foreach ($pesanans as $pesanan) {
                $tanggal[] = Carbon::parse($pesanan->tanggal)->format('m-d-Y');
            }

        }else{
            $jumlahBarang = 0;
            $tanggal = 0;
        }
        
        return view('kasir.daftarPesanan', compact('pesanans', 'jumlahBarang', 'tanggal'));
    }

    // detail pesanan
    public function detailPesanan($id_pesanan)
    {
        // $id_pesanan = id_transaksi
        Carbon::setLocale('id');

        $detailPesanan = BarangTransaksi::join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->join('transaksis', 'barang_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->select('barang_transaksis.*', 'barangs.*', 'transaksis.*')
            ->where('barang_transaksis.id_transaksi', $id_pesanan)
            ->get();

        $dataTambahan = Transaksi::join('users', 'transaksis.id_user', '=', 'transaksis.id_user')
            ->select('transaksis.*', 'users.username')
            ->where('transaksis.id_transaksi', $id_pesanan)
            ->first();

        $batasKirim = Carbon::parse($detailPesanan[0]->tanggal)->addDays(2)->translatedFormat('d F');

        // harga asli
        foreach ($detailPesanan as $index => $detail) {

            $potongan[] = $detail->potongan;
            $diskon[] = 1 - ($detail->diskon / 100);
            $harga[] = $detail->harga;

            $hargaTambahPotongan[] = $harga[$index] + $potongan[$index];

            $hargaAwalFinal[] = $hargaTambahPotongan[$index] / $diskon[$index];
        }

        return view('kasir.detailPesanan', compact('detailPesanan', 'batasKirim', 'dataTambahan', 'hargaAwalFinal'));
    }

    public function kirimBarang($id_pesanan)
    {

        Transaksi::where('id_transaksi', $id_pesanan)
            ->update([
                'status' => 'Dikirim',
            ]);

        BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->update([
                'status_barang' => 'Dikirim',
            ]);

        return redirect()->back()->with('success', 'Barang berhasil dikirim!');
    }

    public function batalBarang($id_pesanan)
    {

        Transaksi::where('id_transaksi', $id_pesanan)
            ->update([
                'status' => 'Dibatalkan',
            ]);

        BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->update([
                'status_barang' => 'Dibatalkan',
            ]);

        return redirect()->back()->with('success', 'Barang berhasil dibatalkan!');
    }
}
