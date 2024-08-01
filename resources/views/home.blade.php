@extends('layouts.app')

@section('title', 'Welcome to Tobanak')

@section('body')
<div class="fade-in">
<div class="font-bold text-center text-5xl w-1/2 mx-auto mt-10 flex flex-col justify-center items-center gap-3 landing-page">
    <h1>Selamat Datang di Tobanak</h1>
    <p>(Toko Baju Anak)</p>
    <img src="{{ asset('images/logo_tobanak.png') }}" alt="logo tobanak" class="w-80 h-80">
</div>
</div>
@endsection