<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function halamanRegister()
    {
        return view('auth.register');
    }

    public function storeRegister(RegisterRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'status' => 'user',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return redirect()->route('auth.login')->with('success', 'Akun berhasil dibuat!');
    }
}
