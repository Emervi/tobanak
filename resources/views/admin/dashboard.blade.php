@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('body')

<div class="mt-9 mx-3">
    <h1 class="text-3xl font-bold m-3">Dashboard</h1>
</div>

{{-- flexbox atas --}}
<div class="min-w-full flex flex-wrap gap-1 flex-col justify-evenly sm:flex-row md:flex-row">

    <a href="{{ route('admin.daftarUser') }}" class="flex w-1/5 flex-col justify-between bg-sky-400 shadow-md p-3 mt-10 rounded-xl hover:bg-sky-500 text-white hover:text-gray-900 transition transform hover:-translate-y-1 hover:scale-105 duration-300 ease-in-out">
        <h2 class=" font-bold text-xl text-center overflow-hidden">Daftar Pelanggan</h2>
        <div class=" font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-user"></i>
            <p>{{ $jumlahUser }}</p>
        </div>
    </a>

    <a href="{{ route('admin.daftarBarang') }}" class="flex w-1/5 flex-col justify-between bg-yellow-400 shadow-md p-3 mt-10 rounded-xl hover:bg-yellow-500 text-white hover:text-gray-900 transition transform hover:-translate-y-1 hover:scale-105 duration-300 ease-in-out">
        <h2 class="font-bold text-xl text-center overflow-hidden">Daftar Barang</h2>
        <div class="font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-box"></i>
            <p>{{ $jumlahBarang }}</p>
        </div>
    </a>

    <a href="{{ route('admin.daftarTransaksi') }}" class="flex w-1/5 flex-col justify-between bg-green-500 shadow-md p-3 mt-10 rounded-xl hover:bg-green-600 text-white hover:text-gray-900 transition transform hover:-translate-y-1 hover:scale-105 duration-300 ease-in-out">
        <h2 class="font-bold text-xl text-center overflow-hidden">Daftar Transaksi</h2>
        <div class="font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-exchange"></i>
            <p>{{ $jumlahTransaksi }}</p>
        </div>
    </a>

    <a href="{{ route('admin.daftarCabang') }}" class="flex w-1/5 flex-col justify-between bg-rose-400 shadow-md p-3 mt-10 rounded-xl hover:bg-rose-500 text-white hover:text-gray-900 transition transform hover:-translate-y-1 hover:scale-105 duration-300 ease-in-out">
        <h2 class="font-bold text-xl text-center overflow-hidden">Daftar Cabang</h2>
        <div class="font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-store"></i>
            <p>{{ $jumlahCabang }}</p>
        </div>
    </a>

    {{-- <div class="flex w-1/5 flex-col justify-between bg-gray-900 text-white shadow-md p-3 mt-10 rounded-xl">

        <h2 class="font-bold text-xl text-center overflow-hidden">Total Stok Barang</h2>

        <div class="font-medium text-5xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-warehouse"></i>
            <p>{{ $totalStokBarang }}</p>
        </div>

    </div> --}}
    
    

</div>

{{-- flexbox bawah --}}
<div class="min-w-full flex flex-col justify-evenly sm:flex-row md:flex-row mb-10">
    
    <div class="flex w-1/4 flex-col justify-between bg-white text-gray-700 shadow-sm p-3 mt-10 rounded-xl">
        <h2 class="font-semibold text-lg text-center overflow-hidden">Jumlah Pendapatan Hari Ini</h2>
        <div class="font-medium text-3xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <p>Rp. {{ number_format($jumlahPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="flex w-1/4 flex-col justify-between bg-white text-gray-700 shadow-sm p-3 mt-10 rounded-xl">
        <h2 class="font-semibold text-lg text-center overflow-hidden">Transaksi Hari Ini</h2>
        <div class="font-medium text-3xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-line-chart"></i>
            <p>{{ $jumlahTransaksiToday }}</p>
        </div>
    </div>

    <div class="flex w-1/4 flex-col justify-between bg-white text-gray-700 shadow-sm p-3 mt-10 rounded-xl">
        <h2 class="font-semibold text-lg text-center overflow-hidden">Transaksi Kemarin</h2>
        <div class="font-medium text-3xl flex flex-col md:flex-row justify-evenly items-center mt-3">
            <i class="fas fa-line-chart"></i>
            <p>{{ $jumlahTransaksiYesterday }}</p>
        </div>
    </div>

</div>


@endsection