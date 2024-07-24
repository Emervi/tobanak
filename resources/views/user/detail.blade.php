@extends('layouts.app')

@section('title', 'Detail Produk')

@section('body')
<div class="mt-8 ml-10">
    <div class="flex items-center mb-4">
        <a href="{{ route('homeUser') }}" class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">Kembali</a>
    </div>
    <div class="flex flex-col md:flex-row items-start md:items-center bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <img src="{{ $barang->foto_barang }}" alt="Foto Barang" class="w-48 h-32 object-cover rounded mr-4">
        <div class="flex-1">
            <h2 class="text-xl font-bold">{{ $barang->nama_barang }}</h2>
            <p class="text-gray-600 mt-10">Bahan: {{ $barang->bahan }}</p>
            <p class="text-gray-600 mt-2">Stok: {{ $barang->stok_barang }}</p>
            <p class="text-gray-600 mt-2">Kategori: {{ $barang->kategori_barang }}</p>
            <p class="text-gray-600 mt-2">Deskripsi: {{ $barang->deskripsi_barang }}</p>
            <div class="mt-20 flex justify-end">
                <span class="text-xl font-bold mr-4">Harga: Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                <a href="{{ route('keranjang') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Tambah ke Keranjang</a>
            </div>
        </div>
    </div>
</div>
@endsection
