<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Barang;
use App\Models\Cabang;
use App\Models\Ekspedisis;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{
    // ADMIN
    // dashboard
    public function dashboardAdmin()
    {
        $jumlahBarang = Barang::count();

        $jumlahUser = User::count();

        $jumlahTransaksi = Transaksi::count();

        $jumlahCabang = Cabang::count();

        $jumlahEkspedisi = Ekspedisis::count();

        $totalStokBarang = Barang::sum('stok_barang');

        $jumlahTransaksiToday = Transaksi::where('tanggal', today())
            ->count();

        $jumlahTransaksiYesterday = Transaksi::where('tanggal', today()->subDay())
            ->count();

        $jumlahPendapatan = Transaksi::where('tanggal', today())
            ->sum('total_harga');

        $name = session('admin')->name;

        return view('admin.dashboard', [
            'jumlahBarang' => $jumlahBarang,
            'jumlahUser' => $jumlahUser,
            'jumlahTransaksi' => $jumlahTransaksi,
            'jumlahCabang' => $jumlahCabang,
            'jumlahEkspedisi' => $jumlahEkspedisi,
            'totalStokBarang' => $totalStokBarang,
            'jumlahTransaksiToday' => $jumlahTransaksiToday,
            'jumlahTransaksiYesterday' => $jumlahTransaksiYesterday,
            'name' => $name,
            'jumlahPendapatan' => $jumlahPendapatan,
        ]);
    }

    // halaman daftar user
    public function daftarUser()
    {
        $perPage = 5;

        $users = User::leftJoin('cabangs', 'users.id_cabang', '=', 'cabangs.id_cabang')
            ->select('users.*', 'cabangs.nama_cabang')
            ->latest()
            ->paginate($perPage);

        $currentPage = $users->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarUser', compact('users', 'offset'));
    }

    // cari barang
    public function cariUser(Request $request)
    {
        $query = $request->keyword_user;
        $users = User::join('cabangs', 'users.id_cabang', '=', 'cabangs.id_cabang')
            ->select('users.*', 'cabangs.nama_cabang')
            ->where('name', 'LIKE', "%$query%")
            ->get();

        $offset = -1;

        return view('admin.daftarUser', compact('users', 'offset'));
    }

    // halaman tambah user
    public function tambahUser()
    {
        $cabangs = Cabang::get();

        return view('admin.tambahUser', compact('cabangs'));
    }

    // store user
    public function storeUser(Request $request)
    {
        User::create([
            'id_cabang' => $request->id_cabang,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.daftarUser')->with('success', 'User berhasil dibuat!');
    }

    // edit user
    public function editUser($id_user)
    {
        $user = User::where('id_user', $id_user)
            ->get();

        $cabangs = Cabang::get();

        // dd(session(), session('errors'), session('attributes'));

        return view('admin.tambahUser', compact('user', 'cabangs'));
    }

    // update user
    public function updateUser(Request $request, $id_user)
    {
        $user = User::where('id_user', $id_user)
            ->firstOrFail();

        $request->validate([
            'id_cabang' => [
                'required'
            ],
            'username' => [
                'required',
                'unique:users,username,' . $user->id_user . ',id_user',
                'min:6'
            ],
            'name' => [
                'required',
                'string',
                'max:35'
            ],
            'email' => [
                'required',
                'unique:users,email,' . $user->id_user . ',id_user',
                'email'
            ],
            'status' => [
                'required'
            ],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.min' => 'Username harus memiliki minimal 6 karakter.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib berupa huruf.',
            'name.max' => 'Nama tidak boleh lebih dari 35 huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'status' => 'Status wajib diisi.',
        ]);

        // dd(1, $request->all());

        $user->update([
            'id_cabang' => $request->id_cabang,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'password' => Hash::make('password'),
        ]);

        return redirect()->route(('admin.daftarUser'))->with('success', 'User berhasil diupdate!');
    }

    // halaman ubah password user
    public function ubahPassword($id_user)
    {
        $user = User::where('id_user', $id_user)
            ->get();

        return view('admin.ubahPassword', compact('user'));
    }

    // ubah password user
    public function updatePassword(Request $request, $id_user)
    {
        $user = User::where('id_user', $id_user)
            ->first();

        $request->validate([
            'password_awal' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {

                    if ($user && !Hash::check($value, $user->password)) {
                        $fail('Password tidak cocok');
                    }
                }
            ],
            'password_baru' => [
                function ($attribute, $value, $fail) use ($request, $user) {

                    if (Hash::check($request->password_awal, $user->password) && $request->filled('password_awal') && !$request->filled('password_baru')) {
                        $attribute . '.required';
                        $fail('Password baru wajib diisi.');
                    }
                },
                function ($attribute, $value, $fail) use ($request, $user) {

                    $panjangPassword = strlen($request->$attribute);

                    if (Hash::check($request->password_awal, $user->password) && $request->filled('password_awal') && $panjangPassword < 8) {
                        $attribute . '.min:8';
                        $fail('Password minimal harus 8 karakter.');
                    }
                }
            ],
            'password_konfirmasi' => [
                'same:password_baru'
            ],
        ], [
            'password_awal.required' => 'Password sebelumnya wajib diisi.',
            'password_konfirmasi.same' => 'Password dan konfirmasi password tidak cocok.',
        ]);

        User::where('id_user', $id_user)
            ->update([
                'password' => Hash::make($request->password_baru),
            ]);

        return redirect()->route('admin.daftarUser')->with('success', 'Password berhasil diubah untuk akun ' . $user->username);
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
