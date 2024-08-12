@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('body')

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
            <div class="container mx-auto bg-white p-3 shadow-xl mt-5">
                <div class="overflow-x-auto">
                    {{-- table daftar barang --}}
                    <table class="w-full bg-white border border-gray-200 mt-3">
                        <thead class="border border-b-black text-center">
                            <th class="p-2">No</th>
                            <th>Nama barang</th>
                            <th>Kuantitas</th>
                            <th class="w-1/4">Total harga barang</th>
                            {{-- <th class="text-center w-1/4">Aksi</th> --}}
                        </thead>
                        <tbody>
                            @foreach ($detailTransaksi as $index => $transaksi)
                                <tr class="odd:bg-gray-200 text-center">
                                    <td class="p-3">{{ $index + 1 }}</td>
                                    <td>{{ $transaksi->nama_barang }}</td>
                                    <td>{{ $transaksi->kuantitas }}</td>
                                    <td>Rp. {{ number_format($transaksi->total_harga_barang, 0, ',', '.') }}</td>
                                    {{-- <td class="flex justify-evenly items-center my-2">
                    <a href="{{ route('admin.editUser', [$transaksi->id_transaksi]) }}" class="text-yellow-500 w-40 py-1 bg-white border border-yellow-500 rounded-md text-center hover:text-white hover:bg-yellow-500">
                        <i class="fas fa-eye mr-1"></i>
                        Detail Transaksi
                    </a>
                    <form action="{{ route('admin.hapusTransaksi', [$transaksi->id_transaksi]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button class="text-red-600 w-20 py-1 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600" onclick="confirmDelete(event)">
                            <i class="fas fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </form>
                </td> --}}
                                </tr>
                            @endforeach
                            <tr class="text-center border border-t-gray-300">
                                <td colspan="3"></td>
                                <td class="font-bold p-2">Total : Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
