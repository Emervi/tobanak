<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function halamanRegister()
    {
        $cabangs = Cabang::all();

        return view('auth.register', compact('cabangs'));
    }

    public function storeRegister(RegisterRequest $request)
    {
        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'status' => 'Pelanggan',
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('auth.login')->with('success', 'Akun berhasil dibuat!');
    }
}
