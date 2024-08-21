<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekSessionNull
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( session()->has('admin') ){
            return redirect()->route('admin.dashboard')->with('gagal', 'Anda masih login!');
        }

        if ( session()->has('kasir') ){
            return redirect()->route('homeUser')->with('gagal', 'Anda masih login!');
        }

        if ( session()->has('customer') ){
            return redirect()->route('customer.home')->with('gagal', 'Anda masih login!');
        }

        return $next($request);
    }
}
