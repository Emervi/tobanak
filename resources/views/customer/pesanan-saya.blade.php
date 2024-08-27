<!-- resources/views/customer/pesanan-saya.blade.php -->

@extends('layouts.app')

@section('body')

    @php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    @endphp


<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Pesanan Saya</h1>

    <div class="flex flex-col gap-4 items-center">
        @foreach($barangs as $barang)
            <div class="bg-white shadow-sm rounded-lg p-4 w-full md:w-3/4">
                <div class="w-full flex justify-between mr-4 text-gray-700 text-center">
                    <div class="text-sm bg-rose-500 text-white p-1 rounded">
                        <i class="fa-solid fa-store mx-1"></i> {{ $barang->nama_cabang }}
                    </div>
                    <div class="text-gray-800 text-sm -mt-1">
                        Estimasi diterima : 
                        @if ($barang->estimasi_pengiriman > 1)
                            {{ Carbon::now()->translatedFormat('d') }}
                            -
                            {{ Carbon::now()->addDays($barang->estimasi_pengiriman - 1)->translatedFormat('d F') }}
                        @else
                            {{ Carbon::now()->translatedFormat('d F') }}
                        @endif  

                        | <span class="text-lg font-semibold text-rose-600">{{ $barang->status_barang }}</span>
                    </div>
                </div>
                <hr class="my-3">
                <div class="mt-4">
                    <div class="flex justify-between">
                        <div class="flex gap-4">
                            <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}" class="w-32 h-32 object-cover rounded-lg bg-gray-100 p-1">
                            <div class="">
                                <h4 class="text-lg font-semibold text-gray-800">{{ $barang->nama_barang }}</h4>
                                <p class="text-gray-600 text-sm mt-1">Kuantitas: {{ $barang->kuantitas }}</p>
                                <p class="text-gray-600 text-sm mt-1">{{ $barang->deskripsi_barang }}</p>
                                <div class="flex items-center mt-2">
                                    @if ($barang->diskon > 0)
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded mr-2">Diskon {{ $barang->diskon }}%</span>
                                    @elseif ($barang->potongan > 1000)
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">Potongan Rp. {{ number_format($barang->potongan, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-10">
                            <p class="text-gray-600 font-semibold">Rp {{ number_format($barang->harga * $barang->kuantitas, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-sm">Harga Satuan: Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <hr class="my-3">
                <div class="w-full items-end text-end">
                    <p class="text-gray-800 my-3">total harga : <span class="text-lg text-rose-500 font-semibold">Rp. {{ number_format($barang->harga * $barang->kuantitas + $barang->harga_ekspedisi, 0, ',', '.') }}</span></p>
                    @if ($barang->status_barang === 'Dikirim')
                    <form action="{{ route('customer.konfirmasiPesanan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_transaksi" value="{{ $barang->id_transaksi }}">
                        <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                        <input type="hidden" name="kuantitas" value="{{ $barang->kuantitas }}">
                        <input type="hidden" name="total_harga_barang" value="{{ $barang->total_harga_barang }}">
                        <button class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">Terima</button>    
                    </form>
                @elseif ($barang->status_barang === 'Diproses')
                    <form action="{{ route('customer.batalPesanan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_transaksi" value="{{ $barang->id_transaksi }}">
                        <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                        <input type="hidden" name="kuantitas" value="{{ $barang->kuantitas }}">
                        <input type="hidden" name="total_harga_barang" value="{{ $barang->total_harga_barang }}">
                        <button class="bg-pink-400 text-white px-4 py-2 rounded">Batal</button>    
                    </form>
                @else
                    <button class="bg-gray-200 text-white px-4 py-2 rounded" disabled>Selesai</button>                        
                @endif
                
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
