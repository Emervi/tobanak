@extends('layouts.sidebar')

@section('title', 'Distribusi')

@section('content')

    @if (session('success'))
        <div class="z-10 fixed top-4 right-4 bg-green-700 border border-green-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out"
            role="alert">
            <div class="flex items-center justify-between">
                <span class="text-sm">{{ session('success') }}</span>
                <button
                    onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);"
                    class="ml-4 text-green-500 hover:text-green-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @endif
    @if (session('tolak'))
        <div class="z-10 fixed top-4 right-4 bg-red-700 border border-red-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out"
            role="alert">
            <div class="flex items-center justify-between">
                <span class="text-sm">{{ session('tolak') }}</span>
                <button
                    onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);"
                    class="ml-4 text-red-500 hover:text-red-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if ($barangs->isEmpty())
        <div class="text-center max-h-screen mt-72">
            <p class="mt-20 mx- text-gray-400">Tidak ada barang yang masuk <span class="text-2xl">💤</span></p>
        </div>
    @else
        <div class="container mx-auto mt-8">
            <h1 class="text-2xl font-bold mb-6">Distribusi Barang</h1>

            <div class="container mx-auto bg-white p-3 shadow-xl mt-5">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 mt-3">
                        <thead class="border border-b-black text-left">
                            <tr >
                                <th class="">No</th>
                                <th class="p-2">Foto barang</th>
                                <th class="p-2">Nama barang</th>
                                <th class="p-2">Stok barang</th>
                                <th class="p-3">Kategori</th>
                                <th class="p-3">Bahan</th>
                                <th class="w-1/6">Harga</th>
                                <th class="w-1/3">Deskripsi barang</th>
                                <th class="w-1/6">Status distribusi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            @foreach ($barangs as $index => $barang)
                                <tr class="odd:bg-gray-200">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="foto barang"
                                            class="w-16 h-16 flex-shrink-0 rounded-md p-1 lg:md-5">
                                    </td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->stok_barang }}</td>
                                    <td>{{ $barang->kategori_barang }}</td>
                                    <td>{{ $barang->bahan }}</td>
                                    <td>Rp. {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                    <td>{{ $barang->deskripsi_barang }}</td>
                                    <td>
                                        @if ($barang->distribusi === 'Diterima')
                                            ✔Diterima✔
                                        @elseif ($barang->distribusi === 'Ditolak')
                                            💥Ditolak💥
                                        @else
                                            🚚Dikirim🚚
                                        @endif
                                    </td>
                                    <td class="p-2">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('distribusi.updateStatus', $barang->id_barang) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="Diterima">
                                                <button type="submit"
                                                    class="text-green-600 w-20 py-1 bg-white border border-green-600 rounded-md text-center hover:text-white hover:bg-green-600">
                                                    Terima
                                                </button>
                                            </form>
                                            <form action="{{ route('distribusi.updateStatus', $barang->id_barang) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit"
                                                    class="text-red-600 w-20 py-1 bg-white border border-red-600 rounded-md text-center hover:text-white hover:bg-red-600">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif
@endsection
