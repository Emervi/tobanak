@extends('layouts.sidebar')

@section('title', 'Pesanan Pelanggan')

@section('content')

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

            <div class="container mx-auto w-2/3 bg-white p-3 shadow-xl rounded-xl">

                <h1 class="text-2xl font-bold text-center">Pesanan Pelanggan</h1>

                <div class="overflow-x-auto">
                    {{-- table daftar barang --}}
                    <table class="min-w-full bg-white border border-gray-200 mt-3 text-center">
                        <thead class="border border-b-gray-900">
                            <th class="p-2 w-1/12">No</th>
                            <th class="p-2 w-2/12">Nama pelanggan</th>
                            <th class="p-2 w-1/12">Tanggal</th>
                            <th class="p-2 w-2/12">Total harga</th>
                            <th class="p-2 w-2/12">Jumlah barang</th>
                            <th class="p-2 w-1/12">Aksi</th>
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

                                        <div>
                                            <button type="button" id="btnDropdown{{ $index }}"
                                                onclick="dropdownPesanan('dropdownLink{{ $index }}', 'btnDropdown{{ $index }}')"
                                                class="hover:bg-gray-400 px-2 rounded-full p-1">
                                                <i class="fas fa-bars text-xl"></i>
                                            </button>

                                            <div id="dropdownLink{{ $index }}" class="flex-col gap-1 hidden bg-gray-400 p-1 rounded-b rounded-tr absolute">
                                                <a href="{{ route('kasir.detailPesanan', [$pesanan->id_transaksi]) }}"
                                                    class="text-yellow-500 w-full py-1 px-2 bg-white border border-yellow-500 rounded-md text-center hover:text-white hover:bg-yellow-500">
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

    <script>
        function dropdownPesanan(idDropdownLink, idBtnDropdown) {
            const dropdownLink = document.getElementById(idDropdownLink);
            const btnDropdown = document.getElementById(idBtnDropdown);

            btnDropdown.classList.toggle('rounded-b');
            btnDropdown.classList.toggle('bg-gray-400');
            btnDropdown.classList.toggle('px-4');

            dropdownLink.classList.toggle('flex');
            dropdownLink.classList.toggle('hidden');

            if (!dropdownLink.classList.contains('hidden')) {
                dropdownLink.classList.remove('scale-95', 'opacity-0');
                dropdownLink.classList.add('scale-100', 'opacity-100');
            } else {
                dropdownLink.classList.remove('scale-100', 'opacity-100');
                dropdownLink.classList.add('scale-95', 'opacity-0');
            }
        }
    </script>

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
