@extends('layouts.sidebar')

@section('title', 'Daftar Transaksi')

@section('content')

    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    {{-- tombol kembali --}}
    <div class="w-full mx-auto mt-10 mb-12">

        <div class="mt-7 w-11/12 mx-auto flex flex-col">
            {{-- notifikasi CRUD barang dan fitur pencarian barang --}}
            <div class="flex justify-between items-center">

                <form action="{{ route('admin.daftarTransaksi') }}" method="POST" class="flex w-2/3 md:w-1/3">
                    @csrf

                    {{-- form pencarian barang --}}
                    <div class="w-full">
                        <button type="submit"
                            class="text-orange-400 py-2 px-2 bg-white border border-orange-400 rounded-md hover:text-white hover:bg-orange-400">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="date" name="keyword_transaksi" placeholder="Masukan tanggal transaksi"
                            class="bg-white p-1 w-4/6 shadow rounded-sm focus:outline-none">

                        {{-- tombol untuk mengembalikan pencarian seperti semula --}}
                        <a href="{{ route('admin.daftarTransaksi') }}"
                            class="text-blue-400 py-2 px-2 bg-white border border-blue-400 rounded-md hover:text-white hover:bg-blue-400">
                            <i class="fas fa-sync"></i>
                        </a>
                    </div>

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

            <div class="container w-full bg-white p-3 shadow-xl mt-5 rounded-xl">

                <h1 class="text-2xl font-bold text-center">Daftar Transaksi</h1>

                <div class="overflow-x-auto overflow-y-clip">
                    {{-- table daftar barang --}}
                    <table class="w-full bg-white border border-gray-200 mt-3 text-center">
                        <thead class="border border-b-black">
                            <th class="p-2">No</th>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Username</th>
                            <th class="p-2">Uang Pembayaran</th>
                            <th class="p-2">Total Harga</th>
                            <th class="p-2">Kembalian</th>
                            <th class="p-2">Cabang</th>
                            <th class="p-2">Metode Pembayaran</th>
                            <th class="p-2">Status</th>
                            <th class="text-center w-1/12">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $index => $transaksi)
                                <tr class="odd:bg-gray-200 hover:bg-gray-300">
                                    @if ($offset > -1)
                                        <td>{{ $offset + $index + 1 }}</td>
                                    @else
                                        <td>{{ $index + 1 }}</td>
                                    @endif
                                    <td>{{ Carbon::parse($transaksi->tanggal)->translatedFormat('l d F Y') }}</td>
                                    <td>{{ $transaksi->username }}</td>
                                    <td>Rp. {{ number_format($transaksi->uang_pembayaran, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                                    <td>
                                        @empty( $transaksi->nama_cabang )
                                            Online
                                        @else
                                            {{ $transaksi->nama_cabang }}
                                        @endempty
                                    </td>
                                    <td>{{ $transaksi->metode_pembayaran }}</td>
                                    <td>{{ $transaksi->status }}</td>
                                    <td class="flex justify-center my-3">

                                        <div x-data="{ dropdown: false, isActive: false }" @click.away="isActive = false"
                                            class="relative inline-block">
                                            <button @click="dropdown = !dropdown; isActive = !isActive"
                                                :class="isActive ?
                                                    'bg-gray-400 {{ $loop->last ? 'rounded-t' : 'rounded-b' }}' :
                                                    ''"
                                                class="hover:bg-gray-400 px-2 rounded-full p-1">
                                                <i class="fas fa-bars text-xl"></i>
                                            </button>

                                            <div x-show="dropdown" @click.away="dropdown = false"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                class="origin-top-right p-1 absolute right-0 w-44 shadow-lg bg-gray-400 z-10 {{ $loop->first && $loop->last ? 'rounded-b rounded-tl top-0 w-64' : ($loop->last ? 'bottom-full rounded-t rounded-bl' : 'rounded-b rounded-tl') }}"
                                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button">

                                                <div class="flex gap-1 {{ $loop->first && $loop->last ? '' : 'flex-col' }}" role="none">
                                                    <a href="{{ route('admin.detailTransaksi', [$transaksi->id_transaksi]) }}"
                                                        class="text-yellow-500 py-1 px-2 bg-white border border-yellow-500 rounded-md text-center hover:text-white hover:bg-yellow-500 {{ $loop->first && $loop->last ? 'w-2/3' : 'w-full' }}">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        Detail Transaksi
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.hapusTransaksi', [$transaksi->id_transaksi]) }}"
                                                        method="POST" class="{{ $loop->first && $loop->last ? 'w-1/3' : 'w-full' }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button
                                                            class="text-red-600 w-full py-1 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600"
                                                            onclick="confirmDelete(event)">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            @if ($offset > -1)
                                {{-- pagination --}}
                                {{ $transaksis->links() }}
                            @endif

                            @if (empty($transaksi->tanggal))
                                <tr>
                                    <td colspan="9" class="text-center font-bold text-xl p-3">Transaksi tidak ditemukan
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

@endsection
