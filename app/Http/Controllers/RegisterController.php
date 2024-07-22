<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function halamanRegister()
    {
        return view('auth.register');
    }

    public function storeRegister(RegisterRequest $request)
    {
        if($request->password2 != $request->password){
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok!');
        }

        User::create([
            'name' => $request->name,
            'status' => $request->status,
            'email' => $request->email,
            'password' => Hash::make( $request->password ),
        ]);

        return redirect()->route('auth.register')->with('success', 'Akun berhasil dibuat!');
    }
}
