@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('body')

{{-- tombol kembali --}}
<div class="w-11/12 mx-auto mt-10 mb-12">

    <div class="flex justify-start">
        <a href="{{ route('admin.dashboard') }}" class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>
    </div>
    
    <div class="mt-7">
    {{-- notifikasi CRUD barang dan fitur pencarian barang --}}
    <div class="flex justify-between items-center">

        <form action="{{ route('admin.daftarTransaksi') }}" method="POST" class="flex gap-3 w-1/3">
            @csrf

            {{-- form pencarian barang --}}
            <div class=" w-2/3 gap-1">
            <button type="submit" class="text-orange-400 py-2 px-2 bg-white border border-orange-400 rounded-md hover:text-white hover:bg-orange-400">
                <i class="fas fa-search"></i>
            </button>
            <input type="date" name="keyword_transaksi" placeholder="Masukan tanggal transaksi" class="bg-white p-1 w-5/6 shadow rounded-sm focus:outline-none">
            </div>

            {{-- tombol untuk mengembalikan pencarian seperti semula --}}
            <a href="{{ route('admin.daftarTransaksi') }}" class="text-blue-400 py-2 px-2 bg-white border border-blue-400 rounded-md hover:text-white hover:bg-blue-400">
                <i class="fas fa-sync"></i>
            </a>

        </form>

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
        
    </div>

    {{-- table daftar barang --}}
    <table class="w-full bg-white border border-gray-200 mt-3">
        <thead class="border border-b-black text-left">
            <th class="p-2">No</th>
            <th>Tanggal</th>
            <th>Nama user</th>
            <th>Nama barang</th>
            <th>Kuantitas</th>
            <th>Total harga</th>
            <th>Uang pembayaran</th>
            <th>Kembalian</th>
            <th class="text-center w-1/6">Aksi</th>
        </thead>
        <tbody>
            @foreach ( $transaksis as $index => $transaksi )
            <tr class="hover:bg-gray-300">
                <td class="p-3">{{ ++$index }}</td>
                <td>{{ $transaksi->tanggal }}</td>
                <td>{{ $transaksi->name }}</td>
                <td>{{ $transaksi->nama_barang }}</td>
                <td>{{ $transaksi->kuantitas }}</td>
                <td>{{ $transaksi->total_harga }}</td>
                <td>{{ $transaksi->uang_pembayaran }}</td>
                <td>{{ $transaksi->kembalian }}</td>
                <td class="flex justify-evenly items-center my-2">
                    {{-- <a href="{{ route('admin.editUser', [$transaksi->id_transaksi]) }}" class="text-blue-600 w-20 py-1 bg-white border border-blue-600 rounded-md text-center hover:text-white hover:bg-blue-600">
                        <i class="fas fa-pen mr-1"></i>
                        Edit
                    </a> --}}
                    <form action="{{ route('admin.hapusTransaksi', [$transaksi->id_transaksi]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="text-red-600 w-20 py-1 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600" onclick="confirm('Apakah anda yakin ingin menghapus transaksi tersebut?')">
                            <i class="fas fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>    
            @endforeach
            @if ( empty($transaksi->tanggal) )
            <tr>
                <td colspan="9" class="text-center font-bold text-xl p-3">Transaksi tidak ditemukan</td>
            </tr>                
            @endif
        </tbody>
    </table>
    </div>

</div>

@endsection