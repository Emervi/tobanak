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

            if ($user->status === 'admin') {

                session(['admin' => $user]);
                return redirect()->intended(route('admin.dashboard'));

            }

            session(['user' => $user]);
            return redirect()->intended(route('homeUser'));
        }

        return redirect()->back()->with([
            'error' => 'Username atau Password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        session()->forget('user');
        session()->forget('admin');

        // session()->flush();
        
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Anda berhasil logout sampai jumpa kembali');
    }
}
