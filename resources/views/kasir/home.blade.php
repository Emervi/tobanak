@extends('layouts.app')

@section('title', 'Home')

@section('body')

@if(session('success'))
    <div class="z-10 fixed top-4 right-4 bg-green-700 border border-green-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out" role="alert">
        <div class="flex items-center justify-between">
            <span class="text-sm">{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);" class="ml-4 text-green-500 hover:text-green-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

<div class="mb-4">
    <h1 class="text-xl font-bold m-3">Selamat Datang di {{ $cabangs->nama_cabang }}!!</h1>
    <form method="GET" action="{{ route('homeKasir') }}">
        <select name="filter" class="ml-10 block bg-white text-gray-700 py-2 px-10 shadow-md border border-gray-200 rounded" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $category)
                <option value="{{ $category }}" {{ request('filter') == $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
    @foreach($barangs as $barang)
    <div class="flex flex-col items-center bg-white pt-5 rounded-lg shadow-sm">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden relative">
            @if($barang->diskon || $barang->potongan > 0)
                <div class="absolute top-2 right-2 bg-red-600 text-white text-sm font-bold px-3 py-1 transform rotate-[-30deg] translate-x-2 translate-y-2">
                    @if ($barang->diskon)
                        {{ $barang->diskon }}% OFF
                    @else
                        {{ "- Rp.". number_format($barang->potongan, 0) }}
                    @endif
                </div>
            @endif

            <a href="{{ route('detailProduk', ['id_barang' => $barang->id_barang]) }}">
                <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="Foto Barang" class="w-64 h-48 object-cover">
            </a>
        </div>
        <div class="w-64 p-4 flex flex-col items-start">
            <h2 class="text-xl font-bold">{{ $barang->nama_barang }}</h2>
            <p class="text-gray-600 mt-2 stok-barang" data-id="{{ $barang->id_barang }}">Stok: {{ $barang->stok_barang }}</p>
            <div class="mt-2 flex justify-between w-full items-center">
                @if($barang->diskon || $barang->potongan)
                    <div class="flex flex-col">
                        <span class="text-red-500 font-bold line-through">Rp {{ number_format($barang->harga_asli, 0, ',', '.') }}</span>
                        <span class="text-gray-600 font-bold text-lg">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                    </div>
                @else
                    <span class="text-gray-600 font-bold text-lg">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                @endif

                <form class="add-form-keranjang" action="{{ route('keranjang.tambah') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                    <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded-full hover:bg-blue-700 add-button" data-id="{{ $barang->id_barang }}" {{ $barang->stok_barang <= 0 ? 'disabled' : '' }}>
                        +
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <a href="{{ route('keranjang') }}" class="bg-white m-5 fixed bottom-5 right-1 border border-green-500 text-green-500 p-3 rounded-full shadow-lg hover:bg-green-500 hover:text-white">
        <i class="fas fa-shopping-cart text-2xl"></i>
        <span class="absolute top-0 right-0 bg-green-700 text-white rounded-full px-2 py-1 text-xs font-bold">{{ $totalJumlah > 0 ? $totalJumlah : '0' }}</span>
    </a>
    
    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fungsi untuk memperbarui tombol dan span
        function updateUI() {
            $('.stok-barang').each(function() {
                var stok = parseInt($(this).text().replace('Stok: ', ''));
                var button = $(this).closest('.flex').find('button.add-button');
                
                if (stok <= 0) {
                    button.removeClass('bg-blue-400 hover:bg-blue-700').addClass('bg-gray-400').prop('disabled', true);
                } else {
                    button.prop('disabled', false).removeClass('bg-gray-400').addClass('bg-blue-400');
                }
            });
        }

        $(".add-form-keranjang").on('submit', function(event) {
            event.preventDefault();

            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                success: function(response) {
                    if (response.success) {
                        var totalJumlah = response.totalJumlah;
                        var stokBaru = response.stok_barang;
                        var idBarang = form.find('input[name="id_barang"]').val();

                        $('.stok-barang[data-id="' + idBarang + '"]').text('Stok: ' + stokBaru);

                        // Update tombol tambah berdasarkan stok
                        updateUI();

                        var notifBtnKeranjang = $('a[href="{{ route('keranjang') }}"]');
                        if (totalJumlah > 0) {
                            notifBtnKeranjang.find('span').text(totalJumlah);
                        } else {
                            notifBtnKeranjang.find('span').text('');
                        }
                    } else {
                        alert('Gagal memasukkan ke keranjang');
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.statusText);
                }
            });
        });

        // Panggil fungsi untuk memperbarui UI saat halaman dimuat
        updateUI();
    });
</script>

@endsection
