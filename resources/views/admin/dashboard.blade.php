@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('body')

<div class="min-w-full flex flex-col justify-evenly sm:flex-row md:flex-row">

    <a href="" class="flex flex-col justify-between w-1/5 bg-white shadow-2xl p-5 mt-10 rounded-xl hover:bg-black hover:text-white">

        <h2 class="font-bold text-xl text-center overflow-hidden">Daftar Transaksi Hari Ini</h2>

        <div class="font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-exchange"></i>
            <p>200</p>
        </div>

    </a>

    <a href="{{ route('admin.daftarBarang') }}" class="flex flex-col justify-between w-1/6 bg-white shadow-2xl p-5 mt-10 rounded-xl hover:bg-black hover:text-white">

        <h2 class="font-bold text-xl text-center overflow-hidden">Daftar Barang</h2>

        <div class="font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-box"></i>
            <p>200</p>
        </div>

    </a>

    <a href="{{ route('admin.daftarUser') }}" class="flex flex-col justify-between w-1/6 bg-white shadow-2xl p-5 mt-10 rounded-xl hover:bg-black hover:text-white">

        <h2 class="font-bold text-xl text-center overflow-hidden">Daftar User</h2>

        <div class="font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-user"></i>
            <p>200</p>
        </div>

    </a>

</div>

@endsection