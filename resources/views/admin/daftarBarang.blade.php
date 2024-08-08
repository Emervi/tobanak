@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('body')

    {{-- tombol kembali dan tambah --}}
    <div class="w-11/12 mx-auto mt-10 mb-12">

        <div class="flex items-center justify-between">

            <a href="{{ route('admin.dashboard') }}"
                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>

            <h1 class="text-2xl font-bold ml-10 text-center">Daftar Barang</h1>

            <a href="{{ route('admin.tambahBarang') }}"
                class="text-green-500 p-2 bg-white border border-green-500 rounded-md hover:text-white hover:bg-green-600">
                <i class="fas fa-plus mr-1"></i>
                Tambah Barang
            </a>
        </div>

        <div class="mt-7">
            {{-- notifikasi CRUD barang dan fitur pencarian barang --}}
            <div class="flex justify-between items-center">

                <form action="{{ route('admin.daftarBarang') }}" method="POST" class="flex gap-3">
                    @csrf

                    {{-- form pencarian barang --}}
                    <div class="flex gap-1">
                        <button type="submit"
                            class="text-orange-400 py-1.5 px-2 bg-white border border-orange-400 rounded-md hover:text-white hover:bg-orange-400">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" name="keyword_barang" placeholder="Masukan nama barang"
                            class="bg-white p-1 shadow rounded-sm focus:outline-none">
                    </div>

                    {{-- tombol untuk mengembalikan pencarian seperti semula --}}
                    <a href="{{ route('admin.daftarBarang') }}"
                        class="text-blue-400 py-2 px-2 bg-white border border-blue-400 rounded-md hover:text-white hover:bg-blue-400">
                        <i class="fas fa-sync"></i>
                    </a>

                </form>

                @if (session('success'))
                    <div class="fixed top-4 right-4 bg-green-700 border border-green-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out"
                        role="alert">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ session('success') }}</span>
                            <button
                                onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);"
                                class="ml-4 text-green-500 hover:text-green-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

            </div>

            <div class="container mx-auto bg-white p-3 shadow-xl mt-5">
                <div class="overflow-x-auto">
                    {{-- table daftar barang --}}
                    <table class="min-w-full bg-white border border-gray-200 mt-3">
                        <thead class="border border-b-black text-left">
                            <th class="p-2">No</th>
                            <th class="p-2">Foto barang</th>
                            <th class="p-2">Nama barang</th>
                            <th class="p-2">Stok barang</th>
                            <th class="p-2">Kategori</th>
                            <th class="p-2">Bahan</th>
                            <th class="p-2 w-1/12">Harga</th>
                            <th class="p-2 w-2/6">Deskripsi barang</th>
                            <th class="p-2 w-1/12">Cabang</th>
                            <th class="p-2 w-2/12">Status distribusi</th>
                            <th class="p-2 text-center">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $index => $barang)
                                <tr class="odd:bg-gray-300">
                                    @if ($offset > -1)
                                        <td class="p-3">{{ $offset + $index + 1 }}</td>
                                    @else
                                        <td class="p-3">{{ $index + 1 }}</td>
                                    @endif
                                    <td>
                                        {{-- untuk dihosting gunakan yang ini meureun {{ asset('public/images/' . $barang->foto_barang) }} --}}
                                        <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="foto barang"
                                            class="w-16 h-16 rounded-md p-1">
                                    </td>
                                    <td class="px-2">{{ $barang->nama_barang }}</td>
                                    <td class="px-2">{{ $barang->stok_barang }}</td>
                                    <td class="px-2">{{ $barang->kategori_barang }}</td>
                                    <td class="px-2">{{ $barang->bahan }}</td>
                                    <td class="px-2">Rp. {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                    <td class="px-2">{{ $barang->deskripsi_barang }}</td>
                                    <td class="px-2">{{ $barang->nama_cabang }}</td>
                                    <td class="px-2">
                                        @if ($barang->distribusi === 'Diterima')
                                            ✔Diterima✔
                                        @elseif ($barang->distribusi === 'Ditolak')
                                            💥Ditolak💥
                                        @else
                                            🚚Dikirim🚚
                                        @endif
                                    </td>
                                    <td class="flex justify-evenly items-center mt-4 mx-2 gap-2">
                                        <a href="{{ route('admin.editBarang', [$barang->id_barang]) }}"
                                            class="text-blue-600 w-20 py-1 bg-white border border-blue-600 rounded-md text-center hover:text-white hover:bg-blue-600">
                                            <i class="fas fa-pen mr-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.hapusBarang', [$barang->id_barang]) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button
                                                class="text-red-600 w-20 py-1 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600"
                                                onclick="confirmDelete(event)">
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($offset > -1)
                                {{-- pagination --}}
                                {{ $barangs->links() }}
                            @endif

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
                            @if (empty($barang->nama_barang))
                                <tr>
                                    <td colspan="9" class="text-center font-bold text-xl p-3">Barang tidak ditemukan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

@endsection
