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
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Autentikasi pengguna
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            if (Auth::user()->status === 'admin') {
                return redirect()->intended('/');
            }
            return redirect()->intended(route('homeUser'));
        }

        return Redirect::back()->withErrors([
            'username' => 'These credentials do not match our records.',
        ])->withInput();
    }
}
