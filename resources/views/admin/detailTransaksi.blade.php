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

            <div class="container w-10/12 mx-auto bg-white p-3 shadow-xl mt-5 rounded-xl">

                <h1 class="text-2xl font-bold text-center">Detail Barang Transaksi</h1>
                
                <div class="overflow-x-auto">
                    {{-- table daftar barang --}}
                    <table class="min-w-full bg-white border border-gray-200 mt-3">
                        <thead class="border border-b-black text-center">
                            <th class="p-2 w-1/12">No</th>
                            <th class="px-1">Nama Barang</th>
                            <th class="px-1">Kuatitas</th>
                            <th class="px-1">Status Barang</th>
                            <th class="px-1">Total Harga</th>
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
                        </tbody>
                    </table>

                    {{-- @dd($detailTambahan) --}}
                    <div class="p-1 text-sm font-semibold">
                        <p>Total Harga Barang : {{ $detailTambahan->total_harga }}</p>
                        <p>Ekspedisi : 
                            @empty( $detailTambahan->id_ekspedisi )
                                Tidak ada
                            @else
                                {{ $detailTambahan->nama_ekspedisi }} ({{ $detailTambahan->jenis_pengiriman }})
                            @endempty
                        </p>
                        <p>Alamat : 
                            @empty( $detailTambahan->id_ekspedisi )
                                Cabang {{ $detailTambahan->nama_cabang }} (Bayar dikasir)
                            @else
                                {{ $detailTambahan->alamat }}
                            @endempty
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
