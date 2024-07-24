@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('body')

{{-- tombol kembali dan tambah --}}
<div class="w-11/12 mx-auto mt-10">

    <div class="flex justify-between">
        <a href="{{ route('admin.dashboard') }}" class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>
        <a href="{{ route('admin.tambahBarang') }}" class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
            <i class="fas fa-plus"></i>
            Tambah barang
        </a>
    </div>
    
    <div class="mt-7">
    {{-- notifikasi CRUD barang dan fitur pencarian barang --}}
    <div class="flex justify-between items-center">

        <form action="{{ route('admin.daftarBarang') }}" method="POST" class="flex gap-3">
            @csrf

            {{-- form pencarian barang --}}
            <div class="flex gap-1">
            <button type="submit" class="text-orange-400 py-1.5 px-2 bg-white border border-orange-400 rounded-md hover:text-white hover:bg-orange-400">
                <i class="fas fa-search"></i>
            </button>
            <input type="text" name="keyword_barang" placeholder="Masukan nama barang" class="bg-white p-1 shadow rounded-sm focus:outline-none">
            </div>

            {{-- tombol untuk mengembalikan pencarian seperti semula --}}
            <a href="{{ route('admin.daftarBarang') }}" class="text-blue-400 py-2 px-2 bg-white border border-blue-400 rounded-md hover:text-white hover:bg-blue-400">
                <i class="fas fa-sync"></i>
            </a>

        </form>

        @if ( session('success') )
        <div class="bg-green-300 w-1/3 p-1 rounded font-medium">
            <p class="ml-2">{{ session('success') }}</p>
        </div>
        @endif
        
    </div>

    {{-- table daftar barang --}}
    <table class="w-full bg-white border border-gray-200 mt-3">
        <thead class="border border-b-black text-left">
            <th class="p-2">No</th>
            <th>Foto barang</th>
            <th>Nama barang</th>
            <th>Stok barang</th>
            <th>Kategori</th>
            <th>Bahan</th>
            <th>Harga</th>
            <th>Deskripsi barang</th>
            <th class="text-center">Aksi</th>
        </thead>
        <tbody>
            @foreach ( $barangs as $index => $barang )
            <tr class="hover:bg-gray-300">
                <td class="p-3">{{ ++$index }}</td>
                <td>
                    {{-- untuk dihosting gunakan yang ini meureun {{ asset('public/images/' . $barang->foto_barang) }} --}}
                    <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="foto barang" class="w-16 h-16 flex-shrink-0 rounded-md p-1 ml-5">
                </td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->stok_barang }}</td>
                <td>{{ $barang->kategori_barang }}</td>
                <td>{{ $barang->bahan }}</td>
                <td>Rp. {{ $barang->harga }}</td>
                <td>{{ $barang->deskripsi_barang }}</td>
                <td class="flex justify-evenly items-center mt-4">
                    <a href="{{ route('admin.editBarang', [$barang->id_barang]) }}" class="text-blue-600 w-20 py-1 bg-white border border-blue-600 rounded-md text-center hover:text-white hover:bg-blue-600">
                        <i class="fas fa-pen mr-1"></i>
                        Edit
                    </a>
                    <form action="{{ route('admin.hapusBarang', [$barang->id_barang]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="text-red-600 w-20 py-1 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600" onclick="confirm('Apakah anda yakin ingin menghapus barang tersebut?')">
                            <i class="fas fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>    
            @endforeach
            {{-- <tr class="hover:bg-gray-300">
                <td class="p-3">1</td>
                <td>
                    <img src="https://i.pinimg.com/564x/48/49/ba/4849ba2ea6517f805785071120cccc08.jpg" alt="foto barang" class="w-16 h-16 flex-shrink-0 rounded-md p-1 ml-5">
                </td>
                <td>Dress Anak</td>
                <td>200</td>
                <td>Atasan</td>
                <td>Tebal</td>
                <td>Rp. 200.000</td>
                <td>Bahan bagus banget WOY</td>
                <td class="flex justify-evenly my-2">
                    <button class="text-blue-600 w-16 py-1 bg-white border border-blue-600 rounded-md hover:text-white hover:bg-blue-600">Edit</button>
                    <button class="text-red-600 w-16 py-1 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600">Hapus</button>
                </td>
            </tr> --}}
        </tbody>
    </table>
    </div>

</div>

@endsection