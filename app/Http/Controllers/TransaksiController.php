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
use Illuminate\Support\Facades\Session;


class TransaksiController extends Controller
{
    // Menampilkan halaman checkout
    public function checkout()
    {
        $keranjang = Keranjang::where('id_user', session('user')->id_user)->get();
        $totalHarga = $keranjang->sum(function ($item) {
            return $item->barang->harga * $item->kuantitas;
        });

        return view('user.checkout', compact('keranjang', 'totalHarga'));
    }

    // Proses checkout dan bayar
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'uang_pembayaran' => 'required',
        ]);

        $keranjang = Keranjang::where('id_user', session('user')->id_user)->get();
        $totalHarga = $keranjang->sum(function ($item) {
            return $item->kuantitas * $item->barang->harga;
        });

        $uangPembayaran = $request->input('uang_pembayaran');
        $kembalian = $uangPembayaran - $totalHarga;

        if ($kembalian < 0) {
            return redirect()->back()->with('error', 'Uang pembayaran tidak cukup!');
        }

        $transaksiId = null;

        DB::transaction(function () use ($request, $keranjang, $totalHarga, $uangPembayaran, $kembalian, &$transaksiId) {
            // Membuat transaksi baru
            $transaksi = Transaksi::create([
                'tanggal' => Carbon::now()->toDateString(),
                'id_user' => session('user')->id_user,
                'total_harga' => $totalHarga,
                'uang_pembayaran' => $uangPembayaran,
                'kembalian' => $kembalian,
            ]);

            $transaksiId = $transaksi->id_transaksi;

            // Menambahkan barang_transaksis
            foreach ($keranjang as $item) {
                BarangTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_barang' => $item->id_barang,
                    'kuantitas' => $item->kuantitas,
                    'total_harga_barang' => $item->kuantitas * $item->barang->harga,
                ]);
            }

            // Hapus keranjang setelah checkout
            Keranjang::where('id_user', session('user')->id_user)->delete();
        });

        Session::forget('keranjang');
        Session::forget('totalJumlah');
        session()->put('orderData', [
            'orderId' => $transaksiId, // Nomor order
            'keranjang' => $keranjang, // Daftar barang
            'totalHarga' => $totalHarga, // Total belanja
            'uangPembayaran' => $uangPembayaran, // Uang pembayaran
        ]);

        return redirect()->route('user.pesananBerhasil');
    }




    // Daftar transaksi
    public function daftarTransaksi()
    {
        $perPage = 5;

        $transaksis = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
            ->select('transaksis.*', 'users.name')
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
            ->select('transaksis.*', 'users.name')
            ->where('tanggal', $query)
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

        $totalHarga = Transaksi::where('id_transaksi', $id_transaksi)
            ->select('total_harga')
            ->first()
            ->total_harga;

        return view('admin.detailTransaksi', compact('detailTransaksi', 'totalHarga'));
    }
}
