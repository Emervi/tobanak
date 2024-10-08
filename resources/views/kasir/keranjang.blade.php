@extends('layouts.sidebar')

@section('title', 'Keranjang')

@section('content')
<div class="flex flex-col md:flex-row mt-8 mx-4 md:mx-10">
    <!-- Daftar Produk di Keranjang -->
    <div class="md:w-7/12 p-4">
        
        @if(session('success'))
            <div class="fixed top-4 right-4 bg-green-700 border border-green-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out" role="alert">
                <div class="flex items-center justify-between">
                    <span class="text-sm">{{ session('success') }}</span>
                    <button onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);" class="ml-4 text-green-500 hover:text-green-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="fixed top-4 right-4 bg-red-700 border border-red-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out" role="alert">
                <div class="flex items-center justify-between">
                    <span class="text-sm">{{ session('error') }}</span>
                    <button onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);" class="ml-4 text-red-500 hover:text-red-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('homeKasir') }}" class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <h2 class="text-2xl font-bold">Keranjang</h2>
        </div>
        
        <div class="space-y-4">
            @foreach($keranjang as $item)
                @if($item->barang)
                    <div class="bg-white p-4 rounded-lg shadow-md flex items-center">
                        <img class="w-16 h-16 object-cover rounded mr-4" src="{{ asset('images/' . $item->barang->foto_barang) }}" alt="Foto Barang">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold">{{ $item->barang->nama_barang }}</h3>
                            <p class="text-gray-600">Bahan: {{ $item->barang->bahan }}</p>
                        </div>
                        <div class="text-right mr-4">
                            <span class="block text-lg">Jumlah: {{ $item->kuantitas }}</span>
                            <span class="block text-lg font-semibold">Rp {{ number_format($item->barang->harga * $item->kuantitas, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($item->kuantitas > 1)
                                <form action="{{ route('keranjang.kurangi') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="id_keranjang" value="{{ $item->id_keranjang }}">
                                    <input type="hidden" name="id_barang" value="{{ $item->barang->id_barang }}">
                                    <button type="submit" class="bg-yellow-400 text-white hover:bg-yellow-500 px-3 py-1 rounded-lg">-</button>
                                </form>
                            @endif
                            <form action="{{ route('keranjang.hapus') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="id_keranjang" value="{{ $item->id_keranjang }}">
                                <input type="hidden" name="id_barang" value="{{ $item->barang->id_barang }}">
                                <input type="hidden" name="kuantitas" value="{{ $item->kuantitas }}">
                                <button type="submit" class="bg-red-500 text-white hover:bg-red-600 px-3 py-1 rounded-lg">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Ringkasan Pesanan -->
<div x-data="{ isOpen: false }" class="md:w-5/12 lg:w-4/12 bg-white p-6 rounded-lg shadow-md md:ml-auto mt-8 md:mt-0 sticky top-4 h-fit">
    <h2 class="text-2xl font-bold mb-6">Ringkasan Pesanan</h2>
    <ul class="space-y-2 mb-6 max-h-56 overflow-y-auto">
        @foreach($keranjang as $item)
            @if($item->barang)
                <li class="flex justify-between border-b border-gray-200 pb-2">
                    <span>{{ $item->barang->nama_barang }} x {{ $item->kuantitas }}</span>
                    <span>Rp {{ number_format($item->barang->harga * $item->kuantitas, 0, ',', '.') }}</span>
                </li>
            @endif
        @endforeach
    </ul>
    <div class="flex justify-between items-center border-t border-gray-200 pt-4 mb-6">
        <span class="text-xl font-semibold">Total:</span>
        <span class="text-xl font-semibold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
    </div>
    @if ($keranjang->isEmpty())
        <button class="bg-gray-500 text-white px-4 py-2 rounded-lg w-full" disabled >Checkout</button>
    @else
        <button @click="isOpen = true" class="bg-pink-500 text-white hover:bg-pink-600 px-4 py-2 rounded-lg w-full" >Checkout</button>
    @endif

    <!-- Modal -->
    <div x-show="isOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-6">Konfirmasi Checkout</h2>
            <ul class="space-y-2 mb-6 max-h-56 overflow-y-auto">
                @foreach($keranjang as $item)
                    @if($item->barang)
                        <li class="flex justify-between border-b border-gray-200 pb-2">
                            <span>{{ $item->barang->nama_barang }} x {{ $item->kuantitas }}</span>
                            <span>Rp {{ number_format($item->barang->harga * $item->kuantitas, 0, ',', '.') }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="flex justify-between items-center border-t border-gray-200 pt-4 mb-6">
                <span class="text-xl font-semibold">Total:</span>
                <span class="text-xl font-semibold">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
            </div>
            <form id="myForm" method="POST" action="{{ route('transaksi.prosesCheckout') }}">
                @csrf
                <div class="flex items-center mb-4">
                    <label for="uang_pembayaran" class="block text-sm font-medium text-gray-700 w-1/3">Uang Pembayaran</label>
                    <input type="text" id="formatUang" class="ml-4 mt-1 block w-2/3 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-lg py-3 px-4" required>
                    <input type="hidden" id="uang_pembayaran" name="uang_pembayaran">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" @click="isOpen = false" class="bg-gray-500 text-white hover:bg-gray-600 px-4 py-2 rounded-lg">Batal</button>
                    <button type="submit" class="bg-pink-500 text-white hover:bg-pink-600 px-4 py-2 rounded-lg">Checkout</button>
                </div>
            </form>
        </div>
    </div>
    
</div>

</div>
@endsection
