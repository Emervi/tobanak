@extends('layouts.sidebar')

@section('title', 'Daftar Cabang')

@section('content')

    {{-- tombol kembali dan tambah --}}
    <div class="w-11/12 mx-auto mt-10 mb-12">

        <h1 class="text-2xl font-bold ml-10 text-center">Daftar Cabang</h1>

        <div class="flex items-center justify-between">

            <a href="{{ route('admin.dashboard') }}"
                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>

            <a href="{{ route('admin.tambahCabang') }}"
                class="text-green-500 p-2 bg-white border border-green-500 rounded-md hover:text-white hover:bg-green-600">
                <i class="fas fa-plus mr-1"></i>
                Tambah Cabang
            </a>
        </div>

        <div class="mt-7">
            {{-- fitur pencarian cabang --}}
            <div class="flex justify-between items-center">

                <form action="{{ route('admin.daftarCabang') }}" method="POST" class="flex gap-3">
                    @csrf

                    {{-- form pencarian cabang --}}
                    <div class="flex gap-1">
                        <button type="submit"
                            class="text-orange-400 py-1.5 px-2 bg-white border border-orange-400 rounded-md hover:text-white hover:bg-orange-400">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" name="keyword_cabang" placeholder="Masukan nama cabang"
                            class="bg-white p-1 shadow rounded-sm focus:outline-none">
                    </div>

                    {{-- tombol untuk mengembalikan pencarian seperti semula --}}
                    <a href="{{ route('admin.daftarCabang') }}"
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
                    <table class="min-w-full bg-white border text-center border-gray-200 mt-3">
                        <thead class="border border-b-black">
                            <th class="p-2">No</th>
                            <th>Nama cabang</th>
                            <th>Lokasi Cabang</th>
                            <th>Kota</th>
                            <th>Email</th>
                            <th class="text-center">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($cabangs as $index => $cabang)
                                <tr class="odd:bg-gray-200 hover:bg-gray-300">
                                    @if ($offset > -1)
                                        <td class="p-3">{{ $offset + $index + 1 }}</td>
                                    @else
                                        <td class="p-3">{{ $index + 1 }}</td>
                                    @endif
                                    <td>{{ $cabang->nama_cabang }}</td>
                                    <td>{{ $cabang->lokasi_cabang }}</td>
                                    <td>{{ $cabang->kota_cabang }}</td>
                                    <td>{{ $cabang->email_cabang }}</td>
                                    <td class="flex justify-evenly items-center my-3">
                                        <a href="{{ route('admin.editCabang', [$cabang->id_cabang]) }}"
                                            class="text-blue-600 w-20 py-1 bg-white border border-blue-600 rounded-md text-center hover:text-white hover:bg-blue-600">
                                            <i class="fas fa-pen mr-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.hapusCabang', [$cabang->id_cabang]) }}"
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
                                {{ $cabangs->links() }}
                            @endif

                            {{-- cek apakah hasil yang dicari ada --}}
                            @if (empty($cabang->nama_cabang))
                                <tr>
                                    <td colspan="9" class="text-center font-bold text-xl p-3">Cabang tidak ditemukan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
