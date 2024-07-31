<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Barang;

class KeranjangController extends Controller
{
    // Menampilkan keranjang pengguna
    public function index()
    {
        $userId = session('user')->id_user;
        $keranjang = Keranjang::where('id_user', $userId)->with('barang')->get();

        // Hitung total harga
        $totalHarga = $keranjang->sum(function ($item) {
            return $item->barang->harga * $item->kuantitas;
        });

        return view('user.keranjang', compact('keranjang', 'totalHarga'));
    }

    // Menambahkan barang ke keranjang
    public function tambah(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
        ]);

        // Mendapatkan ID pengguna yang sedang login
        $idUser = session('user')->id_user;
        $idBarang = $request->input('id_barang');

        // Cek apakah barang ada dan cukup stoknya
        $barang = Barang::where('id_barang', $idBarang)->firstOrFail();

        // Cek apakah barang sudah ada di keranjang
        $keranjang = Keranjang::where('id_user', $idUser)
            ->where('id_barang', $idBarang)
            ->first();

        if ($keranjang) {
            // Jika barang sudah ada, tambahkan kuantitasnya
            $keranjang->kuantitas += 1;
            $keranjang->save();
        } else {
            // Jika barang belum ada, tambahkan ke keranjang
            Keranjang::create([
                'id_user' => $idUser,
                'id_barang' => $idBarang,
                'kuantitas' => 1,
            ]);
        }

        $totalJumlah = Keranjang::where('id_user', $idUser)->sum('kuantitas');
        session(['totalJumlah' => $totalJumlah]);

        return redirect()->back()->with('success', 'Barang telah ditambahkan ke keranjang!');
    }

    // Menghapus barang dari keranjang
    public function hapus(Request $request)
    {
        $request->validate([
            'id_keranjang' => 'required|exists:keranjangs,id_keranjang',
        ]);

        $idKeranjang = $request->input('id_keranjang');
        Keranjang::where('id_keranjang', $idKeranjang)->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus dari keranjang!');
    }

    // Mengupdate kuantitas barang di keranjang
    public function update(Request $request)
    {
        $userId = session('user')->id_user;

        foreach ($request->input('kuantitas') as $idKeranjang => $kuantitas) {
            $keranjang = Keranjang::where('id_user', $userId)->where('id_keranjang', $idKeranjang)->first();
            if ($keranjang) {
                // Pastikan kuantitas tidak kurang dari 1
                $keranjang->kuantitas = max(1, $kuantitas);
                $keranjang->save();
            }
        }

        return redirect()->back()->with('success', 'Keranjang telah diperbarui!');
    }
}
