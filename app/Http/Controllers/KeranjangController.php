<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    // Menampilkan keranjang pengguna
    public function index()
    {
        $id_kasir = session('kasir')->id_user;
        $keranjang = Keranjang::where('id_user', $id_kasir)->with('barang')->get();

        // Hitung total harga
        $totalHarga = $keranjang->sum(function ($item) {
            return $item->barang->harga * $item->kuantitas;
        });

        return view('kasir.keranjang', compact('keranjang', 'totalHarga'));
    }

    // Menambahkan barang ke keranjang
    public function tambah(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
        ]);

        // Mendapatkan ID pengguna yang sedang login
        $id_kasir = session('kasir')->id_user;
        $id_barang = $request->input('id_barang');

        Barang::where('id_barang', $id_barang)
            ->decrement('stok_barang', 1);

        // Cek apakah barang sudah ada di keranjang
        $keranjang = Keranjang::where('id_user', $id_kasir)
            ->where('id_barang', $id_barang)
            ->first();

        if ($keranjang) {
            // Jika barang sudah ada, tambahkan kuantitasnya
            $keranjang->kuantitas += 1;
            $keranjang->save();
        } else {
            // Jika barang belum ada, tambahkan ke keranjang
            Keranjang::create([
                'id_user' => $id_kasir,
                'id_barang' => $id_barang,
                'kuantitas' => 1,
            ]);
        }

        $totalJumlah = Keranjang::where('id_user', $id_kasir)->sum('kuantitas');
        session(['totalJumlah' => $totalJumlah]);

        return response()->json([
            'success' => true,
            'stok_barang' => Barang::where('id_barang', $id_barang)->value('stok_barang'),
            'totalJumlah' => $totalJumlah,
        ]);
    }

    // Menghapus barang dari keranjang
    public function hapus(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_keranjang' => 'required|exists:keranjangs,id_keranjang',
        ]);

        $id_barang = $request->input('id_barang');
        $kuantitas = $request->input('kuantitas');
        $idKeranjang = $request->input('id_keranjang');
        Keranjang::where('id_keranjang', $idKeranjang)->delete();
        Barang::where('id_barang', $id_barang)
        ->increment('stok_barang', $kuantitas);

        return redirect()->back()->with('success', 'Barang berhasil dihapus dari keranjang!');
    }

    // Mengupdate kuantitas barang di keranjang
    public function kurangi(Request $request)
    {
        $id_barang = $request->input('id_barang');
        $id_keranjang = $request->input('id_keranjang');
        $keranjang = Keranjang::findOrFail($id_keranjang);

        if ($keranjang->kuantitas > 1) {
            $keranjang->kuantitas -= 1;
            $keranjang->save();
            Barang::where('id_barang', $id_barang)
            ->increment('stok_barang', 1);

            $totalJumlah = Session::get('totalJumlah', 0);
            $totalJumlah--;
            Session::put('totalJumlah', $totalJumlah);
        } else {
            $keranjang->delete();
        }

        return redirect()->back()->with('success', 'kuantitas telah dikurangi, seperti perhatian dia');
    }
}
