@extends('layouts.sidebar')

@section('title', isset($cabang) ? 'Update Cabang' : 'Tambah Cabang')

@section('content')

    {{-- tombol kembali dan tambah --}}
    <div class="w-2/3 md:w-3/5 mx-auto mt-10">

        @isset($cabang)
            <div class="bg-white shadow-2xl font-medium p-2 mb-10 rounded-lg">

                <h2 class="text-center font-bold text-xl">Update Cabang</h2>

                {{-- pengecekan apakah tombol edit dipencet / isset($barang) --}}


                @foreach ($cabang as $atribut)
                    {{-- form untuk pengisian edit barang --}}
                    <form action="{{ route('admin.updateCabang', [$atribut->id_cabang]) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="grid grid-cols-2 gap-3 mt-3">

                            {{-- column 1 --}}
                            <div>
                                <div class="mb-3">
                                    <label for="nama_cabang" class="block">Nama Cabang</label>
                                    <input type="text" name="nama_cabang" id="nama_cabang" value="{{ $atribut->nama_cabang }}"
                                        placeholder="Masukan nama cabang"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('nama_cabang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email_cabang" class="block">Email Cabang</label>
                                    <input type="email" name="email_cabang" id="email_cabang"
                                        value="{{ $atribut->email_cabang }}" placeholder="Masukan email cabang"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('email_cabang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- column 2 --}}
                            <div>
                                <div class="mb-3">
                                    <label for="kota_cabang" class="block">Kota Cabang</label>
                                    <input type="text" name="kota_cabang" id="kota_cabang"
                                        value="{{ $atribut->kota_cabang }}" placeholder="Masukan kota cabang"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('kota_cabang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="lokasi_cabang" class="block">Lokasi Cabang</label>
                                    <textarea name="lokasi_cabang" id="lokasi_cabang" placeholder="Masukan lokasi cabang"
                                    class="p-1 shadow rounded-md w-full resize-none h-24 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">{{ $atribut->lokasi_cabang }}</textarea>
                                    @error('lokasi_cabang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        {{-- footer berisi tombol kembali dan submit --}}
                        <div class="flex justify-between">
                            <a href="{{ route('admin.daftarCabang') }}"
                                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>

                            <div>
                                <button type="submit"
                                    class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                                    <i class="fas fa-upload mr-1"></i>
                                    Update Cabang
                                </button>
                            </div>

                        </div>
                    </form>
                @endforeach

            </div>
            {{-- jika tidak isset($barang) = false, maka akan ditampilkan form untuk input --}}
        @else
            <div class="bg-white shadow-2xl font-medium p-2 mb-10 rounded-lg">

                <h2 class="text-center font-bold text-xl">Tambah Cabang</h2>
                <form action="{{ route('admin.tambahCabang') }}" method="POST">
                    @csrf

                    {{-- input selain gambar --}}
                    <div class="grid grid-cols-2 gap-3 mt-3">

                        {{-- column 1 --}}
                        <div>
                            <div class="mb-3">
                                <label for="nama_cabang" class="block">Nama Cabang</label>
                                <input type="text" name="nama_cabang" id="nama_cabang" value="{{ old('nama_cabang') }}"
                                    placeholder="Masukan nama cabang"
                                    class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('nama_cabang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email_cabang" class="block">Email Cabang</label>
                                <input type="email" name="email_cabang" id="email_cabang" value="{{ old('email_cabang') }}"
                                    placeholder="Masukan email cabang"
                                    class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('email_cabang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- column 2 --}}
                        <div>
                            <div class="mb-3">
                                <label for="kota_cabang" class="block">Kota Cabang</label>
                                <input type="text" name="kota_cabang" id="kota_cabang" value="{{ old('kota_cabang') }}"
                                    placeholder="Masukan kota cabang"
                                    class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('kota_cabang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="lokasi_cabang" class="block">Lokasi Cabang</label>
                                <textarea name="lokasi_cabang" id="lokasi_cabang" placeholder="Masukan lokasi cabang"
                                    class="p-1 shadow rounded-md w-full resize-none h-24 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">{{ old('lokasi_cabang') }}</textarea>
                                @error('lokasi_cabang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- footer berisi tombol kembali dan submit --}}
                    <div class="flex justify-between">
                        <a href="{{ route('admin.daftarCabang') }}"
                            class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                            <i class="fas fa-check mr-1"></i>
                            Submit Cabang
                        </button>
                    </div>
                </form>

            @endisset

        </div>

    </div>
@endsection
