@extends('layouts.sidebar')

@section('title', 'Notifikasi Berhasil')

@section('content')
<div class="container mx-auto p-4">

    <!-- Notifikasi Berhasil -->

    <!-- Struk Belanja -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6 max-w-lg mx-auto mt-10">
        <div class="text-center w-full">
            <p class="text-lg mb-3">============= &nbsp;
                <span class="font-bold">{{ $cabangs->nama_cabang }}</span> 
                &nbsp; =============</p></div>
        <div class=" pb-2 my-4">
            <p class="text-sm">Tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
            <p class="text-sm">Nomor Order: {{ session('orderData.orderId') }}</p>
        </div>
        <div class="mb-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-1 px-2">Nama Barang</th>
                        <th class="text-right py-1 px-2">Jumlah</th>
                        <th class="text-right py-1 px-2">Harga</th>
                        <th class="text-right py-1 px-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('orderData.keranjang', []) as $item)
                        @if($item->barang)
                            <tr class="border-b">
                                <td class="py-1 px-2">{{ $item->barang->nama_barang }}</td>
                                <td class="py-1 px-2 text-right">{{ $item->kuantitas }}</td>
                                <td class="py-1 px-2 text-right">Rp {{ number_format($item->barang->harga, 0, ',', '.') }}</td>
                                <td class="py-1 px-2 text-right">Rp {{ number_format($item->barang->harga * $item->kuantitas, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                
                    <tr class="border-t">
                        
                        <td class="py-1 px-2 font-bold" colspan="3">
                            <div class="mt-6">
                                Total Belanja
                            </div>
                        </td>
                        <td class="py-1 px-2 text-right font-bold">
                            <div class="mt-6">
                            Rp {{ number_format(session('orderData.totalHarga'), 0, ',', '.') }}
                            </div>
                        </td>    
                    </tr>
                    <tr>
                        <td class="py-1 px-2 font-bold" colspan="3">Uang Pembayaran</td>
                        <td class="py-1 px-2 text-right font-bold">Rp {{ number_format(session('orderData.uangPembayaran'), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 px-2 font-bold" colspan="3">Kembalian</td>
                        <td class="py-1 px-2 text-right font-bold">Rp {{ number_format(session('orderData.uangPembayaran') - session('orderData.totalHarga'), 0, ',', '.') }}</td>
                    </tr>
                
                </tfoot>
            </table>
        </div>
        <div class="flex justify-between mt-10">
            <a href="#" class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-lg shadow hover:bg-yellow-600 text-sm"><i class="fa-solid fa-print"></i> Print</a>
            <a href="{{ route('homeKasir') }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 text-sm"><i class="fa-solid fa-house"></i> Beranda</a>
        </div>
    </div>
</div>

@endsection
{{-- 
@php
    // Hapus data dari sesi setelah ditampilkan
    session()->forget('orderData');
@endphp --}}
