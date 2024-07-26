@extends('layouts.app')

@section('title', 'Home')

@section('body')

<div class="mb-4">
    <h1 class="text-2xl font-bold m-3">Produk Kami</h1>
    <form method="GET" action="{{ route('homeUser') }}">
        <select name="filter" class="ml-10 block bg-white text-gray-700 py-2 px-10 shadow-md border border-gray-200 rounded" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $category)
            <option value="{{ $category }}" {{ request('filter') == $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
        </select>
    </form>
</div>

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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
    @foreach($barangs as $barang)
    <div class="flex flex-col items-center">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <a href="{{ route('detailProduk', ['id_barang' => $barang->id_barang]) }}">
                <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="Foto Barang" class="w-64 h-48 object-cover">
            </a>
        </div>
        <div class="w-64 p-4 flex flex-col items-start">
            <h2 class="text-xl font-bold">{{ $barang->nama_barang }}</h2>
            <p class="text-gray-600 mt-2">Stok : {{ $barang->stok_barang }}</p>
            <div class="mt-2 flex justify-between w-full">
                <span class="text-gray-600 font-bold"> harga : Rp. {{ number_format($barang->harga, 0, ',', '.') }}</span>
                @if ($barang->stok_barang > 0)
                <form action="{{ route('keranjang.tambah') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                    <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded-full hover:bg-blue-700">+</button>
                </form>
                @else
                    <div class="flex flex-col items-end">
                        <p class="text-red-500 text-md">stok</p>
                        <p class="text-red-500 text-md">habis</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach

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

