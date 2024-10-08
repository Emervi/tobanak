<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ekspedisis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EkspedisiController extends Controller
{
    // halaman ekspedisi
    public function daftarEkspedisi()
    {
        $columns = Schema::getColumnListing('ekspedisis');

        foreach ($columns as $index => $col) {

            if ($index == 0) continue;
            $columnEkspedisis[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == 4) break;

        }

        $ekspedisis = Ekspedisis::latest()
            ->get();


        return view('admin.daftarEkspedisi', compact('ekspedisis', 'columnEkspedisis'));
    }

    // cari ekspedisi
    public function cariEkspedisi(Request $request)
    {
        $query = $request->keyword_ekspedisi;
        $ekspedisis = Ekspedisis::where('nama_ekspedisi', 'LIKE', "%$query%")
            ->get();

        return view('admin.daftarEkspedisi', compact('ekspedisis'));
    }

    // halaman tambah ekspedisi
    public function tambahEkspedisi()
    {
        $columns = Schema::getColumnListing('ekspedisis');

        foreach ($columns as $index => $col) {

            if ($index == 0) continue;
            $columnEkspedisis[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == 4) break;

        }

        return view('admin.tambahEkspedisi', compact('columnEkspedisis'));
    }

    // store ekspedisi
    public function storeEkspedisi(Request $request)
    {
        $request->validate([
            'nama_ekspedisi' => ['required'],
            'jenis_pengiriman' => ['required', 'unique:ekspedisis,jenis_pengiriman'],
            'harga_ekspedisi' => ['required'],
            'estimasi_pengiriman' => ['required', 'numeric', 'min:1'],
        ], [
            'nama_ekspedisi.required' => 'Nama ekspedisi wajib diisi.',
            'jenis_pengiriman.required' => 'Jenis pengiriman wajib diisi.',
            'jenis_pengiriman.unique' => 'Jenis pengiriman ini sudah terdaftar.',
            'harga_ekspedisi.required' => 'Harga ekspedisi wajib diisi.',
            'estimasi_pengiriman.required' => 'Estimasi pengiriman wajib diisi.',
            'estimasi_pengiriman.numeric' => 'Estimasi pengiriman wajid berupa angka.',
            'estimasi_pengiriman.min' => 'Estimasi pengiriman tidak boleh kurang dari 1 hari.',
        ]);

        Ekspedisis::create([
            'nama_ekspedisi' => $request->nama_ekspedisi,
            'jenis_pengiriman' => $request->jenis_pengiriman,
            'harga_ekspedisi' => $request->harga_ekspedisi,
            'estimasi_pengiriman' => $request->estimasi_pengiriman,
        ]);

        return redirect()->route('admin.daftarEkspedisi')->with('success', 'Ekspedisi berhasil ditambahkan!');
    }

    // edit ekspedisi
    public function editEkspedisi($id_ekspedisi)
    {
        $columns = Schema::getColumnListing('ekspedisis');

        foreach ($columns as $index => $col) {

            if ($index == 0) continue;
            $columnEkspedisis[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == 4) break;

        }

        $ekspedisi = Ekspedisis::where('id_ekspedisi', $id_ekspedisi)
            ->get();

        return view('admin.tambahEkspedisi', compact('ekspedisi', 'columnEkspedisis'));
    }

    // update ekspedisi
    public function updateEkspedisi(Request $request, $id_ekspedisi)
    {
        $request->validate([
            'nama_ekspedisi' => ['required'],
            'jenis_pengiriman' => ['required', 'unique:ekspedisis,jenis_pengiriman, ' . $id_ekspedisi . ',id_ekspedisi'],
            'harga_ekspedisi' => ['required'],
            'estimasi_pengiriman' => ['required', 'numeric', 'min:1'],
        ], [
            'nama_ekspedisi.required' => 'Nama ekspedisi wajib diisi.',
            'jenis_pengiriman.required' => 'Jenis pengiriman wajib diisi.',
            'jenis_pengiriman.unique' => 'Jenis pengiriman ini sudah terdaftar.',
            'harga_ekspedisi.required' => 'Harga ekspedisi wajib diisi.',
            'estimasi_pengiriman.required' => 'Estimasi pengiriman wajib diisi.',
            'estimasi_pengiriman.numeric' => 'Estimasi pengiriman wajid berupa angka.',
            'estimasi_pengiriman.min' => 'Estimasi pengiriman tidak boleh kurang dari 1 hari.',
        ]);

        Ekspedisis::where('id_ekspedisi', $id_ekspedisi)
            ->update([
                'nama_ekspedisi' => $request->nama_ekspedisi,
                'jenis_pengiriman' => $request->jenis_pengiriman,
                'harga_ekspedisi' => $request->harga_ekspedisi,
                'estimasi_pengiriman' => $request->estimasi_pengiriman,
            ]);

        return redirect()->route(('admin.daftarEkspedisi'))->with('success', 'Ekspedisi berhasil diupdate!');
    }

    // destroy ekspedisi
    public function destroyEkspedisi($id_ekspedisi)
    {
        Ekspedisis::where('id_ekspedisi', $id_ekspedisi)
            ->delete();

        return redirect()->back()->with('success', 'Ekspedisi berhasil dihapus!');
    }
}
