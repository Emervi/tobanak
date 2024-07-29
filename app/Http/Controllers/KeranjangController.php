<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Barang;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Session::get('keranjang', []);
        $totalJumlah = array_sum(array_column($keranjang, 'kuantitas'));

        $totalHarga = 0;
        foreach ($keranjang as $item) {
            $totalHarga += $item['barang']->harga * $item['kuantitas'];
        }

        return view('user.keranjang', [
            'keranjang' => $keranjang,
            'totalJumlah' => $totalJumlah,
            'totalHarga' => $totalHarga
        ]);
    }


    public function tambah(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
        ]);

        $barang = Barang::where('id_barang', $request->id_barang)->first();

        if (!$barang) {
            return redirect()->back()->withErrors(['msg' => 'Barang tidak ditemukan.']);
        }

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$barang->id_barang])) {
            $keranjang[$barang->id_barang]['kuantitas'] += 1;
        } else {
            $keranjang[$barang->id_barang] = [
                'barang' => $barang,
                'kuantitas' => 1
            ];
        }

        Session::put('keranjang', $keranjang);
        return redirect()->back()->with('success', 'berhasil menambahkan barang');
    }

    public function hapus(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
        ]);

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$request->id_barang])) {
            unset($keranjang[$request->id_barang]);
        }

        Session::put('keranjang', $keranjang);
        return redirect()->back()->with('success', 'berhasil menghapus barang');
    }
}
