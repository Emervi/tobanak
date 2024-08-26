@extends('layouts.app')

@section('title', 'Pesanan Pelanggan')

@section('body')

    {{-- tombol kembali --}}
    <div class="w-11/12 mx-auto mt-10 mb-12">

        <div class="mt-7">
            {{-- notifikasi CRUD barang dan fitur pencarian barang --}}
            <div class="flex justify-between items-center">

                @if (session('success'))
                    <div class="fixed top-4 right-4 bg-green-700 border border-green-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out"
                        role="alert">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ session('success') }}</span>
                            <button
                                onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);"
                                class="ml-4 text-green-500 hover:text-green-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

            </div>

            <div class="container mx-auto bg-white p-3 shadow-xl rounded-xl">

                <h1 class="text-2xl font-bold text-center">Pesanan Pelanggan</h1>

                <div class="overflow-x-auto">
                    {{-- table daftar barang --}}
                    <table class="w-11/12 mx-auto bg-white border border-gray-200 mt-3 text-center">
                        <thead class="border border-b-gray-900">
                            <th class="p-2">No</th>
                            <th class="p-2">Nama pelanggan</th>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Total harga</th>
                            <th class="p-2">Jumlah barang</th>
                            <th class="text-center w-1/4">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($pesanans as $index => $pesanan)
                                <tr class="odd:bg-gray-200 hover:bg-gray-300">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pesanan->username }}</td>
                                    <td>{{ $tanggal[$index] }}</td>
                                    <td>Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td>{{ $jumlahBarang[$index] }}</td>
                                    <td class="flex justify-evenly items-center my-3 flex-col gap-2">

                                        <div class="flex flex-col">
                                            <div>
                                            <a href="{{ route('kasir.detailPesanan', [$pesanan->id_transaksi]) }}"
                                                class="text-yellow-500 w-full py-1 bg-white border border-yellow-500 rounded-md text-center hover:text-white hover:bg-yellow-500">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail Pesanan
                                            </a>

                                            <form action="{{ route('kasir.kirimBarang', [$pesanan->id_transaksi]) }}"
                                                method="POST" class="w-full">
                                                @csrf
                                                @method('put')
                                                <button
                                                    class="text-green-600 py-1 w-full bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600"
                                                    id="btnKonfirmasi">
                                                    <i class="fas fa-truck mr-1"></i>
                                                    Konfirmasi
                                                </button>
                                            </form>

                                            <form action="{{ route('kasir.batalBarang', [$pesanan->id_transaksi]) }}"
                                                method="POST" class="w-full">
                                                @csrf
                                                @method('put')
                                                <button
                                                    class="text-red-600 py-1 w-full bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600"
                                                    id="btnBatal">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Batalkan
                                                </button>
                                            </form>

                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            @if (empty($pesanan->id_transaksi))
                                <tr>
                                    <td colspan="9" class="text-center font-bold text-xl p-3">
                                        Tidak ada pesanan
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <script></script>

    {{-- <script>
        let btnKonfirmasi = document.getElementById('btnKonfirmasi');
        let btnBatal = document.getElementById('btnBatal');

        btnKonfirmasi.addEventListener('click', function() {
            if (confirm('Konfirmasi barang?')) {

            } else {
                window.location.href = "{{ route('kasir.daftarPesanan') }}"
            }
        });

        btnBatal.addEventListener('click', function() {
            if (confirm('Batalkan barang?')) {

            } else {
                window.location.href = "{{ route('kasir.daftarPesanan') }}"
            }
        });
    </script> --}}

@endsection
