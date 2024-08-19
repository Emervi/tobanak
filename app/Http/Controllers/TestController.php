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
    
}
