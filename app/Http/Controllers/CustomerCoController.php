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
    
        $ekspedisis = Ekspedisis::all();
        
        $selectedEkspedisiId = session('selected_ekspedisi');
        
        $idCustomer = session('customer')->id_user;
        
        $keranjangs = Keranjang::with('barang')
                        ->where('id_user', $idCustomer)
                        ->get();
        
        $totalHarga = $keranjangs->sum(function($keranjang){
            return $keranjang->barang->harga * $keranjang->kuantitas;
        });
    
        // Kirim data ke view
        return view('customer.checkout', compact('ekspedisis', 'selectedEkspedisiId', 'keranjangs', 'totalHarga'));
    }
    


    public function updateEkspedisi(Request $request) {
        $request->validate([
            'id_ekspedisi' => 'required|exists:ekspedisis,id_ekspedisi',
        ]);

        session(['selected_ekspedisi' => $request->id_ekspedisi]);

        return redirect()->route('customer.checkout');

    }

    public function updateAlamat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        session()->put('alamat_baru', [
            'name' => $request->input('name'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
        ]);

        return back()->with('success', 'alamat baru telah di tambahkan');
    }

    public function resetAlamat()
    {
        session()->forget('alamat_baru');
        return back()->with('success', 'mengganti menjadi alamat asli');
    }

}
