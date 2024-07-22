<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function halamanRegister()
    {
        return view('/register');
    }

    public function storeRegister(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'status' => $request->status,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('auth.register')->with('success', 'Akun berhasil dibuat!');
    }
}
