<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $barangs = Barang::where('id_cabang', $user->id_cabang)
        ->where('distribusi', 'Dikirim')
        ->get();

        return view('kasir.distribusi', compact('barangs'));
    }

    public function updateStatus(Request $request, $id_barang) {
        $request->validate([
            'status'=> 'required|string|in:Diterima,Ditolak',
        ]);  

        Barang::where('id_barang', $id_barang)->update([
            'distribusi' => $request->input('status'),
        ]);

        if($request->input('status') == 'Diterima') {
            return redirect()->route('distribusi')->with('success', 'Barang berhasil ditambahkan, semoga ga kayak nambahin perasaan ke orang yang salah');
        }

        return redirect()->route('distribusi')->with('tolak', 'Barang ditolak, kayak cinta kamu yang nggak pernah diterima.');

    }
}

