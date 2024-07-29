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
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Autentikasi pengguna
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->status === 'admin') {

                session(['admin' => $user]);
                return redirect()->intended(route('admin.dashboard'));

            }

            session(['user' => $user]);
            return redirect()->intended(route('homeUser'));
        }

        return Redirect::back()->withErrors([
            'error' => 'These credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        session()->flush();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Anda berhasil logout sampai jumpa kembali');
    }
}
