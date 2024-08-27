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

        DB::transaction(function () use ($request, $keranjang, $totalHarga, $uangPembayaran, $kembalian, &$transaksiId) {
            // Membuat transaksi baru
            $transaksi = Transaksi::create([
                'tanggal' => Carbon::now()->toDateString(),
                'id_user' => session('kasir')->id_user,
                'total_harga' => $totalHarga,
                'uang_pembayaran' => $uangPembayaran,
                'kembalian' => $kembalian,
                'id_cabang' => session('kasir')->id_cabang,
                'alamat' => session('kasir')->alamat,
                'metode_pembayaran' => 'Cash',
                'id_ekspedisi' => 1,
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
        $columns = Schema::getColumnListing('transaksis');

        $length = count($columns);
        foreach ($columns as $index => $col) {

            
            if ($index == 0) continue;
            $columnTransaksis[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 7) break;

        }

        $columnTransaksis['id_user'] = 'Username';
        $columnTransaksis['id_cabang'] = 'Cabang';

        // dd($columnTransaksis, $length - 3);

        $perPage = 5;

        $transaksis = Transaksi::join('users', 'transaksis.id_user', '=', 'users.id_user')
        ->join('cabangs', 'transaksis.id_cabang', '=', 'cabangs.id_cabang')
        ->select('transaksis.*', 'users.username', 'cabangs.nama_cabang')
        ->latest()
        ->paginate($perPage);

        $currentPage = $transaksis->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarTransaksi', compact('transaksis', 'offset', 'columnTransaksis'));
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
        $columns = Schema::getColumnListing('barang_transaksis');

        $length = count($columns);
        foreach ($columns as $index => $col) {

            
            if ($index == 0) continue;
            $columnBarangTransaksis[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 3) break;

        }
        $columnBarangTransaksis['id_barang'] = 'Nama Barang';
        
        $detailTransaksi = BarangTransaksi::join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->join('transaksis', 'barang_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->select('barang_transaksis.*', 'barangs.nama_barang')
            ->where('barang_transaksis.id_transaksi', $id_transaksi)
            ->get();

        $totalHarga = Transaksi::where('id_transaksi', $id_transaksi)
            ->select('total_harga')
            ->first()
            ->total_harga;

        return view('admin.detailTransaksi', compact('detailTransaksi', 'totalHarga', 'columnBarangTransaksis'));
    }

    public function storeCustomer(Request $request)
    {

        $keranjangs = Keranjang::where('id_user', session('customer')->id_user)->get();
        $totalHargaBarang = $keranjangs->sum(function ($item) {
            return $item->kuantitas * $item->barang->harga;
        });

        // Validate the request data
        $request->validate([
            'alamat' => 'required',
            'id_ekspedisi' => 'required',
            'harga_ekspedisi' => 'required',
            'metode_pembayaran' => 'required',
            'barangs' => 'required|array',
            'kuantitas' => 'required|array',
        ]);

        // Create a new transaction
        $transaksi = new Transaksi();
        $transaksi->tanggal = Carbon::now();
        $transaksi->id_user = session('customer')->id_user;
        $transaksi->id_cabang = null; 
        $transaksi->total_harga += $request->harga_ekspedisi; 
        $transaksi->kembalian = 0;
        $transaksi->alamat = $request->alamat;
        $transaksi->metode_pembayaran = $request->metode_pembayaran;
        $transaksi->id_ekspedisi = $request->id_ekspedisi;
        $transaksi->status = 'Diproses';

        

        

    // Add items to the transaction
    foreach ($request->barangs as $index => $barangId) {
        $barang = Barang::find($barangId);
        $kuantitas = $request->kuantitas[$index];

        // Update the total price of the transaction
        $transaksi->total_harga += $barang->harga * $kuantitas;
    }
        if ($request->metode_pembayaran == 'cod') {
            $transaksi->uang_pembayaran = 0;
        } else {
            $transaksi->uang_pembayaran = $transaksi->total_harga;
        }

        $transaksi->save();

        foreach($keranjangs as $keranjang) {
                BarangTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_barang' => $keranjang->id_barang,
                'kuantitas' => $keranjang->kuantitas,
                'status_barang' => 'Diproses',
                'total_harga_barang' => $keranjang->kuantitas * $keranjang->barang->harga,
            ]);
        }

        

        // Clear the cart
        Keranjang::where('id_user', session('customer')->id_user)->delete();

        if($transaksi){
            $barang = Barang::where('id_barang', $request->id_barang)->first();
            if($barang){
                $barang->stok_barang -= intval($request->kuantitas);
                $barang->save();
            }
        }

        // Redirect to the transaction success page
        return redirect()->route('customer.pesanan');
    }

}
