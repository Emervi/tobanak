@extends('layouts.sidebar')

@section('title', 'Daftar Transaksi')

@section('content')

    {{-- tombol kembali --}}
    <div class="w-11/12 mx-auto mt-10 mb-12">

        <div class="flex justify-start">
            <a href="{{ route('admin.daftarTransaksi') }}"
                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>

        <div class="mt-7">
            <div class="container w-2/3 mx-auto bg-white p-3 shadow-xl mt-5 rounded-xl">

                <h1 class="text-2xl font-bold text-center">Detail Barang Transaksi</h1>
                
                <div class="overflow-x-auto">
                    {{-- table daftar barang --}}
                    <table class="min-w-full bg-white border border-gray-200 mt-3">
                        <thead class="border border-b-black text-center">
                            <th class="p-2 w-1/12">No</th>
                            @foreach ( $columnBarangTransaksis as $th )
                            <th class="px-1 w-2/12">{{ $th }}</th>                                
                            @endforeach
                        </thead>
                        <tbody>
                            @foreach ($detailTransaksi as $index => $transaksi)
                                <tr class="odd:bg-gray-200 text-center">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td>{{ $transaksi->nama_barang }}</td>
                                    <td>{{ $transaksi->kuantitas }}</td>
                                    <td>{{ $transaksi->status_barang }}</td>
                                    <td>Rp. {{ number_format($transaksi->total_harga_barang, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="text-center border border-t-gray-300">
                                <td colspan="4"></td>
                                <td class="font-bold p-2">Total : Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
