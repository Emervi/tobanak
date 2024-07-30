<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Barang;
use App\Models\Transaksi;
use Carbon\Carbon;

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

        $latestTransaksi = null;

        foreach ($keranjang as $item) {
            $latestTransaksi = Transaksi::create([
                'tanggal' => Carbon::now()->toDateString(),
                'id_user' => session('user')->id_user,
                'id_barang' => $item->id_barang,
                'kuantitas' => $item->kuantitas,
                'total_harga' => $item->kuantitas * $item->barang->harga,
                'uang_pembayaran' => $uangPembayaran,
                'kembalian' => $kembalian,
            ]);

            // Kurangi stok barang
            $barang = Barang::where('id_barang', $item->id_barang)->first();

            if ($barang) {
                $stok_baru = $barang->stok_barang -= $item->kuantitas;
                Barang::where('id_barang', $item->id_barang)
                    ->update([
                        'stok_barang' => $stok_baru,
                    ]);
            }

            Keranjang::where('id_user', session('user')->id_user)->delete();

            return redirect()->route('user.pesananBerhasil');
        }

        // Hapus keranjang setelah checkout
        Keranjang::where('id_user', session('user')->id_user)->delete();

        return redirect()->route('user.pesananBerhasil');
    }


    // Daftar transaksi
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

    // Cari transaksi
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

    // Hapus transaksi
    public function destroyTransaksi($id_transaksi)
    {
        Transaksi::where('id_transaksi', $id_transaksi)
            ->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
