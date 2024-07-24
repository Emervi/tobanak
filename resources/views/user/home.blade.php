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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
    @foreach($barangs as $barang)
    <div class="flex flex-col items-center">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <a href="#">
                <img src="{{ $barang->foto_barang }}" alt="Foto Barang" class="w-64 h-48 object-cover">
            </a>
        </div>
        <div class="w-64 p-4 flex flex-col items-start">
            <h2 class="text-xl font-bold">{{ $barang->nama_barang }}</h2>
            <p class="text-gray-600 mt-2">Sisa : {{ $barang->stok_barang }}</p>
            <div class="mt-2 flex justify-between w-full">
                <span class="text-gray-600 font-bold"> harga : Rp. {{ number_format($barang->harga, 0, ',', '.') }}</span>
                <a href="#" class="bg-blue-400 text-white px-4 -mt-3 py-2 rounded-full hover:bg-blue-700">+</a>
            </div>
        </div>
    </div>
    @endforeach

    <a href="{{ route('keranjang') }}" class="m-5 fixed bottom-4 right-4 border border-green-500 text-green-500 p-4 rounded-full shadow-lg hover:bg-green-500 hover:text-white">
        Keranjang
    </a>

</div>
@endsection

