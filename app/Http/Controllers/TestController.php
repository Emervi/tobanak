<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Cabang;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(){

        $barangs = Barang::all();

        $cabangs = Cabang::all();

        return view('test', compact('barangs', 'cabangs'));
    }

    public function index2() {

        return view('test2');

    }

    public function put(Request $request){

        $distribusi = $request->input('distribusi', []);
        $id_barangs = $request->input('id_barangs', []);


        foreach ( $id_barangs as $id_barang ) {

            $barang =  Barang::where('id_barang', $id_barang)
            ->first();

            $statDis = isset($distribusi[$id_barang]) ? $request->status : $barang->distribusi;

            if ( isset($distribusi[$id_barang]) && isset($request->id_cabang) ) {
                $id_cabang = $request->id_cabang;
            }else{
                $id_cabang = $barang->id_cabang;
            }

            Barang::where('id_barang', $id_barang)
            ->update([
            'id_cabang' =>  $id_cabang,
            'distribusi' => $statDis,
            ]);
            
        }

        return redirect()->back()->with('success', 'Berhasil!');

    }

    // Validasi dan proses tanggal
    public function validateDates(Request $request)
    {
        // Validasi input
        $request->validate([
            'date_a' => 'required|date',
            'date_b' => 'required|date',
        ], [
            'date_a.required' => 'Tanggal A harus diisi.',
            'date_b.required' => 'Tanggal B harus diisi.',
        ]);

        // Ambil nilai input
        $dateA = $request->input('date_a');
        $dateB = $request->input('date_b');

        // Cek apakah Tanggal A lebih besar dari Tanggal B
        if (strtotime($dateA) > strtotime($dateB)) {
            return back()->withErrors(['error' => 'Tanggal A tidak boleh lebih besar dari Tanggal B.']);
        }

        // Jika validasi berhasil, buka halaman baru dengan data input
        return view('test2', ['dateA' => $dateA, 'dateB' => $dateB]);
    }
    
}
