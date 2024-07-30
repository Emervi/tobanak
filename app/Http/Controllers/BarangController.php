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
        $perPage = 5;

        $barangs = Barang::latest()->paginate($perPage);

        $currentPage = $barangs->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarBarang', compact('barangs', 'offset'));
    }

    // cari barang
    public function cariBarang(Request $request)
    {
        $perPage = 5;

        $query = $request->keyword_barang;
        $barangs = Barang::where('nama_barang', 'LIKE', "%$query%")
        ->paginate($perPage);

        $currentPage = $barangs->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarBarang', compact('barangs', 'offset'));
    }

    // halaman tambah barang
    public function tambahBarang()
    {
        return view('admin.tambahBarang');
    }

    // store barang
    public function storeBarang(BarangRequest $request)
    {

        // Harga modal dengan patokan bahan
        $bahan = $request->bahan;
        if ( $bahan == 'tebal' ) {
            $modal = 20000 * 10;
        }else if ( $bahan == 'street' ) {
            $modal = 19000 * 10;
        }else if ( $bahan == 'sedang' ) {
            $modal = 18000 * 10;
        }else {
            $modal = 17000 * 10;
        }
        
        // Menemukan harga jual
        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $keuntungan + $bebanProduksi;

        $diskon = $request->diskon;
        $potongan = $request->potongan;

        // Perhitungan harga jika ada diskon
        if( $request->has('diskon') ){
            $hargaDiskon = ($diskon / 100) * $hargaJual;
            $hargaJual -= $hargaDiskon;
        }

        // Perhitungan harga jika ada potongan
        if( $request->has('potongan') ){
            $hargaJual -= $potongan;
        }

        // Logic untuk memasukan foto
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
            'bahan' => $bahan,
            'harga' => $hargaJual,
            'diskon' => $diskon,
            'potongan' => $potongan,
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
            'diskon' => ['required'],
            'potongan' => ['required'],
        ]);

        $bahan = $request->bahan;
        if ( $bahan == 'tebal' ) {
            $modal = 20000 * 10;
        }else if ( $bahan == 'street' ) {
            $modal = 19000 * 10;
        }else if ( $bahan == 'sedang' ) {
            $modal = 18000 * 10;
        }else {
            $modal = 17000 * 10;
        }
        
        // Menemukan harga jual
        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $keuntungan + $bebanProduksi;

        $diskon = $request->diskon;
        $potongan = $request->potongan;

        // Perhitungan harga jika ada diskon
        if( $request->has('diskon') ){
            $hargaDiskon = ($diskon / 100) * $hargaJual;
            $hargaJual -= $hargaDiskon;
        }

        // Perhitungan harga jika ada potongan
        if( $request->has('potongan') ){
            $hargaJual -= $potongan;
        }
        
        // logic untuk memasukan foto
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
            'bahan' => $bahan,
            'harga' => $hargaJual,
            'diskon' => $request->diskon,
            'potongan' => $request->potongan,
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
