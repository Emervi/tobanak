<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BarangController extends Controller
{
    // halaman barang
    public function daftarBarang(Request $request)
    {
        $cabangs = Cabang::all();

        $columns = Schema::getColumnListing('barangs');

        $length = count($columns);
        foreach ($columns as $index => $col) {

            
            if ($index == 0) continue;
            $columnBarangs[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 5) break;

        }
        $columnBarangs['kategori_barang'] = 'Kategori';
        $columnBarangs['deskripsi_barang'] = 'Deskripsi';
        $columnBarangs['id_cabang'] = 'Cabang';
        $columnBarangs['distribusi'] = 'Status Distribusi';

        $barangs = Barang::leftJoin('cabangs', 'cabangs.id_cabang', '=', 'barangs.id_cabang')
        ->select('barangs.*', 'cabangs.nama_cabang')
        ->latest('barangs.updated_at')
        ->get();

        $barangSiap = Barang::whereIn('distribusi', ['Siap kirim', 'Ditarik'])
        ->latest()
        ->get();

        $barangTerproses = Barang::join('cabangs', 'cabangs.id_cabang', '=', 'barangs.id_cabang')
        ->whereNotIn('distribusi', ['Siap kirim', 'Ditarik'])
        ->latest('barangs.created_at')
        ->get();

        $filter = $request->query('filter_distribusi');

        if ( $filter ){

            $barangs = Barang::join('cabangs', 'barangs.id_cabang', '=', 'cabangs.id_cabang')
            ->select('barangs.*', 'cabangs.nama_cabang')
            ->where('distribusi', $filter)
            ->latest()
            ->get();

        }

        if ( $filter == 'Siap kirim' ){

            $barangs = Barang::where('distribusi', 'Siap kirim')
            ->latest()
            ->get();

        }

        $offset = -1;

        $totalStok = Barang::sum('stok_barang');
        
        return view('admin.daftarBarang', compact(
            'barangs', 
            'offset', 
            'totalStok', 
            'cabangs', 
            'barangSiap', 
            'barangTerproses',
            'columnBarangs',
        ));
    }

    // cari barang
    public function cariBarang(Request $request)
    {
        $request->validate([
            'keyword_barang' => ['required'],
        ], [
            'keyword_barang.required' => 'Nama barang kosong.',
        ]);

        $cabangs = Cabang::all();

        $query = $request->keyword_barang;
        $barangs = Barang::leftJoin('cabangs', 'cabangs.id_cabang', '=', 'barangs.id_cabang')
        ->select('barangs.*', 'cabangs.nama_cabang')
        ->where('nama_barang', 'LIKE', "%$query%")
        ->get();

        $offset = -1;

        $totalStok = Barang::sum('stok_barang');

        return view('admin.daftarBarang', compact('barangs', 'offset', 'totalStok', 'cabangs'));
    }

    // halaman tambah barang
    public function tambahBarang()
    {
        $columns = Schema::getColumnListing('barangs');

        $length = count($columns);
        foreach ($columns as $index => $col) {

            
            if ($index == 0) continue;
            $columnBarangs[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 3) break;

        }
        $columnBarangs['kategori_barang'] = 'Kategori';
        $columnBarangs['deskripsi_barang'] = 'Deskripsi';
        $columnBarangs['id_cabang'] = 'Cabang';
        $columnBarangs['distribusi'] = 'Status Distribusi';

        $cabangs = Cabang::get();

        return view('admin.tambahBarang', compact('cabangs', 'columnBarangs'));
    }

    // untuk mengabil lalu menampilkan harga dengan json
    public function getHarga(Request $request)
    {        
        $bahan = $request->input('bahan');

        if ($bahan == 'Tebal') {
            $modal = 20000 * 10;
        } else if ($bahan == 'Street') {
            $modal = 19000 * 10;
        } else if ($bahan == 'Sedang') {
            $modal = 18000 * 10;
        } else if ($bahan == 'Tipis') {
            $modal = 17000 * 10;
        } else {
            $modal = 0;
        }

        // Menemukan harga jual
        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $keuntungan + $bebanProduksi;

        // pengecekan diskon
        if ( $request->has('diskon') ){
            $diskon = $request->input('diskon');
        }else{
            $diskon = 0;
        }

        // pengecekan potongna
        if ( $request->has('potongan') ){
            $potongan = $request->input('potongan');
        }else{
            $potongan = 0;
        }

        // Perhitungan harga hasil diskon
        $hargaDiskon = ($diskon / 100) * $hargaJual;
        $hargaJual -= $hargaDiskon;

        // Perhitungan harga hasil potongan
        $hargaJual -= $potongan;

        // Pengecekan akhir jika harga kurang dari 0 maka akan tetap 0
        if ( $hargaJual < 0 ){
            $hargaJual = 0;
        }
        
        return response()->json(['hargaAkhir' => $hargaJual]);
    }

    // store barang
    public function storeBarang(BarangRequest $request)
    {
        $hargaJual = $request->harga;

        // logic memasukan gambar
        $image = $request->foto_barang;
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        // mengecek apakah ada diskon
        if ( !empty($request->diskon) ){
            $diskon = $request->diskon;
        }else{
            $diskon = 0;
        }

        // mengecek apakah ada potongan
        if ( !empty($request->potongan) ){
            $potongan = $request->potongan;
        }else{
            $potongan = 0;
        }

        Barang::create([
            'foto_barang' => $imageName,
            'nama_barang' => $request->nama_barang,
            'kategori_barang' => $request->kategori_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'stok_barang' => $request->stok_barang,
            'bahan' => $request->bahan,
            'harga' => $hargaJual,
            'diskon' => $diskon,
            'potongan' => $potongan,
            'distribusi' => 'Siap kirim',
        ]);

        session()->put('hargaAsli', $hargaJual);

        return redirect()->route('admin.daftarBarang')->with('success', 'Barang berhasil ditambahkan!');
    }

    // edit barang
    public function editBarang($id_barang)
    {
        $columns = Schema::getColumnListing('barangs');

        $length = count($columns);
        foreach ($columns as $index => $col) {

            
            if ($index == 0) continue;
            $columnBarangs[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 3) break;

        }
        $columnBarangs['kategori_barang'] = 'Kategori';
        $columnBarangs['deskripsi_barang'] = 'Deskripsi';
        $columnBarangs['id_cabang'] = 'Cabang';
        $columnBarangs['distribusi'] = 'Status Distribusi';

        $barang = Barang::where('id_barang', $id_barang)
        ->get();

        $cabangs = Cabang::get();

        return view('admin.tambahBarang', compact('barang', 'cabangs', 'columnBarangs'));
    }

    // update barang
    public function updateBarang(Request $request, $id_barang)
    {
        $hargaJual = $request->harga;

        $request->validate([
            'nama_barang' => ['required', 'string'],
            'kategori_barang' => ['required'],
            'deskripsi_barang' => ['required'],
            'stok_barang' => ['required', 'integer'],
            'bahan' => ['required'],
            'foto_barang' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
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

        // logic untuk memasukan foto
        if ($request->has('foto_barang')) {
            $image = $request->foto_barang;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = Barang::where('id_barang', $id_barang)
                ->pluck('foto_barang')
                ->first();
        }

        // mengecek apakah ada diskon
        if ( !empty($request->diskon) ){
            $diskon = $request->diskon;
        }else{
            $diskon = 0;
        }

        // mengecek apakah ada potongan
        if ( !empty($request->potongan) ){
            $potongan = $request->potongan;
        }else{
            $potongan = 0;
        }

        // logic perpindahan distribusi barang
        // if ( $request->id_cabang == $barang->id_cabang ){
        //     $distribusi = $barang->distribusi;
        // }else{
        //     $distribusi = "Dikirim";
        // }

        Barang::where('id_barang', $id_barang)
            ->update([
                'foto_barang' => $imageName,
                'nama_barang' => $request->nama_barang,
                'kategori_barang' => $request->kategori_barang,
                'deskripsi_barang' => $request->deskripsi_barang,
                'stok_barang' => $request->stok_barang,
                'bahan' => $request->bahan,
                'harga' => $hargaJual,
                'diskon' => $diskon,
                'potongan' => $potongan,
            ]);

        return redirect()->route(('admin.daftarBarang'))->with('success', 'Barang berhasil diupdate!');
    }

    // distribusi barang
    public function distribusiBarang(Request $request){

        $request->validate([
            'id_cabang' => ['required'],
            'checkboxs' => ['required'],
        ], [
            'id_cabang.required' => 'Cabang wajib diisi.',
            'checkboxs.required' => 'Barang belum dipilih.',
        ]);

        $id_barangs = $request->input('id_barangs', []);
        $checkboxs = $request->input('checkboxs', []);
        $id_cabang = $request->id_cabang;

        foreach ( $id_barangs as $id_barang ) {

            $barang = Barang::where('id_barang', $id_barang)
            ->first();

            $checkbox = isset($checkboxs[$id_barang]);

            Barang::where('id_barang', $id_barang)
            ->update([
                'id_cabang' => $checkbox ? $id_cabang : $barang->id_cabang,
                'distribusi' => $checkbox ? 'Dikirim' : $barang->distribusi,
            ]);

        }

        return redirect()->back()->with('success', 'Barang berhasil dikirim!');

    }

    // distribusi barang
    public function tarikBarang(Request $request){

        $request->validate([
            'checkboxs' => ['required'],
        ], [
            'checkboxs.required' => 'Barang belum dipilih.',
        ]);

        $id_barangs = $request->input('id_barangs', []);
        $checkboxs = $request->input('checkboxs', []);

        foreach ( $id_barangs as $id_barang ) {

            $barang = Barang::where('id_barang', $id_barang)
            ->first();

            $checkbox = isset($checkboxs[$id_barang]);

            Barang::where('id_barang', $id_barang)
            ->update([
                'id_cabang' => $checkbox ? null : $barang->id_cabang,
                'distribusi' => $checkbox ? 'Ditarik' : $barang->distribusi,
            ]);

        }

        return redirect()->back()->with('success', 'Barang berhasil dikirim!');

    }

    // destroy barang
    public function destroyBarang($id_barang)
    {
        Barang::where('id_barang', $id_barang)
        ->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}
