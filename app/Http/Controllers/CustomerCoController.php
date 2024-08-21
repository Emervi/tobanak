<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ekspedisis;
use App\Models\Keranjang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CustomerCoController extends Controller
{
    public function index() {

        // $keranjang = Keranjang::with('barang')->where('id_customer', session('user')->id_user);

        $ekspedisis = Ekspedisis::all();
        $selectedEkspedisiId = session('selected_ekspedisi');

        Carbon::setLocale('id');

        foreach( $ekspedisis as $ekspedisi ){

            if( $ekspedisi->estimasi_pengiriman > 1 ){
                $tanggalEstimasi[] = Carbon::now()->translatedFormat('d') . ' - ' . Carbon::now()->addDays($ekspedisi->estimasi_pengiriman - 1)->translatedFormat('d F');
            }else{
                $tanggalEstimasi[] = Carbon::now()->translatedFormat('d F');
            }
            
        }

        return view('customer.checkout', compact('ekspedisis', 'selectedEkspedisiId', 'tanggalEstimasi'));
    }


    public function updateEkspedisi(Request $request) {
        $request->validate([
            'id_ekspedisi' => 'required|exists:ekspedisis,id_ekspedisi',
        ]);

        session(['selected_ekspedisi' => $request->id_ekspedisi]);

        return redirect()->route('customer.checkout');

    }
}
