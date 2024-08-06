<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use App\Models\Cabang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // halaman barang
    public function daftarBarang()
    {
        $perPage = 5;

        $barangs = Barang::join('cabangs', 'barangs.id_cabang', '=', 'cabangs.id_cabang')
        ->select('barangs.*', 'cabangs.nama_cabang')
        ->latest()
        ->paginate($perPage);

        $currentPage = $barangs->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarBarang', compact('barangs', 'offset'));
    }

    // cari barang
    public function cariBarang(Request $request)
    {
        $query = $request->keyword_barang;
        $barangs = Barang::where('nama_barang', 'LIKE', "%$query%")
        ->get();

        $offset = -1;

        return view('admin.daftarBarang', compact('barangs', 'offset'));
    }

    // halaman tambah barang
    public function tambahBarang()
    {
        $cabangs = Cabang::get();

        return view('admin.tambahBarang', compact('cabangs'));
    }

    // store barang
    public function storeBarang(BarangRequest $request)
    {

        // Harga modal dengan patokan bahan
        $bahan = $request->bahan;
        if ($bahan == 'Tebal') {
            $modal = 20000 * 10;
        } else if ($bahan == 'Street') {
            $modal = 19000 * 10;
        } else if ($bahan == 'Sedang') {
            $modal = 18000 * 10;
        } else {
            $modal = 17000 * 10;
        }

        // Menemukan harga jual
        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $keuntungan + $bebanProduksi;

        session()->put('hargaAsli', $hargaJual);

        // Pengecekan apakah ada diskon yang diinputkan
        if ( empty($request->diskon)  ){
            $diskon = 0;
        }else{
            $diskon = $request->diskon;
        }

        // Pengecekan apakah ada potongan yang diinputkan
        if ( empty($request->potongan) ){
            $potongan = 0;
        }else{
            $potongan = $request->potongan;
        }
        
        // Perhitungan harga diskon
        $hargaDiskon = ($diskon / 100) * $hargaJual;
        $hargaJual -= $hargaDiskon;

        // Perhitungan harga potongan
        $hargaJual -= $potongan;

        // Logic untuk memasukan foto
        if ($request->has('foto_barang')) {
            $imageName = time() . '.' . $request->foto_barang->extension();
            $request->foto_barang->move(public_path('images'), $imageName);
        } else {
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
            'id_cabang' => $request->id_cabang,
            'distribusi' => 'Dikirim',
        ]);

        return redirect()->route('admin.daftarBarang')->with('success', 'Barang berhasil ditambahkan!');
    }

    // edit barang
    public function editBarang($id_barang)
    {
        $barang = Barang::where('id_barang', $id_barang)
        ->get();

        $cabangs = Cabang::get();

        return view('admin.tambahBarang', compact('barang', 'cabangs'));
    }

    // update barang
    public function updateBarang(Request $request, $id_barang)
    {
        $barang = Barang::where('id_barang', $id_barang)
        ->first();

        $request->validate([
            'nama_barang' => ['required', 'string', 'unique:barangs,nama_barang,' . $id_barang . ',id_barang'],
            'kategori_barang' => ['required'],
            'deskripsi_barang' => ['required'],
            'stok_barang' => ['required', 'integer'],
            'bahan' => ['required'],
            'foto_barang' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.unique' => 'Nama barang sudah terdaftar',
            'nama_barang.string' => 'Nama barang tidak boleh mengandung angka',
            'kategori_barang.required' => 'Kategori wajib diisi',
            'deskripsi_barang.required' => 'Deskripsi barang wajib diisi',
            'stok_barang.required' => 'Stok barang wajib diisi',
            'stok_barang.integer' => 'Stok barang wajib bernilai bilangan bulat',
            'bahan.required' => 'Bahan wajib diisi',
            'foto_barang.image' => 'File yang dimasukan harus berupa image',
            'foto_barang.mimes' => 'File yang dimasukan harus berformat berikut : jpeg, png, jpg',
            'foto_barang.max' => 'Foto maksimal berukuran 2 MB'
        ]);

        $bahan = $request->bahan;
        if ($bahan == 'Tebal') {
            $modal = 20000 * 10;
        } else if ($bahan == 'Street') {
            $modal = 19000 * 10;
        } else if ($bahan == 'Sedang') {
            $modal = 18000 * 10;
        } else {
            $modal = 17000 * 10;
        }

        // Menemukan harga jual
        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $keuntungan + $bebanProduksi;

        session()->put('hargaAsli', $hargaJual);

        // Pengecekan apakah ada diskon yang diinputkan
        if ( empty($request->diskon) ){
            $diskon = 0;
        }else{
            $diskon = $request->diskon;
        }

        // Pengecekan apakah ada potongan yang diinputkan
        if ( empty($request->potongan) ){
            $potongan = 0;
        }else{
            $potongan = $request->potongan;
        }
        
        // Perhitungan harga diskon
        $hargaDiskon = ($diskon / 100) * $hargaJual;
        $hargaJual -= $hargaDiskon;

        // Perhitungan harga potongan
        $hargaJual -= $potongan;

        // logic untuk memasukan foto
        if ($request->has('foto_barang')) {
            $imageName = time() . '.' . $request->foto_barang->extension();
            $request->foto_barang->move(public_path('images'), $imageName);
        } else {
            $imageName = Barang::where('id_barang', $id_barang)
                ->pluck('foto_barang')
                ->first();
        }

        // logic perpindahan distribusi barang
        if ( $request->id_cabang !== $barang->id_cabang ){
            $distribusi = "Dikirim";
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
                'diskon' => $diskon,
                'potongan' => $potongan,
                'id_cabang' => $request->id_cabang,
                'distribusi' => $distribusi,
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
