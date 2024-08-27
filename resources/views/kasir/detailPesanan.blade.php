@extends('layouts.sidebar')

@section('title', 'Detail Pesanan')

@section('content')

    <div class="mt-8">

        {{-- container --}}
        <div class="bg-white w-2/3 p-3 mx-auto rounded">

            {{-- bagian atas container --}}
            <div class="flex justify-between mb-5 w-full mx-auto">
                <a href="{{ route('kasir.daftarPesanan') }}"
                    class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>

                <h1 class="text-2xl font-bold text-center">Pesanan Pelanggan</h1>

                <div class="hidden md:block md:w-1/12"></div>
            </div>

            {{-- bagian tengah container --}}
            <div class=" grid grid-cols-3 gap-3 h-min">

                <div class="p-3 font-medium text-sm bg-gray-100 rounded-md shadow-lg h-min min-h-24 overflow-clip">
                    <p>Nama pelanggan : {{ $dataTambahan->username }}</p>
                    <p>Metode pembayaran : {{ $dataTambahan->metode_pembayaran }}</p>
                    <p>Alamat tujuan : {{ $dataTambahan->alamat }}</p>

                    <div class="mt-3 border-t border-gray-400">
                        <p class="text-sm text-gray-500">Konfirmasi sebelum tanggal : {{ $batasKirim }}</p>
                    </div>

                </div>

                <div class="overflow-y-auto min-h-52 max-h-96 col-span-2">
                    @foreach ($detailPesanan as $index => $detail)
                        <div class="relative items-center bg-gray-100 p-3 rounded-lg shadow-lg mx-auto mb-5">
                            <div class="flex flex-col md:flex-row md:justify-between mb-3">
                                <div>
                                    <p class="text-sm font-semibold">
                                        <i class="fas fa-truck"></i>
                                        Pesanan sedang dikemas |
                                        <span class="text-base font-bold">{{ $detail->status }}</span>
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex flex-col md:flex-row justify-between items-center border-t border-gray-400 pt-3">
                                <div class="flex w-full md:w-2/3 gap-2 mb-3">
                                    <img src="{{ asset('images/' . $detail->foto_barang) }}" alt="foto barang"
                                        class="w-28 h-28 object-cover rounded-lg">
                                    <div class="">
                                        <h2 class="text-lg font-semibold">{{ $detail->nama_barang }}</h2>
                                        <p class="text-sm">Bahan : {{ $detail->bahan }}</p>
                                        <p class="text-sm">x{{ $detail->kuantitas }}</p>
                                    </div>
                                </div>

                                <div class="w-full md:w-1/3 flex flex-col items-end gap-3">
                                    <div class="flex flex-col items-end">
                                        <span class="text-sm font-semibold line-through text-gray-400">
                                            Rp. {{ number_format($hargaAwalFinal[$index], 0, ',', '.') }}
                                        </span>
                                        <span class="text-sm font-semibold">
                                            Rp. {{ number_format($detail->harga, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="flex flex-col items-end">
                                        <span>Total Pesanan :</span>
                                        <span class="text-rose-500 text-xl font-semibold">Rp.
                                            {{ number_format($detail->total_harga_barang, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>

        </div>
    </div>
@endsection
