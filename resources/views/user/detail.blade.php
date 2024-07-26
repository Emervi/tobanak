@extends('layouts.app')

@section('title', 'Detail Produk')

@section('body')
<div class="mt-8 ml-10">
    <div class="flex items-center mb-4">
        <a href="{{ route('homeUser') }}" class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">Kembali</a>
    </div>
    <div class="flex flex-col md:flex-row items-start md:items-center bg-white p-8 rounded-lg shadow-lg max-w-sm md:max-w-3xl mx-auto">
        
        @if(session('success'))
        <div id="alert-notification" class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center justify-between w-full max-w-xs">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 18h.01M3 8l7.89 2.6c.21.07.43.07.64 0L19 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span id="alert-message">{{ session('success') }}</span>
            </div>
            <button onclick="closeAlert()" class="text-white ml-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        @endif

        <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="Foto Barang" class="w-48 h-48 object-cover rounded mr-4">
        <div class="flex-1">
            <h2 class="text-xl font-bold">{{ $barang->nama_barang }}</h2>
            <p class="text-gray-600 mt-10">Bahan: {{ $barang->bahan }}</p>
            <p class="text-gray-600 mt-2">Stok: {{ $barang->stok_barang }}</p>
            <p class="text-gray-600 mt-2">Kategori: {{ $barang->kategori_barang }}</p>
            <p class="text-gray-600 mt-2">Deskripsi: {{ $barang->deskripsi_barang }}</p>
            <div class="mt-20 flex justify-end">
                <span class="text-xl font-bold mr-4">Harga: Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                @if ($barang->stok_barang > 0)

                <form action="{{ route('keranjang.tambah') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                        Tambah ke Keranjang
                    </button>

                </form>

                    
                @else
                    <p class="text-red-500 text-xl"> stok habis</p>
                @endif
                        
            </div>
        </div>
    </div>

    @php
        $keranjang = Session::get('keranjang', []);
        $totalJumlah = array_sum(array_column($keranjang, 'kuantitas'));
    @endphp

    <a href="{{ route('keranjang') }}" class="m-5 fixed bottom-4 right-4 border border-green-500 text-green-500 p-4 rounded-full shadow-lg hover:bg-green-500 hover:text-white">
        Keranjang
        @if($totalJumlah > 0)
            <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-2 py-1 text-xs font-bold">{{ $totalJumlah }}</span>
        @endif
    </a>
</div>
@endsection
