<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // halaman barang
    public function daftarBarang()
    {
        $barangs = Barang::latest()->get();

        return view('admin.daftarBarang', compact('barangs'));
    }

    // cari barang
    public function cariBarang(Request $request)
    {
        $query = $request->keyword_barang;
        $barangs = Barang::where('nama_barang', 'LIKE', "%$query%")
        ->get();

        return view('admin.daftarBarang', compact('barangs'));
    }

    // halaman tambah barang
    public function tambahBarang()
    {
        return view('admin.tambahBarang');
    }

    // store barang
    public function storeBarang(BarangRequest $request)
    {
        // Barang::create($request->all());

        if ($request->has('foto_barang')){
            $imageName = time().'.'.$request->foto_barang->extension();  
            $request->foto_barang->move(public_path('images'), $imageName);
        }else{
            $imageName = 'noPhoto.jpg';
        }
        
        Barang::create([
            'foto_barang' => $imageName,
            'nama_barang' => $request->nama_barang,
            'kategori_barang' => $request->kategori_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'stok_barang' => $request->stok_barang,
            'bahan' => $request->bahan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.daftarBarang')->with('success', 'Barang berhasil ditambahkan!');
    }

    // edit barang
    public function editBarang($id_barang)
    {
        $barang = Barang::where('id_barang', $id_barang)
        ->get();

        return view('admin.tambahBarang', compact('barang'));
    }

    // update barang
    public function updateBarang(Request $request, $id_barang)
    {
        $request->validate([
            'nama_barang' => ['required', 'string'],
            'kategori_barang' => ['required'],
            'deskripsi_barang' => ['required'],
            'stok_barang' => ['required', 'integer'],
            'bahan' => ['required'],
            'harga' => ['required', 'numeric'],
            'foto_barang' => ['image', 'mimes:jpeg,png,jpg'],
        ]);
        
        if ($request->has('foto_barang')){
        $imageName = time().'.'.$request->foto_barang->extension();  
        $request->foto_barang->move(public_path('images'), $imageName);
        }else{
            $imageName = Barang::where('id_barang', $id_barang)
            ->pluck('foto_barang')
            ->first();
        }

        Barang::where('id_barang', $id_barang)
        ->update([
            'foto_barang' => $imageName,
            'nama_barang' => $request->nama_barang,
            'kategori_barang' => $request->kategori_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'stok_barang' => $request->stok_barang,
            'bahan' => $request->bahan,
            'harga' => $request->harga,
        ]);

        return redirect()->route(('admin.daftarBarang'))->with('success', 'Barang berhasil diupdate!');
    }

    // destroy barang
    public function destroyBarang($id_barang)
    {
        Barang::where('id_barang', $id_barang)
        ->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

}
