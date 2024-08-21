<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ekspedisis;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CustomerCoController extends Controller
{
    public function index() {

        // $keranjang = Keranjang::with('barang')->where('id_customer', session('user')->id_user);

        $ekspedisis = Ekspedisis::all();
        $selectedEkspedisiId = session('selected_ekspedisi');

        // $totalHarga = $keranjang->sum(function($item){
        //     return $item->barang->harga * $item->kuantitas;
        // });

        // return view('customer.checkout', compact('keranjang', 'ekspedisis', 'totalHarga'));

        return view('customer.checkout', compact('ekspedisis', 'selectedEkspedisiId'));
    }


    public function updateEkspedisi(Request $request) {
        $request->validate([
            'id_ekspedisi' => 'required|exists:ekspedisis,id_ekspedisi',
        ]);

        session(['selected_ekspedisi' => $request->id_ekspedisi]);

        return redirect()->route('customer.checkout');

    }
}
