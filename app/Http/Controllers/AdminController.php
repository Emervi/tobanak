<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ADMIN
    // dashboard
    public function dashboardAdmin()
    {
        $jumlahBarang = Barang::count();

        $jumlahUser = User::count();

        $jumlahTransaksi = Transaksi::where('tanggal', today())
        ->count();

        return view('admin.dashboard', [
            'jumlahBarang' => $jumlahBarang,
            'jumlahUser' => $jumlahUser,
            'jumlahTransaksi' => $jumlahTransaksi,
        ]);
    }

    // halaman daftar user
    public function daftarUser()
    {
        $users = User::get();

        return view('admin.daftarUser', compact('users'));
    }

    // cari barang
    public function cariUser(Request $request)
    {
        $query = $request->keyword_user;
        $users = User::where('name', 'LIKE', "%$query%")
        ->get();

        return view('admin.daftarUser', compact('users'));
    }

    // edit user
    public function editUser($id_user)
    {
        $user = User::where('id_user', $id_user)
        ->get();

        return view('admin.editUser', compact('user'));
    }

    // update user
    public function updateUser(Request $request, $id_user)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'status' => ['required'],
        ]);

        User::where('id_user', $id_user)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route(('admin.daftarUser'))->with('success', 'User berhasil diupdate!');
    }

    // destroy user
    public function destroyUser($id_user)
    {
        User::where('id_user', $id_user)
        ->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
    // \ADMIN
}
