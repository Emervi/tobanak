@extends('layouts.sidebar')

@section('title', isset($barang) ? 'Update Barang' : 'Tambah Barang')

{{-- Style untuk sistem dropzone --}}
@section('style')
    <style>
        .dropzone {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s ease;
            position: relative;
        }

        .dropzone.dragover {
            border-color: #3490dc;
        }
    </style>
@endsection

@section('content')

    <div class="w-2/3 md:w-3/5 mx-auto mt-10">

        {{-- pengecekan apakah tombol edit dipencet / isset($barang) --}}
        @isset($barang)
            <div class="bg-white shadow-2xl font-medium p-2 mb-10 rounded-lg">

                <h2 class="text-center font-bold text-xl mb-3">Update Barang</h2>

                @foreach ($barang as $atribut)
                    {{-- form untuk pengisian edit barang --}}
                    <form action="{{ route('admin.updateBarang', [$atribut->id_barang]) }}" method="POST"
                        enctype="multipart/form-data" id="barangForm">
                        @csrf
                        @method('put')

                        {{-- input gambar
                        <div class="flex items-center gap-3">

                            <img src="{{ asset('images/' . $atribut->foto_barang) }}" alt="foto barang"
                                class="w-40 h-40 flex-shrink-0 rounded-md">

                            <div class="w-full">
                                <label for="foto_barang" class="block">Foto Barang</label>
                                <input type="file" name="foto_barang" id="foto_barang"
                                    class="bg-gray-300 shadow rounded p-2 w-full">
                            </div>

                        </div> --}}

                        {{-- dropzone image --}}
                        <div class="mb-4 flex justify-between">

                            <div class="w-1/2">
                                <label class="block text-center">Gambar Barang</label>
                                <img src="{{ asset('images/' . $atribut->foto_barang) }}" alt="foto barang"
                                class="h-36 w-auto flex-shrink-0 rounded-md mx-auto">
                            </div>

                            <div class="w-1/2">
                            <label for="image" class="block mb-2 text-center">Gambar Baru</label>
                            <div id="dropzone" class="dropzone flex flex-col items-center gap-2">
                                <span class="block">Klik di sini atau drag & drop gambar</span>
                                <div class="flex gap-3">
                                    <img id="preview" src="" alt="" style="display: none"
                                        class="w-auto h-28 mx-auto mt-3 object-cover">
                                    <div id="file-name" class="mt-3 text-gray-600"></div>
                                </div>
                            </div>
                            <input type="file" name="foto_barang" id="image" class="hidden" accept="image/*">
                            @error('foto_barang')
                                <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                            @enderror
                            </div>

                        </div>

                        {{-- input selain gambar --}}
                        <div class="grid grid-cols-2 gap-3 mt-3">

                            {{-- column 1 --}}
                            <div>
                                <div class="mb-3">
                                    <label for="nama_barang" class="block">Nama Barang</label>
                                    <input type="text" name="nama_barang" id="nama_barang"
                                        value="{{ old('nama_barang', $atribut->nama_barang) }}" placeholder="Masukan nama barang"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('nama_barang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block">Kategori</label>
                                    <select name="kategori_barang"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                        <option value="Kaos" {{ old('kategori_barang', $atribut->kategori_barang) == 'Kaos' ? 'selected' : '' }}>
                                            Kaos</option>
                                        <option value="Kemeja" {{ old('kategori_barang', $atribut->kategori_barang) == 'Kemeja' ? 'selected' : '' }}>
                                            Kemeja</option>
                                        <option value="Jaket" {{ old('kategori_barang', $atribut->kategori_barang) == 'Jaket' ? 'selected' : '' }}>
                                            Jaket</option>
                                        <option value="Gaun" {{ old('kategori_barang', $atribut->kategori_barang) == 'Gaun' ? 'selected' : '' }}>
                                            Gaun</option>
                                        <option value="Celana" {{ old('kategori_barang', $atribut->kategori_barang) == 'Celana' ? 'selected' : '' }}>
                                            Celana</option>
                                        <option value="Rok" {{ old('kategori_barang', $atribut->kategori_barang) == 'Rok' ? 'selected' : '' }}>Rok
                                        </option>
                                        <option value="Topi" {{ old('kategori_barang', $atribut->kategori_barang) == 'Topi' ? 'selected' : '' }}>
                                            Topi</option>
                                        <option value="Sepatu" {{ old('kategori_barang', $atribut->kategori_barang) == 'Sepatu' ? 'selected' : '' }}>
                                            Sepatu</option>
                                        <option value="Sandal" {{ old('kategori_barang', $atribut->kategori_barang) == 'Sandal' ? 'selected' : '' }}>
                                            Sandal</option>
                                        <option value="Aksesoris"
                                            {{ old('kategori_barang', $atribut->kategori_barang) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris
                                        </option>
                                    </select>
                                    @error('kategori_barang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="deskripsi_barang" class="block">Deskripsi Barang</label>
                                    <textarea name="deskripsi_barang" id="deskripsi_barang" placeholder="Masukan deskripsi barang"
                                    class="p-1 shadow rounded-md w-full resize-none h-24 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">{{ old('deskripsi_barang', $atribut->deskripsi_barang) }}</textarea>
                                    @error('deskripsi_barang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- column 2 --}}
                            <div class="ml-5">
                                <div class="mb-3">
                                    <label for="stok_barang" class="block">Stok</label>
                                    <input type="number" name="stok_barang" id="stok_barang"
                                        value="{{ old('stok_barang', $atribut->stok_barang) }}" placeholder="Masukan stok barang"
                                        class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('stok_barang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block">Bahan</label>
                                    <select name="bahan" id="bahan" class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                        <option value="Tebal" {{ old('bahan', $atribut->bahan) == 'Tebal' ? 'selected' : '' }}>Tebal
                                        </option>
                                        <option value="Street" {{ old('bahan', $atribut->bahan) == 'Street' ? 'selected' : '' }}>Street
                                        </option>
                                        <option value="Sedang" {{ old('bahan', $atribut->bahan) == 'Sedang' ? 'selected' : '' }}>Sedang
                                        </option>
                                        <option value="Tipis" {{ old('bahan', $atribut->bahan) == 'Tipis' ? 'selected' : '' }}>Tipis
                                        </option>
                                    </select>
                                    @error('bahan')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-1.5">
                                    <label for="diskon" class="block">Diskon(%)</label>
                                    <input type="number" name="diskon" id="diskon" value="{{ old('diskon', $atribut->diskon) }}"
                                        placeholder="Masukan diskon barang"
                                        class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('diskon')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-1.5">
                                    <label for="potongan" class="block">Potongan(Rp.)</label>
                                    <input type="number" name="potongan" id="potongan" value="{{ old('potongan', $atribut->potongan) }}"
                                        placeholder="Masukan potongan barang"
                                        class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('potongan')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="harga" class="block">Harga</label>
                                    <input type="number" name="harga" id="harga"
                                        value="{{ old('harga', $atribut->harga) }}"
                                        class="bg-gray-300 p-1 shadow rounded-md w-full focus:outline-none" readonly>
                                </div>

                            </div>
                        </div>

                        {{-- footer berisi tombol kembali dan submit --}}
                        <div class="flex justify-between">
                            <a href="{{ route('admin.daftarBarang') }}"
                                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>

                            <div>
                                {{-- <a href="{{ route('admin.resetHarga', [$atribut->id_barang]) }}" class="text-blue-600 p-2 bg-white border border-blue-600 rounded-md hover:text-white hover:bg-blue-600">
                    <i class="fas fa-sync mr-1"></i>
                    Reset Harga
                </a> --}}
                                <button type="submit"
                                    class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
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
            <div class="bg-white shadow-2xl font-medium p-2 mb-10 rounded-lg">

                <h2 class="text-center font-bold text-xl">Tambah Barang</h2>

                {{-- form untuk pengisian input barang --}}
                <form action="{{ route('admin.tambahBarang') }}" method="POST" enctype="multipart/form-data"
                    id="barangForm">
                    @csrf

                    {{-- dropzone image --}}
                    <div class="mb-4">
                        <label for="image" class="block font-bold mb-2">Gambar Barang:</label>
                        <div id="dropzone" class="dropzone flex flex-col items-center gap-2">
                            <span class="block">Klik di sini atau drag & drop gambar</span>
                            <img id="preview" src="" alt="" style="display: none"
                                class="w-auto h-28 mx-auto block mt-3 object-cover">
                            <div id="file-name" class="mt-3 text-gray-600"></div>
                        </div>
                        <input type="file" name="foto_barang" id="image" class="hidden" accept="image/*">
                        @error('foto_barang')
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- input selain gambar --}}
                    <div class="grid grid-cols-2 gap-3 mt-3">

                        {{-- column 1 --}}
                        <div>
                            <div class="mb-3">
                                <label for="nama_barang" class="block">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                                    placeholder="Masukan nama barang"
                                    class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('nama_barang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="block">Kategori</label>
                                <select name="kategori_barang"
                                    class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Kaos" {{ old('kategori_barang') == 'Kaos' ? 'selected' : '' }}>Kaos
                                    </option>
                                    <option value="Kemeja" {{ old('kategori_barang') == 'Kemeja' ? 'selected' : '' }}>Kemeja
                                    </option>
                                    <option value="Jaket" {{ old('kategori_barang') == 'Jaket' ? 'selected' : '' }}>Jaket
                                    </option>
                                    <option value="Gaun" {{ old('kategori_barang') == 'Gaun' ? 'selected' : '' }}>Gaun
                                    </option>
                                    <option value="Celana" {{ old('kategori_barang') == 'Celana' ? 'selected' : '' }}>Celana
                                    </option>
                                    <option value="Rok" {{ old('kategori_barang') == 'Rok' ? 'selected' : '' }}>Rok
                                    </option>
                                    <option value="Topi" {{ old('kategori_barang') == 'Topi' ? 'selected' : '' }}>Topi
                                    </option>
                                    <option value="Sepatu" {{ old('kategori_barang') == 'Sepatu' ? 'selected' : '' }}>Sepatu
                                    </option>
                                    <option value="Sandal" {{ old('kategori_barang') == 'Sandal' ? 'selected' : '' }}>Sandal
                                    </option>
                                    <option value="Aksesoris" {{ old('kategori_barang') == 'Aksesoris' ? 'selected' : '' }}>
                                        Aksesoris</option>
                                </select>
                                @error('kategori_barang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi_barang" class="block">Deskripsi Barang</label>
                                <textarea name="deskripsi_barang" id="deskripsi_barang" placeholder="Masukan deskripsi barang"
                                class="p-1 shadow rounded-md w-full resize-none h-24 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">{{ old('deskripsi_barang') }}</textarea>
                                @error('deskripsi_barang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- column 2 --}}
                        <div class="ml-5">

                            <div class="mb-3">
                                <label for="stok_barang" class="block">Stok</label>
                                <input type="number" name="stok_barang" id="stok_barang" value="{{ old('stok_barang') }}"
                                    placeholder="Masukan stok barang"
                                    class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('stok_barang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="block">Bahan</label>
                                <select name="bahan" id="bahan"
                                    class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    <option value="" disabled selected>Pilih Bahan</option>
                                    <option value="Tebal" {{ old('bahan') == 'Tebal' ? 'selected' : '' }}>Tebal</option>
                                    <option value="Street" {{ old('bahan') == 'Street' ? 'selected' : '' }}>Street</option>
                                    <option value="Sedang" {{ old('bahan') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="Tipis" {{ old('bahan') == 'Tipis' ? 'selected' : '' }}>Tipis</option>
                                </select>
                                @error('bahan')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-1.5">
                                <label for="diskon" class="block">Diskon(%)</label>
                                <input type="number" name="diskon" id="diskon" value="{{ old('diskon') }}"
                                    placeholder="Masukan diskon barang"
                                    class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('diskon')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="potongan" class="block">Potongan(Rp.)</label>
                                <input type="number" name="potongan" id="potongan" value="{{ old('potongan') }}"
                                    placeholder="Masukan potongan barang"
                                    class="p-1 shadow rounded-md w-full focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('potongan')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="harga" class="block">Harga</label>
                                <input type="number" name="harga" id="harga" value="{{ old('harga') }}"
                                    class="bg-gray-300 p-1 shadow rounded-md w-full focus:outline-none" readonly>
                            </div>

                        </div>
                    </div>

                    {{-- footer berisi tombol kembali dan submit --}}
                    <div class="flex justify-between">
                        <a href="{{ route('admin.daftarBarang') }}"
                            class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                            <i class="fas fa-check mr-1"></i>
                            Submit Barang
                        </button>
                    </div>
                </form>
            </div>

        @endisset

    </div>

    {{-- Script dropzone image --}}
    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('image');
        const previewImage = document.getElementById('preview');
        const fileName = document.getElementById('file-name');

        // Load the image from localStorage if it exists
        const storedImage = localStorage.getItem('uploadedImage');
        if (storedImage) {
            previewImage.src = storedImage;
            previewImage.style.display = 'block';
            fileName.textContent = localStorage.getItem('fileName') || '';
        }

        dropzone.addEventListener('click', function() {
            fileInput.click();
        });

        dropzone.addEventListener('dragover', function(event) {
            event.preventDefault();
            event.stopPropagation();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', function(event) {
            event.preventDefault();
            event.stopPropagation();
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', function(event) {
            event.preventDefault();
            event.stopPropagation();
            dropzone.classList.remove('dragover');

            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                updatePreview(files[0]);
            }
        });

        fileInput.addEventListener('change', function(event) {
            const files = event.target.files;
            if (files.length > 0) {
                updatePreview(files[0]);
            }
        });

        function updatePreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                fileName.textContent = file.name;
                localStorage.setItem('uploadedImage', e.target.result);
                localStorage.setItem('fileName', file.name);
            }
            reader.readAsDataURL(file);
        }

        // Clear image and localStorage when form is submitted
        document.getElementById('barangForm').addEventListener('submit', function() {
            localStorage.removeItem('uploadedImage');
            localStorage.removeItem('fileName');
            previewImage.src = '';
            previewImage.style.display = 'none';
            fileName.textContent = '';
        });
    </script>

    {{-- Script untuk format total harga otomatis --}}
    <script>
        function totalHarga() {
            var bahan = document.getElementById('bahan').value
            var diskon = document.getElementById('diskon').value
            var potongan = document.getElementById('potongan').value

            $.ajax({
                url: '{{ route('get.harga') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    bahan: bahan,
                    diskon: diskon,
                    potongan: potongan
                },
                success: function(response) {
                    var harga = parseFloat(response.hargaAkhir);
                    document.getElementById('harga').value = harga;
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }

        document.getElementById('bahan').addEventListener('change', totalHarga);
        document.getElementById('diskon').addEventListener('input', totalHarga);
        document.getElementById('potongan').addEventListener('input', totalHarga);
    </script>
@endsection
