<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating; // Pastikan ada model Rating atau sesuaikan dengan model yang Anda gunakan
use App\Models\Barang; // Pastikan ada model Barang untuk mengaitkan rating dengan barang
use App\Models\BarangTransaksi;

class RatingController extends Controller
{
    /**
     * Menyimpan rating dan review ke dalam database.
     */
    public function submitRating(Request $request)
    {   
        // dd($request->all());

        $barang = BarangTransaksi::where('id_transaksi', $request->id_transaksi)
                    ->where('id_barang', $request->id_barang)
                    ->get();

        // dd($barang);

        // Validasi input
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang', // Pastikan barang dengan ID tersebut ada
            'id_transaksi' => 'required|exists:transaksis,id_transaksi', // Pastikan barang dengan ID tersebut ada
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:255',
        ]);

        // dd($request->all());
        // Simpan rating dan review ke database
        $rating = Rating::create([
            'id_barang' => $request->id_barang,
            'id_user' => session('customer')->id_user,
            'id_transaksi' => $request->id_transaksi,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        if ($rating) {
            // Hitung rata-rata rating untuk barang
            $averageRating = Rating::where('id_barang', $request->id_barang)
                                    ->avg('rating');


            // Update kolom rating_barang di tabel barang
            Barang::where('id_barang', $request->id_barang)
                  ->update(['rating_barang' => $averageRating]);
        }

        // Redirect atau kirim respons sukses
        return redirect()->back()->with('success', 'Rating dan review berhasil disimpan.');
    }
}
