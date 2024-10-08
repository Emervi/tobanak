@extends('layouts.app')

@section('title', 'Checkout')

@section('body')

    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


<div x-data="{ isOpenAddress: false, isOpenEkspedisi: false }" class="container mt-3 mx-auto px-4">
    <div class=" min-w-full mb-4">
        <h1 class="font-bold text-2xl text-rose-800">Checkout</h1>
    </div>

    <form action="{{ route('customer.prosesCheckout') }}" method="POST" >
        @csrf
        <div class="bg-white p-4 rounded shadow-sm mb-2 border-b border-t border-rose-500">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-red-500 font-semibold ml-4 mb-3 text-xl"><i class="fa-solid fa-location-dot mr-2"></i> Alamat Pengiriman</h1>
                    @if(session('alamat_baru'))
                        <p class="font-semibold">{{ session('alamat_baru')['name'] }} (+62) {{ session('alamat_baru')['no_telp'] }}</p>
                        <p>{{ session('alamat_baru')['alamat'] }}</p>
                        <input type="hidden" name="alamat" value="{{ session('alamat_baru')['alamat'] }}">
                    @else
                        <p class="font-semibold">{{ session('customer')->name }} (+62) {{ session('customer')->no_telp }}</p>
                        <p>{{ session('customer')->alamat }}</p>
                        <input type="hidden" name="alamat" value="{{ session('customer')->alamat }}">
                    @endif
                </div>
                <div>
                    <button @click="isOpenAddress = true" type="button" class="text-red-500 font-semibold hover:text-rose-700">Ubah</button>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded shadow-sm mb-2">
            <h3 class="font-semibold text-lg mb-2">Produk Dipesan</h3>
                @foreach($keranjangs as $keranjang)
                    <div class="flex items-center mb-2 border-b border-gray-100 pb-3">
                        <div class="flex-shrink-0 bg-gray-200 rounded-lg items-center text-center p-2">
                            <img src="{{ asset('images/' . $keranjang->barang->foto_barang) }}" alt="Product Image" class="w-16 h-16 object-cover">
                        </div>
                        <div class="ml-4 flex-grow">
                            <p>{{ $keranjang->barang->nama_barang }}</p>
                            <p class="text-gray-600">Bahan : {{ $keranjang->barang->bahan }}</p>
                            <div class="flex items-center mt-2">
                                @if ($keranjang->barang->diskon > 0)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded mr-2">Diskon {{ $keranjang->barang->diskon }}%</span>
                                @elseif ($keranjang->barang->potongan > 1000)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">Potongan Rp. {{ number_format($keranjang->barang->potongan, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0 mr-8">
                            <p class="text-right">Rp. {{ number_format($keranjang->barang->harga, 0 , ',', '.') }}</p>
                            <p class="text-right">Jumlah: {{ $keranjang->kuantitas }}</p>
                        </div>
                    </div>
                @endforeach
        </div>
    
        <div class="bg-white p-4 rounded shadow-md">
            <div class="flex space-x-4">
                <div class="flex-1 p-3 rounded-lg">
                    <div class="flex flex-col h-full">
                        @php
                            $ekspedisi = $ekspedisis->firstWhere('id_ekspedisi', $selectedEkspedisiId);
                        @endphp
                        <!-- Opsi Pengiriman -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold">Opsi Pengiriman</h4>
                                <button @click="isOpenEkspedisi = true" type="button" class="text-blue-500 font-semibold hover:text-blue-700">Ubah</button>
                            </div>
                            <p id="selected-ekspedisi" class="text-gray-600 mb-2">
                                Nama Ekspedisi : {{ $ekspedisi->nama_ekspedisi ?? 'Pilih pengiriman' }}
                            </p>
                            <p id="selected-ekspedisi" class="text-gray-600 mb-2">
                                Estimasi Diterima :
                                @empty($ekspedisi->estimasi_pengiriman)
                                    Pilih pengiriman
                                @else
                                    @if ($ekspedisi->estimasi_pengiriman > 1)
                                        {{ Carbon::now()->translatedFormat('d') }}
                                        -
                                        {{ Carbon::now()->addDays($ekspedisi->estimasi_pengiriman - 1)->translatedFormat('d F') }}
                                    @else
                                        {{ Carbon::now()->translatedFormat('d F') }}
                                    @endif
                                @endempty
                            </p>
                            <div class="flex justify-between mb-4">
                                <span class="font-semibold">
                                    {{ $ekspedisi->jenis_pengiriman ?? '' }}
                                </span>
                                <span class="font-semibold">
                                    Harga :
                                    @if ($ekspedisi)
                                        {{ number_format($ekspedisi->harga_ekspedisi, 0, ',', '.') }}
                                        <input type="hidden" name="id_ekspedisi" value="{{ $ekspedisi->id_ekspedisi }}">
                                        <input type="hidden" name="harga_ekspedisi" value="{{ $ekspedisi->harga_ekspedisi }}">
                                    @else
                                        <p>Ekspedisi belum dipilih</p>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <hr class="my-4">

                        <!-- Metode Pembayaran -->
                        <h3 class="font-semibold text-lg mb-2">Metode Pembayaran</h3>
                        <div class="flex flex-wrap gap-2">
                            <input type="radio" id="cod" name="metode_pembayaran" class="hidden peer/cod" value="COD">
                            <label for="cod"
                                class="border border-gray-300 text-gray-900 px-4 py-2 rounded cursor-pointer peer-checked/cod:text-rose-500 peer-checked/cod:border peer-checked/cod:border-rose-500">
                                COD
                            </label>

                            <input type="radio" id="transfer" name="metode_pembayaran" class="hidden peer/transfer"
                                value="transfer">
                            <label for="transfer"
                                class="border border-gray-300 text-gray-900 px-4 py-2 rounded cursor-pointer peer-checked/transfer:text-rose-500 peer-checked/transfer:border peer-checked/transfer:border-rose-500">
                                Transfer
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex-none w-80 p-4 rounded-lg relative">
                    <div class="flex flex-col h-full max-h-42">
                        <div class="font-semibold text-xl text-red-500 mb-4">Total Pembayaran</div>
                        <hr class="mb-4">
                        <div class="overflow-x-auto mb-4">
                            <div class="scroll-content">
                                <ul class="space-y-2 max-h-28">
                                    @foreach ($keranjangs as $nota)    
                                        <li class="flex justify-between border-b border-gray-200 pb-2">
                                            <span class="font-semibold">{{ $nota->barang->nama_barang }}</span>
                                            <span>x{{ $nota->kuantitas }}</span>
                                            <span>Rp {{ number_format($nota->barang->harga * $nota->kuantitas, 0, ',', '.') }}</span>
                                        </li>
                                        <input type="hidden" name="barangs[]" value="{{ $nota->barang->id_barang }}">
                                        <input type="hidden" name="kuantitas[]" value="{{ $nota->kuantitas }}">
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold">Total Ongkos Kirim</span>
                            <span class="mr-4">Rp {{ number_format($ekspedisi->harga_ekspedisi ?? '', 0, ',','.') }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="text-right font-semibold text-xl text-red-500">
                            <span>Rp {{ number_format(($totalHarga + ($ekspedisi->harga_ekspedisi ?? 0)), 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="w-full bg-red-500 text-white font-semibold py-3 rounded hover:bg-red-700">Buat Pesanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    


    <div class="text-center mt-4 mb-2 text-gray-500 text-sm">
        Copyright 2024 &copy; Audy Firkah & Janitra Alvito
    </div>





{{-- modals untuk alamat --}}
    <div x-show="isOpenAddress" x-cloak class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <div class="flex justify-between min-w-full">
                <h2 class="text-lg font-semibold mb-4">Alamat Baru</h2>
                <form action="{{ route('reset.alamat') }}" method="POST" id="reset-form">
                    @csrf
                    <button type="submit" class="bg-yellow-400 py-2 px-4 rounded-md text-gray-800 hover:bg-yellow-500"><i class="fa-solid fa-arrows-rotate"></i></button>
                </form>
            </div>
            <form action="{{ route('update.alamat') }}" method="POST" id="address-form">
                @csrf
                <div class="flex justify-between">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full pl-3 pr-8 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" id="no_telp" oninput="formatNomorTelepon(this)" maxlength="14" name="no_telp" class="mt-1 block w-full pl-3 pr-8 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <input type="text" id="alamat" name="alamat" class="mt-1 block w-full px-3 pb-14 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm" placeholder="Kota , Kec, Jl, No.rumah" required>
                </div>

                <div class="flex justify-between text-sm">
                    <button type="button" @click="isOpenAddress = false" class="bg-gray-400 text-white hover:bg-gray-600 px-4 py-2 rounded-lg">Nanti Saja</button>
                        <!-- Form for resetting address -->
                        <button type="submit" form="address-form" class="bg-pink-400 py-2 px-4 rounded-md text-white hover:bg-pink-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="isOpenEkspedisi" x-cloak
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-lg font-semibold mb-4">Pilih Ekspedisi</h2>
            <form action="{{ route('update.ekspedisi') }}" method="POST">
                @csrf
                <!-- Pilihan Ekspedisi -->
                <div class="space-y-4 overflow-x-auto max-h-96">
                    <!-- Ekspedisi Reguler -->
                    @foreach ($ekspedisis as $ekspedisi)
                        <div>
                            {{-- @dd(session('selected_ekspedisi')) --}}
                            <input type="radio" name="id_ekspedisi" id="ekspedisi{{ $ekspedisi->id_ekspedisi }}"
                                value="{{ $ekspedisi->id_ekspedisi }}" class="peer hidden"
                                {{ session('selected_ekspedisi') == $ekspedisi->id_ekspedisi ? 'checked' : '' }}>
                            <label for="ekspedisi{{ $ekspedisi->id_ekspedisi }}"
                                class="flex justify-between items-center border rounded-lg p-3 cursor-pointer peer-checked:bg-gray-300">

                                <div class="flex flex-col">
                                    <p class="font-semibold">{{ $ekspedisi->nama_ekspedisi }}</p>
                                    <p class="font-semibold text-gray-600">{{ $ekspedisi->jenis_pengiriman }}</p>
                                    <p class="text-gray-600">Estimasi Diterima :
                                        @if ($ekspedisi->estimasi_pengiriman > 1)
                                            {{ Carbon::now()->translatedFormat('d') }}
                                            -
                                            {{ Carbon::now()->addDays($ekspedisi->estimasi_pengiriman - 1)->translatedFormat('d F') }}
                                        @else
                                            {{ Carbon::now()->translatedFormat('d F') }}
                                        @endif
                                    </p>
                                </div>
                                <p class="font-semibold">Rp.
                                    {{ number_format($ekspedisi->harga_ekspedisi, 0, ',', '.') }}</p>

                            </label>
                        </div>
                    @endforeach
                </div>
                <!-- Tombol Aksi -->
                <div class="flex justify-between text-sm mt-4">
                    <button type="button" @click="isOpenEkspedisi = false"
                        class="bg-gray-400 text-white hover:bg-gray-600 px-4 py-2 rounded-lg">Nanti Saja</button>
                    <button type="submit"
                        class="bg-pink-400 py-2 px-10 rounded-md text-white hover:bg-pink-700">OK</button>
                </div>
            </form>
        </div>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function selectEkspedisi(namaEkspedisi, hargaEkspedisi, jenis) {}
</script>
<script>
    function formatNomorTelepon(input){
        const digits = input.value.replace(/\D/g, '');
        const terFormat = digits.match(/.{1,4}/g)?.join('-') || '';
        input.value = terFormat;
    }
</script>

@endsection
