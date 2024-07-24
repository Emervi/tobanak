<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // Halaman User

    public function homeUser(Request $request)
    {
        $barangs = Barang::all();

        $filter = $request->query('filter');
        $kategori = Barang::select('kategori_barang')->distinct()->pluck('kategori_barang');

        if ($filter) {
            $barangs = Barang::where('kategori_barang', $filter)->get();
        } else {
            $barangs = Barang::all();
        }

        return view('user.home', compact('barangs', 'kategori'));
    }



    public function keranjang()
    {
        return view('user.keranjang');
    }
    // Penutup Halaman User

}
