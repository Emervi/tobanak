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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Autentikasi pengguna
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->intended('home');
        }

        return Redirect::back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->withInput();
    }
}
