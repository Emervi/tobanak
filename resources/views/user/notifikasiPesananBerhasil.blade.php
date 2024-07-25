@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('body')

<div class="pop-up">
    <div class="w-2/3 mx-auto flex flex-col justify-center items-center gap-10 mt-16 fade-in">
        <img src="{{ asset('images/cek logo 2.png') }}" alt="check logo" class="w-48 h-48 check-anim">
        <h2 class="font-bold text-4xl">Pesanan Berhasil Dibuat</h2>

        <a href="{{ route('homeUser') }}" class="bg-pink-400 text-white px-4 py-2 rounded transition duration-500 ease-in-out hover:bg-green-600">Kembali ke Beranda</a>
    </div>
</div>
  
@endsection