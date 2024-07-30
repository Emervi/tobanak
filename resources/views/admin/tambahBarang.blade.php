@extends('layouts.app')

@section('title', (isset($barang) ? 'Update Barang' : 'Tambah Barang'))

@section('body')

{{-- tombol kembali dan tambah --}}
<div class="w-1/2 mx-auto mt-10">

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
                            <option value="kaos" {{ ($atribut->kategori_barang == 'kaos' ? 'selected' : '') }}>Kaos</option>
                            <option value="kemeja" {{ ($atribut->kategori_barang == 'kemeja' ? 'selected' : '') }}>Kemeja</option>
                            <option value="jaket" {{ ($atribut->kategori_barang == 'jaket' ? 'selected' : '') }}>Jaket</option>
                            <option value="sweater" {{ ($atribut->kategori_barang == 'sweater' ? 'selected' : '') }}>Sweater</option>
                            <option value="celana" {{ ($atribut->kategori_barang == 'celana' ? 'selected' : '') }}>Celana</option>
                            <option value="rok" {{ ($atribut->kategori_barang == 'rok' ? 'selected' : '') }}>Rok</option>
                            <option value="topi" {{ ($atribut->kategori_barang == 'topi' ? 'selected' : '') }}>Topi</option>
                            <option value="sepatu" {{ ($atribut->kategori_barang == 'sepatu' ? 'selected' : '') }}>Sepatu</option>
                            <option value="sandal" {{ ($atribut->kategori_barang == 'sandal' ? 'selected' : '') }}>Sandal</option>
                        </select>
                        @error( 'kategori_barang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="block">Bahan</label>
                        <select name="bahan" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                            <option value="tebal" {{ ($atribut->bahan == 'tebal' ? 'selected' : '') }}>Tebal</option>
                            <option value="street" {{ ($atribut->bahan == 'street' ? 'selected' : '') }}>Street</option>
                            <option value="sedang" {{ ($atribut->bahan == 'sedang' ? 'selected' : '') }}>Sedang</option>
                            <option value="tipis" {{ ($atribut->bahan == 'tipis' ? 'selected' : '') }}>Tipis</option>
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
                        <input type="number" name="harga" id="harga" step="0.001" value="{{ $atribut->harga }}" placeholder="Masukan harga barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
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
                        <input type="number" name="potongan" id="potongan" step="0.001" value="{{ $atribut->potongan }}" placeholder="Masukan potongan barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
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
                            <option value="kaos" {{ old('kategori') == 'kaos' ? 'selected' : '' }}>Kaos</option>
                            <option value="kemeja" {{ old('kategori') == 'kemeja' ? 'selected' : '' }}>Kemeja</option>
                            <option value="jaket" {{ old('kategori') == 'jaket' ? 'selected' : '' }}>Jaket</option>
                            <option value="sweater" {{ old('kategori') == 'sweater' ? 'selected' : '' }}>Sweater</option>
                            <option value="celana" {{ old('kategori') == 'celana' ? 'selected' : '' }}>Celana</option>
                            <option value="rok" {{ old('kategori') == 'rok' ? 'selected' : '' }}>Rok</option>
                            <option value="topi" {{ old('kategori') == 'topi' ? 'selected' : '' }}>Topi</option>
                            <option value="sepatu" {{ old('kategori') == 'sepatu' ? 'selected' : '' }}>Sepatu</option>
                            <option value="sandal" {{ old('kategori') == 'sandal' ? 'selected' : '' }}>Sandal</option>
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
                            <option value="tebal" {{ old('bahan') == 'tebal' ? 'selected' : '' }}>Tebal</option>
                            <option value="street" {{ old('bahan') == 'street' ? 'selected' : '' }}>Street</option>
                            <option value="sedang" {{ old('bahan') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tipis" {{ old('bahan') == 'tipis' ? 'selected' : '' }}>Tipis</option>
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
                        <input type="number" name="potongan" id="potongan" step="0.001" value="{{ old('potongan') }}" placeholder="Masukan potongan barang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
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