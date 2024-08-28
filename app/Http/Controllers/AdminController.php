<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Barang;
use App\Models\Cabang;
use App\Models\Ekspedisis;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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


        $transaksi = Transaksi::selectRaw('DATE(created_at) as date, SUM(total_harga) as total')
                    ->groupBy('date')
                    ->get();

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
            'data' => $jumlahTransaksi,
            'transaksi' => $transaksi,
        ]);
    }

    // halaman daftar user
    public function daftarUser()
    {
        $columns = Schema::getColumnListing('users');

        $length = count($columns);
        foreach ($columns as $index => $col) {

            
            if ($index == 0) continue;
            $columnUsers[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 8) break;

        }
        $columnUsers['id_cabang'] = 'Cabang';

        $perPage = 5;

        $users = User::leftJoin('cabangs', 'users.id_cabang', '=', 'cabangs.id_cabang')
            ->select('users.*', 'cabangs.nama_cabang')
            ->latest()
            ->paginate($perPage);

        $currentPage = $users->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftarUser', compact('users', 'offset', 'columnUsers'));
    }

    // cari barang
    public function cariUser(Request $request)
    {
        $columns = Schema::getColumnListing('users');

        $length = count($columns);
        foreach ($columns as $index => $col) {

            
            if ($index == 0) continue;
            $columnUsers[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 8) break;

        }
        $columnUsers['id_cabang'] = 'Cabang';

        $query = $request->keyword_user;
        $users = User::join('cabangs', 'users.id_cabang', '=', 'cabangs.id_cabang')
            ->select('users.*', 'cabangs.nama_cabang')
            ->where('username', 'LIKE', "%$query%")
            ->get();

        $offset = -1;

        return view('admin.daftarUser', compact('users', 'offset', 'columnUsers'));
    }

    // halaman tambah user
    public function tambahUser()
    {
        $columns = Schema::getColumnListing('users');
        $length = count($columns);
        foreach ($columns as $index => $col) {
            
            if ($index == 0) continue;
            $columnUsers[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 7) break;

        }
        $columnUsers['id_cabang'] = 'Cabang';

        $cabangs = Cabang::get();

        return view('admin.tambahUser', compact('cabangs', 'columnUsers'));
    }

    // store user
    public function storeUser(UserRequest $request)
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
        $columns = Schema::getColumnListing('users');
        $length = count($columns);
        foreach ($columns as $index => $col) {
            
            if ($index == 0) continue;
            $columnUsers[$columns[$index]] = ucwords(str_replace('_', ' ', $col));
            if ($index == $length - 7) break;

        }
        $columnUsers['id_cabang'] = 'Cabang';

        $user = User::where('id_user', $id_user)
            ->get();

        $cabangs = Cabang::get();

        // dd(session(), session('errors'), session('attributes'));

        return view('admin.tambahUser', compact('user', 'cabangs', 'columnUsers'));
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
                        $fail('Password salah.');
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
