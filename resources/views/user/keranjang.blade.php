@extends('layouts.app')

@section('title', 'Keranjang')

@section('body')
<div class="flex flex-col md:flex-row mt-8">

    @if(session('success'))
    <div id="alert-notification" class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center justify-between w-full max-w-xs">
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


    <!-- Kembali Button dan Header -->
    <div class="md:w-7/12 p-4 ml-10">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('homeUser') }}" method="GET">
                <button class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">Kembali</button>
            </form>
            <h2 class="text-2xl font-bold">Keranjang</h2>
        </div>
        
        <!-- Daftar Produk -->
        <div class="space-y-1 ml-10">
            @foreach($keranjang as $item)
                @if($item['barang'])
                    <div class="flex items-center bg-white px-2 py-1 rounded-lg shadow">
                        <img class="w-14 h-14 object-cover rounded mr-4" src="{{ asset('images/' . $item['barang']->foto_barang) }}" alt="Foto Barang">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold">{{ $item['barang']->nama_barang }}</h3>
                            <p class="text-gray-500">Bahan: {{ $item['barang']->bahan_barang }}</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-lg">Jumlah : {{ $item['kuantitas'] }}</span>
                            <span class="text-lg font-bold">Rp {{ number_format($item['barang']->harga, 0, ',', '.') }}</span> <!-- Menggunakan number_format -->
                        </div>
                        <form method="POST" action="{{ route('keranjang.hapus') }}" class="ml-10">
                            @csrf
                            <input type="hidden" name="id_barang" value="{{ $item['barang']->id_barang }}">
                            <button type="submit" class="bg-red-500 text-white hover:bg-red-700 px-2 py-1 rounded-full">X</button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center bg-white px-2 py-1 rounded-lg shadow">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-red-500">Barang tidak ditemukan</h3>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <!-- Ringkasan Pesanan -->
    <div class="md:w-5/12 lg:w-4/12 bg-white p-4 rounded-lg shadow-md sticky top-0 md:ml-auto">
        <h2 class="text-2xl font-bold mb-4">Ringkasan Pesanan</h2>
        <ul class="mb-4">
            @foreach($keranjang as $item)
                @if($item['barang'])
                    <li class="flex justify-between border-b border-opacity-5 mb-1">
                        <span>{{ $item['barang']->nama_barang }} x {{ $item['kuantitas'] }}</span>
                        <span>Rp {{ number_format($item['barang']->harga * $item['kuantitas'], 0, ',', '.') }}</span> <!-- Menggunakan number_format -->
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="flex justify-between items-center mt-20 mb-10 border-t border-t-black">
            <span class="text-xl font-bold">Total:</span>
            <span class="text-xl font-bold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span> <!-- Menggunakan number_format -->
        </div>
        <div class="flex justify-end text-center">
        <a href="{{ route('user.pesananBerhasil') }}" class="bg-pink-400 w-full text-white hover:bg-pink-600 px-4 py-2 rounded">Checkout</a>
        </div>
    </div>
</div>
@endsection
