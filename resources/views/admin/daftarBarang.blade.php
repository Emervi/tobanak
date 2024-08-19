@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('body')

    <div x-data="{ isOpenDis: false, isOpenTar: false }" class="w-11/12 mx-auto mt-5 mb-12">

        <h1 class="text-2xl font-bold text-center">Daftar Barang</h1>

        {{-- tombol kembali, tambah, dan distribusi --}}
        <div class="flex items-start justify-between mb-2">

            <a href="{{ route('admin.dashboard') }}"
                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>


            <a href="{{ route('admin.tambahBarang') }}"
                class="text-green-500 text-center p-2 bg-white border border-green-500 rounded-md hover:text-white hover:bg-green-600">
                <i class="fas fa-plus mr-1"></i>
                Tambah Barang
            </a>

        </div>

        {{-- Tombol distribusikan barang dan tarik barang --}}
        <div class="flex justify-end gap-2">

            <button @click="isOpenTar = true"
                class="text-red-500 text-center p-2 bg-white border border-red-500 rounded-md hover:text-white hover:bg-red-600">
                <i class="fas fa-truck mr-1 transform -scale-x-100"></i>
                Tarik barang
            </button>

            <button @click="isOpenDis = true"
                class="text-blue-500 text-center p-2 bg-white border border-blue-500 rounded-md hover:text-white hover:bg-blue-600">
                <i class="fas fa-truck mr-1"></i>
                Distribusikan barang
            </button>

            <!-- Modal distribusi barang -->
            <div x-show="isOpenDis" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

                    {{-- form distribusi barang --}}
                    <form action="{{ route('admin.distribusiBarang') }}" method="POST" id="formDistribusi">
                        @csrf
                        @method('put')

                        <h2 class="text-center text-2xl font-bold mb-6">Distribusikan Barang</h2>

                        <div class="flex justify-between p-2">
                            <button type="button" id="checkSemuaDistribusi" class="bg-green-400 hover:bg-green-500 px-4 py-2 rounded-lg">
                                <i class="fas fa-check-circle"></i>
                                Pilih semua
                            </button>

                            <button type="reset" class="bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded-lg">
                                <i class="fas fa-sync"></i>
                                Reset
                            </button>
                        </div>

                        <ul class="space-y-2 mb-6 max-h-60 overflow-y-auto">

                            @foreach ($barangSiap as $barangReady)
                                <li class="border-b border-gray-200 pb-2">
                                    <div class="flex gap-2 items-center">

                                        <input type="hidden" name="id_barangs[]" value="{{ $barangReady->id_barang }}">

                                        <input type="checkbox" name="checkboxs[{{ $barangReady->id_barang }}]"
                                            id="checkbox{{ $barangReady->id_barang }}" value="1" class="size-4 peer hidden">

                                        <label for="checkbox{{ $barangReady->id_barang }}"
                                            class="flex p-2 gap-3 w-full cursor-pointer peer-checked:bg-gray-300">
                                            <img src="{{ asset('images/' . $barangReady->foto_barang) }}" alt="foto barang"
                                                id="fotoBarang" class="size-20">
                                            <div>
                                                <p>Nama barang : {{ $barangReady->nama_barang }}</p>
                                                <p>Harga : Rp. {{ number_format($barangReady->harga, 0, ',', '.') }}</p>
                                                <p>Status : {{ $barangReady->distribusi }}</p>
                                            </div>
                                        </label>

                                    </div>
                                </li>
                            @endforeach

                            @empty($barangReady)
                                <li class="border-b border-t border-gray-200 p-2 text-center font-bold text-xl">
                                    <p>Tidak ada barang</p>
                                </li>
                            @endempty

                        </ul>

                        <div class="mb-3">
                            <select name="id_cabang" id="id_cabang"
                                class="bg-gray-300 block w-1/3 p-1 shadow rounded-sm focus:outline-none">
                                <option value="" disabled selected>Pilih cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id_cabang }}"
                                        {{ old('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>
                                        {{ $cabang->nama_cabang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_cabang')
                                <p class="text-red-500 font-medium text-sm block">
                                    {{ $message }}</p>
                            @enderror
                            @error('checkboxs')
                                <p class="text-red-500 font-medium text-sm inline-block">
                                    {{ $message }}</p>
                            @enderror

                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="isOpenDis = false"
                                class="bg-gray-500 text-white hover:bg-gray-600 px-4 py-2 rounded-lg">Batal</button>
                            <button type="submit"
                                class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded-lg">Kirim</button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Modal tarik barang -->
            <div x-show="isOpenTar" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

                    {{-- form tarik barang --}}
                    <form action="{{ route('admin.tarikBarang') }}" method="POST" id="formTarik">
                        @csrf
                        @method('put')

                        <h2 class="text-center text-2xl font-bold mb-6">Tarik Barang</h2>

                        <div class="flex justify-between p-2">
                            <button type="button" id="checkSemuaTarik" class="bg-green-400 hover:bg-green-500 px-4 py-2 rounded-lg">
                                <i class="fas fa-check-circle"></i>
                                Pilih semua
                            </button>

                            <button type="reset" class="bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded-lg">
                                <i class="fas fa-sync"></i>
                                Reset
                            </button>
                        </div>

                        <ul class="space-y-2 mb-6 max-h-80 overflow-y-auto">

                            @foreach ($barangTerproses as $barangProses)
                                <li class="border-b border-gray-200 pb-2">
                                    <div class="flex gap-2 items-center">

                                        <input type="hidden" name="id_barangs[]" value="{{ $barangProses->id_barang }}">

                                        <input type="checkbox" name="checkboxs[{{ $barangProses->id_barang }}]"
                                            id="checkbox{{ $barangProses->id_barang }}" value="1"
                                            class="size-4 peer hidden">

                                        <label for="checkbox{{ $barangProses->id_barang }}"
                                            class="flex p-2 gap-3 w-full cursor-pointer peer-checked:bg-gray-300">
                                            <img src="{{ asset('images/' . $barangProses->foto_barang) }}" alt="foto barang"
                                                id="fotoBarang" class="size-20">
                                            <div>
                                                <p>Nama barang : {{ $barangProses->nama_barang }}</p>
                                                <p>Cabang : {{ $barangProses->nama_cabang }}</p>
                                                <p>
                                                    Status : 
                                                    @if ($barangProses->distribusi === 'Diterima')
                                                        ✔{{ $barangProses->distribusi }}✔
                                                    @elseif ($barangProses->distribusi === 'Ditolak')
                                                        💥{{ $barangProses->distribusi }}💥
                                                    @elseif ($barangProses->distribusi === 'Dikirim')
                                                        🚚{{ $barangProses->distribusi }}🚚
                                                    @else
                                                        👍{{ $barangProses->distribusi }}👍
                                                    @endif
                                                </p>
                                            </div>
                                        </label>

                                    </div>
                                </li>
                            @endforeach

                            @empty($barangProses)
                                <li class="border-b border-t border-gray-200 p-2 text-center font-bold text-xl">
                                    <p>Tidak ada barang</p>
                                </li>
                            @endempty

                        </ul>

                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="isOpenTar = false"
                                class="bg-gray-500 text-white hover:bg-gray-600 px-4 py-2 rounded-lg">Batal</button>
                            <button type="submit"
                                class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-lg">Tarik</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        {{-- container table --}}
        <div class="mt-7">
            {{-- fitur pencarian barang --}}
            <div class="flex justify-between items-center">

                @empty(request('filter_distribusi'))
                    <div>
                        {{-- form pencarian barang --}}
                        <form action="{{ route('admin.daftarBarang') }}" method="POST" class="flex gap-3">
                            @csrf

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
                        @error('keyword_barang')
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    <div>

                    </div>
                @endempty

                {{-- Notifikasi berhasil --}}
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

                {{-- Filter barang menggunakan status distribusi --}}
                <div>
                    <form method="GET" action="{{ route('admin.daftarBarang') }}">
                        <select name="filter_distribusi"
                            class="bg-white text-gray-700 py-2 px-3 shadow border border-gray-200 rounded"
                            onchange="this.form.submit()">
                            <option value="">Semua barang</option>
                            <option value="Siap kirim"
                                {{ request('filter_distribusi') == 'Siap kirim' ? 'selected' : '' }}>
                                Siap kirim</option>
                            <option value="Dikirim" {{ request('filter_distribusi') == 'Dikirim' ? 'selected' : '' }}>
                                Dikirim</option>
                            <option value="Diterima" {{ request('filter_distribusi') == 'Diterima' ? 'selected' : '' }}>
                                Diterima</option>
                            <option value="Ditolak" {{ request('filter_distribusi') == 'Ditolak' ? 'selected' : '' }}>
                                Ditolak</option>
                        </select>
                    </form>
                </div>

            </div>

            <div class="container mx-auto bg-white p-3 shadow-xl mt-5">
                <div class="overflow-x-auto">

                    <h2 class="text-center font-bold text-2xl">
                        {{ request('filter_distribusi') ? request('filter_distribusi') : 'Semua barang' }}
                    </h2>
                    {{-- table daftar barang --}}
                    <table class="min-w-full bg-white border border-gray-200 mt-3">
                        <thead class="border border-b-black ">
                            <th class="p-2">No</th>
                            <th class="p-2">Foto barang</th>
                            <th class="p-2">Nama barang</th>
                            <th class="p-2">Stok barang</th>
                            <th class="p-2">Kategori</th>
                            <th class="p-2">Bahan</th>
                            <th class="p-2 w-1/12">Harga</th>
                            <th class="p-2 w-2/6">Deskripsi barang</th>
                            <th class="p-2 w-1/12">Cabang</th>
                            <th class="p-2 w-2/12 text-center">Status distribusi</th>
                            <th class="p-2 text-center">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $index => $barang)
                                <tr class="odd:bg-gray-200 hover:bg-gray-300">
                                    <td class="p-3">
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        {{-- untuk dihosting gunakan yang ini meureun {{ asset('public/images/' . $barang->foto_barang) }} --}}
                                        <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="foto barang"
                                            class="size-16 rounded-md p-1">
                                    </td>
                                    <td class="px-2">{{ $barang->nama_barang }}</td>
                                    <td class="px-2">{{ $barang->stok_barang }}</td>
                                    <td class="px-2">{{ $barang->kategori_barang }}</td>
                                    <td class="px-2">{{ $barang->bahan }}</td>
                                    <td class="px-2">Rp. {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                    <td class="px-2">{{ $barang->deskripsi_barang }}</td>
                                    <td class="px-2">
                                        @empty($barang->nama_cabang)
                                            Tidak ada
                                        @else
                                            {{ $barang->nama_cabang }}
                                        @endempty
                                    </td>
                                    <td class="px-2 text-center">
                                        @if ($barang->distribusi === 'Diterima')
                                            ✔{{ $barang->distribusi }}✔
                                        @elseif ($barang->distribusi === 'Ditolak')
                                            💥{{ $barang->distribusi }}💥
                                        @elseif ($barang->distribusi === 'Dikirim')
                                            🚚{{ $barang->distribusi }}🚚
                                        @else
                                            👍{{ $barang->distribusi }}👍
                                        @endif
                                    </td>
                                    <td class="flex justify-evenly items-center mt-4 mx-2 gap-2">

                                        {{-- Tombol edit --}}
                                        <a href="{{ route('admin.editBarang', [$barang->id_barang]) }}"
                                            class="text-blue-600 w-20 py-1 bg-white border border-blue-600 rounded-md text-center hover:text-white hover:bg-blue-600">
                                            <i class="fas fa-pen mr-1"></i>
                                            Edit
                                        </a>

                                        {{-- Tombol hapus --}}
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

                            {{-- Tanda jika tidak ada barang yang ditemukan --}}
                            @empty($barang->nama_barang)
                                <tr>
                                    <td colspan="11" class="text-center font-bold text-xl p-3">Barang tidak ditemukan
                                    </td>
                                </tr>
                            @endempty

                        </tbody>
                    </table>

                    {{-- Total stok barang --}}
                    @empty(request('filter_distribusi'))
                        <div class="w-full flex justify-between items-center p-2 font-bold">

                            <div>

                            </div>

                            <div>
                                <p class="font-bold">Total stok barang : {{ $totalStok }}</p>
                            </div>

                        </div>
                    @endempty

                </div>
            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {

          $('#checkSemuaDistribusi').on('click', function() {
            $('#formDistribusi input[type="checkbox"]').prop('checked', true);
          });

          $('#checkSemuaTarik').on('click', function() {
            $('#formTarik input[type="checkbox"]').prop('checked', true);
          });

        });
      </script>

@endsection
