<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'id_cabang' => $request->id_cabang,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'status' => 'user',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('auth.login')->with('success', 'Akun berhasil dibuat!');
    }
}
