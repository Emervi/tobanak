<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function tampilLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required', 'min:8'],
        ],[
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal harus 8 karakter',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Autentikasi pengguna
        $credentials = $request->only('username', 'password');

        // dd(Auth::attempt($credentials));
        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->status === 'Admin') {

                session(['admin' => $user]);
                return redirect()->intended(route('admin.dashboard'));

            }

            if ($user->status === 'Kasir') {

                session(['kasir' => $user]);
                return redirect()->intended(route('homeKasir'));

            }

            if ($user->status === 'Pelanggan'){
                session(['customer' => $user]);
                return redirect()->intended(route('customer.home'));
            }
            
            return redirect()->back()->with([
                'error' => 'Status tidak ditemukan!'
            ]);

        }

        return redirect()->back()->with([
            'error' => 'Username atau Password salah!',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        session()->forget('admin');
        session()->forget('kasir');
        session()->forget('pelanggan');

        // session()->flush();
        
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Anda berhasil logout sampai jumpa kembali');
    }
}
