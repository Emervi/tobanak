<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Barang;
use App\Models\BarangTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;


class TransaksiController extends Controller
{
    // Menampilkan halaman checkout
    public function checkout()
    {
        $keranjang = Keranjang::where('id_user', session('kasir')->id_user)->get();
        $totalHarga = $keranjang->sum(function ($item) {
            return $item->barang->harga * $item->kuantitas;
        });

        return view('kasir.checkout', compact('keranjang', 'totalHarga'));
    }

    // Proses checkout dan bayar
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'uang_pembayaran' => 'required',
        ]);

        $keranjang = Keranjang::where('id_user', session('kasir')->id_user)->get();
        $totalHarga = $keranjang->sum(function ($item) {
            return $item->kuantitas * $item->barang->harga;
        });

        $uangPembayaran = $request->input('uang_pembayaran');
        $kembalian = $uangPembayaran - $totalHarga;

        if ($kembalian < 0) {
            return redirect()->back()->with('error', 'Uang pembayaran tidak cukup!');
        }

        $transaksiId = null;
        $status = 'Selesai';

        DB::transaction(function () use ($request, $keranjang, $totalHarga, $uangPembayaran, $kembalian, &$transaksiId, $status) {
            // Membuat transaksi baru
            $transaksi = Transaksi::create([
                'tanggal' => Carbon::now()->toDateString(),
                'id_user' => session('kasir')->id_user,
                'total_harga' => $totalHarga,
                'uang_pembayaran' => $uangPembayaran,
                'kembalian' => $kembalian,
                'id_cabang' => session('kasir')->id_cabang,
                'status' => 'Selesai',
                'metode_pembayaran' => 'Cash',
                'id_ekspedisi' => null,
                'alamat' => null,
            ]);

            $transaksiId = $transaksi->id_transaksi;

            // Menambahkan barang_transaksis
            foreach ($keranjang as $item) {
                BarangTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_barang' => $item->id_barang,
                    'kuantitas' => $item->kuantitas,
                    'status_barang' => 'Diterima',
                    'total_harga_barang' => $item->kuantitas * $item->barang->harga,
                ]);
            }

            // Hapus keranjang setelah checkout
            Keranjang::where('id_user', session('kasir')->id_user)->delete();
        });

        Session::forget('keranjang');
        Session::forget('totalJumlah');
        session()->put('orderData', [
            'orderId' => $transaksiId, // Nomor order
            'keranjang' => $keranjang, // Daftar barang
            'totalHarga' => $totalHarga, // Total belanja
            'uangPembayaran' => $uangPembayaran, // Uang pembayaran
        ]);

        return redirect()->route('kasir.pesananBerhasil');
    }




    // Daftar transaksi
    public function daftarTransaksi()
    {
        $perPage = 5;

        $transaksis = Transaksi::leftJoin('users', 'transaksis.id_user', '=', 'users.id_user')
            ->leftJoin('cabangs', 'transaksis.id_cabang', '=', 'cabangs.id_cabang')
            ->select('transaksis.*', 'users.username', 'cabangs.nama_cabang')
            ->latest()
            ->paginate($perPage);

        $currentPage = $transaksis->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarTransaksi', compact('transaksis', 'offset'));
    }

    // Cari transaksi
    public function cariTransaksi(Request $request)
    {
        $query = $request->keyword_transaksi;
        $transaksis = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
            ->join('cabangs', 'transaksis.id_cabang', '=', 'cabangs.id_cabang')
            ->select('transaksis.*', 'users.username', 'cabangs.nama_cabang')
            ->where('tanggal', $query)
            ->latest()
            ->get();

        $offset = -1;

        return view('admin.daftarTransaksi', compact('transaksis', 'offset'));
    }

    // Hapus transaksi
    public function destroyTransaksi($id_transaksi)
    {
        Transaksi::where('id_transaksi', $id_transaksi)
            ->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }

    // detail transaksi
    public function detailTransaksi($id_transaksi)
    {
        $detailTransaksi = BarangTransaksi::join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->join('transaksis', 'barang_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->select('barang_transaksis.*', 'barangs.nama_barang')
            ->where('barang_transaksis.id_transaksi', $id_transaksi)
            ->get();


        $detailTambahan = Transaksi::where('id_transaksi', $id_transaksi)
        ->join('cabangs', 'transaksis.id_cabang', '=', 'cabangs.id_cabang')
        ->select('transaksis.*', 'cabangs.nama_cabang')
        ->first();

        if( !empty($detailTambahan->id_ekspedisi) ){
            $detailTambahan = Transaksi::where('id_transaksi', $id_transaksi)
            ->join('ekspedisis', 'transaksis.id_ekspedisi', '=', 'ekspedisis.id_ekspedisi')
            ->select('transaksis.*', 'ekspedisis.*')
            ->first();
        }

        return view('admin.detailTransaksi', compact('detailTransaksi', 'detailTambahan'));
    }

    public function storeCustomer(Request $request)
{
    $keranjangs = Keranjang::where('id_user', session('customer')->id_user)->get();
    $totalHargaBarang = $keranjangs->sum(function ($item) {
        return $item->kuantitas * $item->barang->harga;
    });

    // Validasi data request
    $request->validate([
        'alamat' => 'required',
        'id_ekspedisi' => 'required',
        'harga_ekspedisi' => 'required',
        'metode_pembayaran' => 'required',
        'barangs' => 'required|array',
        'kuantitas' => 'required|array',
    ]);

    $totalHarga = $totalHargaBarang + $request->harga_ekspedisi;
    $uangPembayaran = ($request->metode_pembayaran == 'cod') ? 0 : $totalHarga;

    // Membuat transaksi baru
    $transaksi = Transaksi::create([
        'tanggal' => Carbon::now(),
        'id_user' => session('customer')->id_user,
        'id_cabang' => null,
        'total_harga' => $totalHarga,
        'kembalian' => 0,
        'alamat' => $request->alamat,
        'metode_pembayaran' => $request->metode_pembayaran,
        'id_ekspedisi' => $request->id_ekspedisi,
        'status' => 'Diproses',
        'uang_pembayaran' => $uangPembayaran,
    ]);

    // Menambahkan item ke transaksi
    foreach ($keranjangs as $keranjang) {
        BarangTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_barang' => $keranjang->id_barang,
            'kuantitas' => $keranjang->kuantitas,
            'status_barang' => 'Diproses',
            'total_harga_barang' => $keranjang->kuantitas * $keranjang->barang->harga,
        ]);

        // Update stok barang
        $barang = $keranjang->barang;
        if ($barang) {
            $barang->stok_barang -= $keranjang->kuantitas;
            $barang->save();
        }
    }

    // Mengosongkan keranjang
    Keranjang::where('id_user', session('customer')->id_user)->delete();

    // Redirect ke halaman pesanan customer
    return redirect()->route('customer.pesanan');
}