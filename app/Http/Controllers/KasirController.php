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
        $id_cabang = session('kasir')->id_cabang;

        if (session()->has('batasKirim')) {
            $stringWaktu = session('batasKirim')['waktu'];
            $batasKirim = Carbon::createFromFormat('H:i:s', $stringWaktu);
            $jamSekarang = Carbon::now();

            if ($jamSekarang->greaterThan($batasKirim)) {
                $id_transaksi = session('batasKirim')['id_transaksi'];
                $this->kirimBarang($id_transaksi);
            }
        }

        $pesanans = Transaksi::leftJoin('barang_transaksis', 'barang_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->leftJoin('users', 'transaksis.id_user', '=', 'users.id_user')
            ->leftJoin('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->where('barangs.id_cabang', $id_cabang)
            ->where('transaksis.status', 'Diproses')
            ->where('barang_transaksis.status_barang', 'Diproses')
            ->select('transaksis.*', 'users.username')
            ->distinct()
            ->get();

        if (!empty($pesanans[0])) {

            // mengambil jumlah barang yang ada di dalam pesanan pelanggan
            foreach ($pesanans as $pesanan) {
                $jumlahBarang[] = BarangTransaksi::join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
                    ->where('id_transaksi', $pesanan->id_transaksi)
                    ->where('id_cabang', $id_cabang)
                    ->where('status_barang', 'Diproses')
                    ->count();
            }

            // mengambil tanggal dibuatnya pesanan
            foreach ($pesanans as $pesanan) {
                $tanggal[] = $pesanan->created_at->toDateTimeString();
            }
        } else {
            // jika tidak ada maka semua akan menjadi 0
            $jumlahBarang = 0;
            $tanggal = 0;
        }

        return view('kasir.daftarPesanan', compact('pesanans', 'jumlahBarang', 'tanggal'));
    }

    // detail pesanan
    public function detailPesanan($id_pesanan)
    {
        // $id_pesanan = id_transaksi. $id_pesanan isinya adalah id_transaksi

        // mengambil cabang dari session kasir
        $id_cabang = session('kasir')->id_cabang;

        // mengubah carbon menjadi bahasa indonesia
        Carbon::setLocale('id');

        // mengambil detail pesanan dengan ketentuan id_cabang
        $detailPesanan = BarangTransaksi::join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->join('transaksis', 'barang_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->select('barang_transaksis.*', 'barangs.*', 'transaksis.*')
            ->where('barang_transaksis.id_transaksi', $id_pesanan)
            ->where('barangs.id_cabang', $id_cabang)
            ->get();

        // mengambil informasi tambahan, seperti username, metode pembayaran, dan alamat
        $dataTambahan = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
            ->join('ekspedisis', 'transaksis.id_ekspedisi', '=', 'ekspedisis.id_ekspedisi')
            ->where('transaksis.id_transaksi', $id_pesanan)
            ->select('transaksis.*', 'users.username', 'ekspedisis.estimasi_pengiriman')
            ->first();

        // mengecek batas konfirmasi
        if ($dataTambahan->estimasi_pengiriman > 1) {

            // jika estimasi_pengiriman lebih dari 1 hari maka barang harus sudah dikemas 1 hari setelah barang dipesan
            $batasKirim = 'Konfirmasi sebelum tanggal : ' . Carbon::parse($detailPesanan[0]->tanggal)->addDays(1)->translatedFormat('d F');
        } else {

            $batasJam = $dataTambahan->created_at->addHours(4)->toTimeString();
            // jika estimasi_pengiriman 1 hari maka barang harus segera dikemas 3 jam setelah barang dipesan
            $batasKirim = 'Segera konfirmasi sebelum jam : ' . $batasJam;
            session()->put('batasKirim', [
                'waktu' => $batasJam,
                'id_transaksi' => $id_pesanan,
            ]);
        }


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
        // mengambil cabang dari session kasir
        $id_cabang = session('kasir')->id_cabang;

        // mengubah status_barang menjadi dikirim dengan ketentuan id_cabang
        BarangTransaksi::join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->where('barang_transaksis.id_transaksi', $id_pesanan)
            ->where('barangs.id_cabang', $id_cabang)
            ->update([
                'status_barang' => 'Dikirim',
            ]);

        // mengambil total barang yang dipesan
        $totalBarangPesanan = BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->count();

        // mengambil total barang yang status_barang nya dikirim
        $totalBarangDikirim = BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->where('status_barang', 'Dikirim')
            ->count();

        $totalBarangDibatalkan = BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->where('status_barang', 'Dibatalkan')
            ->count();

        // mengecek apakah total barang yang dipesan sama dengan total barang dengan status_barang dikirim
        if ($totalBarangDikirim > 0) {
            if ($totalBarangDikirim + $totalBarangDibatalkan === $totalBarangPesanan) {

                // jika kedua total sudah sama maka ubah status transaksi menjadi dikirim
                Transaksi::where('id_transaksi', $id_pesanan)
                    ->update([
                        'status' => 'Dikirim',
                    ]);
            }
        }

        // kembali ke halaman dengan pesan success
        return redirect()->back()->with('success', 'Barang berhasil dikirim!');
    }

    public function batalBarang($id_pesanan)
    {
        // mengambil cabang dari session kasir
        $id_cabang = session('kasir')->id_cabang;

        // mengubah status_barang menjadi dibatalkan dengan ketentuan id_cabang
        BarangTransaksi::join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->where('barang_transaksis.id_transaksi', $id_pesanan)
            ->where('barangs.id_cabang', $id_cabang)
            ->update([
                'status_barang' => 'Dibatalkan',
            ]);

        // mengambil total barang yang dipesan
        $totalBarangPesanan = BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->count();

        // mengambil total barang yang status_barang nya dikirim
        $totalBarangDikirim = BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->where('status_barang', 'Dikirim')
            ->count();

        $totalBarangDibatalkan = BarangTransaksi::where('id_transaksi', $id_pesanan)
            ->where('status_barang', 'Dibatalkan')
            ->count();

        if ($totalBarangDikirim > 0) {
            if ($totalBarangDikirim + $totalBarangDibatalkan === $totalBarangPesanan) {

                // jika kedua total sudah sama maka ubah status transaksi menjadi dikirim
                Transaksi::where('id_transaksi', $id_pesanan)
                    ->update([
                        'status' => 'Dikirim',
                    ]);
            }
        }elseif($totalBarangDibatalkan === $totalBarangPesanan){

            Transaksi::where('id_transaksi', $id_pesanan)
                    ->update([
                        'status' => 'Dibatalkan',
                    ]);

        }

        return redirect()->back()->with('success', 'Barang berhasil dibatalkan!');
    }
}
