@extends('layouts.sidebar')

@section('title', 'Daftar Ekspedisi')

@section('content')

    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    {{-- tombol kembali dan tambah --}}
    <div class="w-11/12 mx-auto mt-10 mb-12">

        <div class="mt-7 w-5/6 mx-auto flex flex-col">

            <div class="flex items-center justify-between">

                {{-- div kosong --}}
                <div></div>

                <a href="{{ route('admin.tambahEkspedisi') }}"
                    class="text-green-500 p-2 bg-white border border-green-500 rounded-md hover:text-white hover:bg-green-600">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah Ekspedisi
                </a>
            </div>

            {{-- fitur pencarian ekspedisi --}}
            <div class="flex justify-between items-center mt-3">

                <form action="{{ route('admin.daftarEkspedisi') }}" method="POST" class="flex gap-3">
                    @csrf

                    {{-- form pencarian ekspedisi --}}
                    <div class="flex gap-1">
                        <button type="submit"
                            class="text-orange-400 py-1.5 px-2 bg-white border border-orange-400 rounded-md hover:text-white hover:bg-orange-400">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" name="keyword_ekspedisi" placeholder="Masukan nama ekspedisi"
                            class="bg-white p-1 shadow rounded-sm focus:outline-none">
                    </div>

                    {{-- tombol untuk mengembalikan pencarian seperti semula --}}
                    <a href="{{ route('admin.daftarEkspedisi') }}"
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

            <div class="container w-full bg-white p-3 shadow-xl mt-5 rounded-xl overflow-visible">

                <h1 class="text-2xl font-bold text-center">Daftar Ekspedisi</h1>

                <div class="overflow-x-auto overflow-y-clip">
                    {{-- table daftar barang --}}
                    <table
                        class="min-w-full h-full w-min bg-white border text-center border-gray-200 mt-3 overflow-visible">
                        <thead class="border border-b-black">
                            <th class="p-2">No</th>
                            <th class="py-1">Nama Ekspedisi</th>
                            <th class="py-1">Jenis Pengiriman</th>
                            <th class="py-1">Harga Ekspedisi</th>
                            <th class="py-1">Estimasi Pengiriman</th>
                            <th class="p-2 w-1/12">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($ekspedisis as $index => $ekspedisi)
                                <tr class="odd:bg-gray-200 hover:bg-gray-300">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ekspedisi->nama_ekspedisi }}</td>
                                    <td>{{ $ekspedisi->jenis_pengiriman }}</td>
                                    <td class="px-2">Rp. {{ number_format($ekspedisi->harga_ekspedisi, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <p>{{ $ekspedisi->estimasi_pengiriman }} hari</p>
                                        @if ($ekspedisi->estimasi_pengiriman > 1)
                                            {{ Carbon::now()->translatedFormat('d F') }}
                                            -
                                            {{ Carbon::now()->addDays($ekspedisi->estimasi_pengiriman - 1)->translatedFormat('d F') }}
                                        @else
                                            {{ Carbon::now()->translatedFormat('d F') }}
                                        @endif
                                    </td>
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
                                                class="origin-top-right p-1 absolute right-0 w-24 shadow-lg bg-gray-400 z-10 {{ $loop->first && $loop->last ? 'rounded-b rounded-tl top-0 w-48' : ($loop->last ? 'bottom-full rounded-t rounded-bl' : 'rounded-b rounded-tl') }}"
                                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button">

                                                <div class="flex gap-1 {{ $loop->first && $loop->last ? '' : 'flex-col' }}" role="none">
                                                    <a href="{{ route('admin.editEkspedisi', [$ekspedisi->id_ekspedisi]) }}"
                                                        class="text-blue-600 p-1.5 bg-white border border-blue-600 rounded-md hover:text-white hover:bg-blue-600 {{ $loop->first && $loop->last ? 'w-1/2' : 'w-full' }}">
                                                        <i class="fas fa-pen mr-1"></i>
                                                        Edit
                                                    </a>

                                                    <form
                                                        action="{{ route('admin.hapusEkspedisi', [$ekspedisi->id_ekspedisi]) }}"
                                                        method="POST" class="{{ $loop->first && $loop->last ? 'w-1/2' : 'w-full' }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button
                                                            class="text-red-600 w-full p-1.5 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600"
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

                            {{-- cek apakah hasil yang dicari ada --}}
                            @if (empty($ekspedisi->nama_ekspedisi))
                                <tr>
                                    <td colspan="9" class="text-center font-bold text-xl p-3">Ekspedisi tidak ditemukan
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
