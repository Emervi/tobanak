@extends('layouts.app')

@section('title', (isset($barang) ? 'Update Barang' : 'Tambah Barang'))

@section('body')

{{-- tombol kembali dan tambah --}}
<div class="w-2/3 md:w-1/2 mx-auto mt-10">

    @isset($barang)
    <div class="bg-white shadow-2xl font-medium p-2 mb-10">

        <h2 class="text-center font-bold text-xl">Update Barang</h2>

        {{-- pengecekan apakah tombol edit dipencet / isset($barang) --}}
        
        
        @foreach ( $barang as $atribut )
            
        {{-- form untuk pengisian edit barang --}}
        <form action="{{ route('admin.updateBarang', [$atribut->id_barang]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            {{-- input gambar --}}
            <div class="flex items-center gap-3">

                <img src="{{ asset('images/' . $atribut->foto_barang) }}" alt="foto barang" class="w-40 h-40 flex-shrink-0 rounded-md">

                <div class="w-full">
                    <label for="foto_barang" class="block">Foto Barang</label>
                    <input type="file" name="foto_barang" id="foto_barang" class="bg-gray-300 shadow rounded p-2 w-full">
                </div>

            </div>

            {{-- input selain gambar --}}
            <div class="grid grid-cols-2 gap-5 mt-3">

                {{-- column 1 --}}
                <div>
                    <div class="mb-3">
                        <label for="nama_barang" class="block">Nama barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ $atribut->nama_barang }}" placeholder="Masukan nama barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'nama_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block">Kategori</label>
                        <select name="kategori_barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                            <option value="Kaos" {{ ($atribut->kategori_barang == 'Kaos' ? 'selected' : '') }}>Kaos</option>
                            <option value="Kemeja" {{ ($atribut->kategori_barang == 'Kemeja' ? 'selected' : '') }}>Kemeja</option>
                            <option value="Jaket" {{ ($atribut->kategori_barang == 'Jaket' ? 'selected' : '') }}>Jaket</option>
                            <option value="Sweater" {{ ($atribut->kategori_barang == 'Sweater' ? 'selected' : '') }}>Sweater</option>
                            <option value="Celana" {{ ($atribut->kategori_barang == 'Celana' ? 'selected' : '') }}>Celana</option>
                            <option value="Rok" {{ ($atribut->kategori_barang == 'Rok' ? 'selected' : '') }}>Rok</option>
                            <option value="Topi" {{ ($atribut->kategori_barang == 'Topi' ? 'selected' : '') }}>Topi</option>
                            <option value="Sepatu" {{ ($atribut->kategori_barang == 'Sepatu' ? 'selected' : '') }}>Sepatu</option>
                            <option value="Sandal" {{ ($atribut->kategori_barang == 'Sandal' ? 'selected' : '') }}>Sandal</option>
                            <option value="Aksesoris" {{ ($atribut->kategori_barang == 'Aksesoris' ? 'selected' : '') }}>Aksesoris</option>
                        </select>
                        @error( 'kategori_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block">Bahan</label>
                        <select name="bahan" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                            <option value="Tebal" {{ ($atribut->bahan == 'Tebal' ? 'selected' : '') }}>Tebal</option>
                            <option value="Street" {{ ($atribut->bahan == 'Street' ? 'selected' : '') }}>Street</option>
                            <option value="Sedang" {{ ($atribut->bahan == 'Sedang' ? 'selected' : '') }}>Sedang</option>
                            <option value="Tipis" {{ ($atribut->bahan == 'Tipis' ? 'selected' : '') }}>Tipis</option>
                        </select>
                        @error( 'bahan' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_barang" class="block">Deskripsi barang</label>
                        <textarea name="deskripsi_barang" id="deskripsi_barang" placeholder="Masukan deskripsi barang" class="bg-gray-300 p-1 shadow rounded-sm w-full resize-none h-24 focus:outline-none">{{ $atribut->deskripsi_barang }}</textarea>
                        @error( 'deskripsi_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- column 2 --}}
                <div>
                    <div class="mb-3">
                        <label for="stok_barang" class="block">Stok barang</label>
                        <input type="number" name="stok_barang" id="stok_barang" value="{{ $atribut->stok_barang }}" placeholder="Masukan stok barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'stok_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="block">Harga</label>
                        <input type="number" name="harga" id="harga" step="0.001" value="{{ $atribut->harga }}" placeholder="Masukan harga barang" class="bg-gray-400 p-1 shadow rounded-sm w-11/12 focus:outline-none" readonly>
                        @error( 'harga' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2.5">
                        <label for="diskon" class="block">Diskon(%)</label>
                        <input type="number" name="diskon" id="diskon" value="{{ $atribut->diskon }}" placeholder="Masukan diskon barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'diskon' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="potongan" class="block">Potongan(Rp.)</label>
                        <input type="number" name="potongan" id="potongan" value="{{ $atribut->potongan }}" placeholder="Masukan potongan barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'potongan' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- footer berisi tombol kembali dan submit --}}
            <div class="flex justify-between">
                <a href="{{ route('admin.daftarBarang') }}" class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali
                </a>

                <div>
                {{-- <a href="{{ route('admin.resetHarga', [$atribut->id_barang]) }}" class="text-blue-600 p-2 bg-white border border-blue-600 rounded-md hover:text-white hover:bg-blue-600">
                    <i class="fas fa-sync mr-1"></i>
                    Reset Harga
                </a> --}}
                <button type="submit" class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                    <i class="fas fa-upload mr-1"></i>
                    Update Barang
                </button>
                </div>

            </div>
        </form>

        @endforeach
        
    </div>
        {{-- jika tidak isset($barang) = false, maka akan ditampilkan form untuk input --}}
        @else

    <div class="bg-white shadow-2xl font-medium p-2 mb-10">

        <h2 class="text-center font-bold text-xl">Tambah Barang</h2>
        {{-- form untuk pengisian input barang --}}
        <form action="{{ route('admin.tambahBarang') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- input gambar --}}
            <div class="flex items-center gap-3">

                <img src="{{ asset('images/noPhoto.jpg') }}" alt="foto barang" class="w-40 h-40 flex-shrink-0 rounded-md">

                <div class="w-full">
                    <label for="foto_barang" class="block">Foto Barang</label>
                    <input type="file" name="foto_barang" id="foto_barang" class="bg-gray-300 shadow rounded p-2 w-full">
                </div>

            </div>

            {{-- input selain gambar --}}
            <div class="grid grid-cols-2 gap-5 mt-3">

                {{-- column 1 --}}
                <div>
                    <div class="mb-3">
                        <label for="nama_barang" class="block">Nama barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" placeholder="Masukan nama barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'nama_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block">Kategori</label>
                        <select name="kategori_barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                            <option value="Kaos" {{ old('kategori') == 'Kaos' ? 'selected' : '' }}>Kaos</option>
                            <option value="Kemeja" {{ old('kategori') == 'Kemeja' ? 'selected' : '' }}>Kemeja</option>
                            <option value="Jaket" {{ old('kategori') == 'Jaket' ? 'selected' : '' }}>Jaket</option>
                            <option value="Sweater" {{ old('kategori') == 'Sweater' ? 'selected' : '' }}>Sweater</option>
                            <option value="Celana" {{ old('kategori') == 'Celana' ? 'selected' : '' }}>Celana</option>
                            <option value="Rok" {{ old('kategori') == 'Rok' ? 'selected' : '' }}>Rok</option>
                            <option value="Topi" {{ old('kategori') == 'Topi' ? 'selected' : '' }}>Topi</option>
                            <option value="Sepatu" {{ old('kategori') == 'Sepatu' ? 'selected' : '' }}>Sepatu</option>
                            <option value="Sandal" {{ old('kategori') == 'Sandal' ? 'selected' : '' }}>Sandal</option>
                            <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                        </select>
                        @error( 'kategori_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_barang" class="block">Deskripsi barang</label>
                        <textarea name="deskripsi_barang" id="deskripsi_barang" placeholder="Masukan deskripsi barang" class="bg-gray-300 p-1 shadow rounded-sm w-full resize-none h-24 focus:outline-none">{{ old('deskripsi_barang') }}</textarea>
                        @error( 'deskripsi_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- column 2 --}}
                <div>
                    <div class="mb-3">
                        <label for="stok_barang" class="block">Stok barang</label>
                        <input type="number" name="stok_barang" id="stok_barang" value="{{ old('stok_barang') }}" placeholder="Masukan stok barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'stok_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block">Bahan</label>
                        <select name="bahan" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                            <option value="Tebal" {{ old('bahan') == 'Tebal' ? 'selected' : '' }}>Tebal</option>
                            <option value="Street" {{ old('bahan') == 'Street' ? 'selected' : '' }}>Street</option>
                            <option value="Sedang" {{ old('bahan') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Tipis" {{ old('bahan') == 'Tipis' ? 'selected' : '' }}>Tipis</option>
                        </select>
                        @error( 'bahan' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="diskon" class="block">Diskon(%)</label>
                        <input type="number" name="diskon" id="diskon" value="{{ old('diskon') }}" placeholder="Masukan diskon barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'diskon' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="potongan" class="block">Potongan(Rp.)</label>
                        <input type="number" name="potongan" id="potongan" value="{{ old('potongan') }}" placeholder="Masukan potongan barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'potongan' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- footer berisi tombol kembali dan submit --}}
            <div class="flex justify-between">
                <a href="{{ route('admin.daftarBarang') }}" class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali
                </a>
                <button type="submit" class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                    <i class="fas fa-check mr-1"></i>
                    Submit Barang
                </button>
            </div>
        </form>

        @endisset
        
    </div>

</div>
@endsection