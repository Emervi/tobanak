<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabangRequest;
use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    // halaman cabang
    public function daftarCabang()
    {
        $perPage = 5;

        $cabangs = Cabang::latest()->paginate($perPage);

        $currentPage = $cabangs->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarCabang', compact('cabangs', 'offset'));
    }

    // cari cabang
    public function cariCabang(Request $request)
    {
        $query = $request->keyword_cabang;
        $cabangs = Cabang::where('nama_cabang', 'LIKE', "%$query%")
        ->get();

        $offset = -1;

        return view('admin.daftarCabang', compact('cabangs', 'offset'));
    }

    // halaman tambah cabang
    public function tambahCabang()
    {
        return view('admin.tambahCabang');
    }

    // store cabang
    public function storeCabang(CabangRequest $request)
    {
        Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'lokasi_cabang' => $request->lokasi_cabang,
            'kota_cabang' => $request->kota_cabang,
            'email_cabang' => $request->email_cabang,
        ]);

        return redirect()->route('admin.daftarCabang')->with('success', 'Cabang berhasil ditambahkan!');
    }

    // edit cabang
    public function editCabang($id_cabang)
    {
        $cabang = Cabang::where('id_cabang', $id_cabang)
        ->get();

        return view('admin.tambahCabang', compact('cabang'));
    }

    // update cabang
    public function updateCabang(Request $request, $id_cabang)
    {
        $request->validate([
            'nama_cabang' => ['required', 'string'],
            'lokasi_cabang' => ['required'],
            'kota_cabang' => ['required'],
            'email_cabang' => ['required', 'email'],
        ], [
            'nama_cabang.required' => 'Nama cabang wajib diisi.',
            'nama_cabang.string' => 'Nama cabang wajib berupa string.',
            'lokasi_cabang.required' => 'lokasi cabang wajib diisi.',
            'kota_cabang.required' => 'Kota cabang wajib diisi.',
            'email_cabang.required' => 'Email cabang wajib diisi.',
            'email_cabang.email' => 'Email cabang wajib berupa email dan menggunakan @.',
        ]);

        Cabang::where('id_cabang', $id_cabang)
        ->update([
            'nama_cabang' => $request->nama_cabang,
            'lokasi_cabang' => $request->lokasi_cabang,
            'kota_cabang' => $request->kota_cabang,
            'email_cabang' => $request->email_cabang,
        ]);

        return redirect()->route(('admin.daftarCabang'))->with('success', 'Cabang berhasil diupdate!');
    }

    // destroy cabang
    public function destroyCabang($id_cabang)
    {
        Cabang::where('id_cabang', $id_cabang)
        ->delete();

        return redirect()->back()->with('success', 'Cabang berhasil dihapus!');
    }
}
