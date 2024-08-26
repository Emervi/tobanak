@extends('layouts.app')

@section('title', isset($ekspedisi) ? 'Update Ekspedisi' : 'Tambah Ekspedisi')

@section('body')

    {{-- tombol kembali dan tambah --}}
    <div class="w-2/3 md:w-1/2 mx-auto mt-10">

        @isset($ekspedisi)
            <div class="bg-white shadow-2xl font-medium p-2 mb-10">

                <h2 class="text-center font-bold text-xl">Update Ekspedisi</h2>

                {{-- pengecekan apakah tombol edit dipencet / isset($barang) --}}
                @foreach ($ekspedisi as $atribut)
                    {{-- form untuk pengisian edit barang --}}
                    <form action="{{ route('admin.updateEkspedisi', [$atribut->id_ekspedisi]) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="grid grid-cols-2 gap-5 mt-3">

                            {{-- column 1 --}}
                            <div>

                                <div class="mb-3">
                                    <label for="nama_ekspedisi" class="block">Nama ekspedisi</label>
                                    <input type="text" name="nama_ekspedisi" id="nama_ekspedisi"
                                        value="{{ $atribut->nama_ekspedisi }}" placeholder="Masukan nama ekspedisi"
                                        class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('nama_ekspedisi')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_pengiriman" class="block">Jenis pengiriman</label>
                                    <select name="jenis_pengiriman" id="jenis_pengiriman"
                                        class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                        <option value="" disabled selected>Pilih jenis pengiriman</option>
                                        <option value="Hemat" {{ old('jenis_pengiriman', $atribut->jenis_pengiriman) == 'Hemat' ? 'selected' : '' }}>
                                            Hemat</option>
                                        <option value="Reguler" {{ old('jenis_pengiriman', $atribut->jenis_pengiriman) == 'Reguler' ? 'selected' : '' }}>
                                            Reguler</option>
                                        <option value="Express" {{ old('jenis_pengiriman', $atribut->jenis_pengiriman) == 'Express' ? 'selected' : '' }}>
                                            Express</option>
                                        <option value="Same Day" {{ old('jenis_pengiriman', $atribut->jenis_pengiriman) == 'Same Day' ? 'selected' : '' }}>Same
                                            Day</option>
                                        <option value="Kargo" {{ old('jenis_pengiriman', $atribut->jenis_pengiriman) == 'Kargo' ? 'selected' : '' }}>Kargo
                                        </option>
                                    </select>
                                    @error('jenis_pengiriman')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- column 2 --}}
                            <div>

                                <div class="mb-3">
                                    <label for="estimasi_pengiriman" class="block">Estimasi pengiriman(Hari)</label>
                                    <input type="text" name="estimasi_pengiriman" id="estimasi_pengiriman"
                                        value="{{ $atribut->estimasi_pengiriman }}" placeholder="Masukan estimasi pengiriman"
                                        class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('estimasi_pengiriman')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="harga_ekspedisi" class="block">Harga ekspedisi</label>
                                    <input type="text" name="harga_ekspedisi" id="formatUangEkspedisi"
                                        value="{{ $atribut->harga_ekspedisi }}" placeholder="Masukan harga ekspedisi"
                                        class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    <input type="hidden" name="harga_ekspedisi" id="harga_ekspedisi"
                                        value="{{ $atribut->harga_ekspedisi }}">
                                    @error('harga_ekspedisi')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        {{-- footer berisi tombol kembali dan submit --}}
                        <div class="flex justify-between">
                            <a href="{{ route('admin.daftarEkspedisi') }}"
                                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>

                            <div>
                                <button type="submit"
                                    class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                                    <i class="fas fa-upload mr-1"></i>
                                    Update Ekspedisi
                                </button>
                            </div>

                        </div>
                    </form>
                @endforeach

            </div>
            {{-- jika tidak isset($ekspedisi) = false, maka akan ditampilkan form untuk input --}}
        @else
            <div class="bg-white shadow-2xl font-medium p-2 mb-10">

                <h2 class="text-center font-bold text-xl">Tambah Ekspedisi</h2>
                <form action="{{ route('admin.tambahEkspedisi') }}" method="POST" id="formEkspedisi">
                    @csrf

                    {{-- input selain gambar --}}
                    <div class="grid grid-cols-2 gap-5 mt-3">

                        {{-- column 1 --}}
                        <div>

                            <div class="mb-3">
                                <label for="nama_ekspedisi" class="block">Nama ekspedisi</label>
                                <input type="text" name="nama_ekspedisi" id="nama_ekspedisi"
                                    value="{{ old('nama_ekspedisi') }}" placeholder="Masukan nama ekspedisi"
                                    class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('nama_ekspedisi')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_pengiriman" class="block">Jenis pengiriman</label>
                                <select name="jenis_pengiriman" id="jenis_pengiriman"
                                class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    <option value="" disabled selected>Pilih jenis pengiriman</option>
                                    <option value="Hemat" {{ old('jenis_pengiriman') == 'Hemat' ? 'selected' : '' }}>Hemat
                                    </option>
                                    <option value="Reguler" {{ old('jenis_pengiriman') == 'Reguler' ? 'selected' : '' }}>
                                        Reguler</option>
                                    <option value="Express" {{ old('jenis_pengiriman') == 'Express' ? 'selected' : '' }}>
                                        Express</option>
                                    <option value="Same Day" {{ old('jenis_pengiriman') == 'Same Day' ? 'selected' : '' }}>Same
                                        Day</option>
                                    <option value="Kargo" {{ old('jenis_pengiriman') == 'Kargo' ? 'selected' : '' }}>Kargo
                                    </option>
                                </select>
                                @error('jenis_pengiriman')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- column 2 --}}
                        <div>

                            <div class="mb-3">
                                <label for="estimasi_pengiriman" class="block">Estimasi pengiriman(Hari)</label>
                                <input type="text" name="estimasi_pengiriman" id="estimasi_pengiriman"
                                    value="{{ old('estimasi_pengiriman') }}" placeholder="Masukan estimasi pengiriman"
                                    class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                @error('estimasi_pengiriman')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="harga_ekspedisi" class="block">Harga ekspedisi</label>
                                <input type="text" name="harga_ekspedisi" id="formatUangEkspedisi"
                                    value="{{ old('harga_ekspedisi') }}" placeholder="Masukan harga ekspedisi"
                                    class="p-1 shadow rounded-sm w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                <input type="hidden" name="harga_ekspedisi" id="harga_ekspedisi"
                                    value="{{ old('harga_ekspedisi') }}">
                                @error('harga_ekspedisi')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>

                    {{-- footer berisi tombol kembali dan submit --}}
                    <div class="flex justify-between">
                        <a href="{{ route('admin.daftarEkspedisi') }}"
                            class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                            <i class="fas fa-check mr-1"></i>
                            Submit Ekspedisi
                        </button>
                    </div>
                </form>

            @endisset

        </div>

    </div>

    <script>
        // Format uang untuk halaman keranjang
        const formatUangEkspedisi = document.getElementById('formatUangEkspedisi');
        const hargaEkspedisi = document.getElementById('harga_ekspedisi');

        formatUangEkspedisi.addEventListener('input', function(e) {
            let rawValue = e.target.value.replace(/\D/g, ''); // Simpan nilai asli tanpa format

            // Format angka dan set nilai terformat kembali ke input
            e.target.value = formatNumber(rawValue);

            // Simpan nilai asli ke elemen hidden input
            hargaEkspedisi.value = rawValue;
        });

        formatUangEkspedisi.addEventListener('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter, dan .
            if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode === 65 && (e.ctrlKey || e.metaKey)) ||
                // Allow: Ctrl+C
                (e.keyCode === 67 && (e.ctrlKey || e.metaKey)) ||
                // Allow: Ctrl+V
                (e.keyCode === 86 && (e.ctrlKey || e.metaKey)) ||
                // Allow: Ctrl+X
                (e.keyCode === 88 && (e.ctrlKey || e.metaKey)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // Biarkan event terjadi
                return;
            }

            // Cegah jika bukan angka
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        // Cegah input dengan karakter non-digit saat menempel
        formatUangEkspedisi.addEventListener('paste', function(e) {
            e.preventDefault();
            let pastedData = e.clipboardData.getData('text');
            let formattedData = formatNumber(pastedData.replace(/\D/g, ''));
            formatUangEkspedisi.value = formattedData;
            hargaEkspedisi.value = pastedData.replace(/\D/g, '');
        });

        // Saat form disubmit, pastikan nilai di elemen hidden input disiapkan untuk dikirim
        document.getElementById('formEkspedisi').addEventListener('submit', function() {
            hargaEkspedisi.value = formatUangEkspedisi.value.replace(/\D/g, '');
        });
    </script>

@endsection
