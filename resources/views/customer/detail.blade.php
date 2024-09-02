@extends('layouts.app')

@section('title', 'Detail Produk')

@section('body')
<div class="mt-8 ml-10">
    <div class="flex items-center mb-4">
        <a href="{{ route('customer.home') }}" class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">Kembali</a>
    </div>
    <div class="relative flex flex-col md:flex-row items-start md:items-center bg-white p-8 rounded-lg shadow-lg max-w-sm md:max-w-3xl mx-auto">
        @if($barang->diskon > 0)
            <div class="absolute top-0 right-0 bg-red-600 text-white text-lg font-bold px-4 py-2 transform -rotate-12 -translate-x-1/2 -translate-y-1/2">
                PROMO!!
            </div>
        @endif
        <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="Foto Barang" class="w-48 h-48 object-cover rounded mr-4">
        <div class="flex-1">
            <h2 class="text-xl font-bold">{{ $barang->nama_barang }}</h2>
            <p class="text-gray-600 mt-10">Bahan: {{ $barang->bahan }}</p>
            <p class="text-gray-600 mt-2 stok-barang" data-id="{{ $barang->id_barang }}">Stok: {{ $barang->stok_barang }}</p>
            <p class="text-gray-600 mt-2">Kategori: {{ $barang->kategori_barang }}</p>
            <p class="text-gray-600 mt-2">Deskripsi: {{ $barang->deskripsi_barang }}</p>
            <p class="text-red-600 mt-4 font-bold">
                @if ($barang->potongan > 0)
                    {{ "POTONGAN : Rp." . number_format($barang->potongan, 0) }}
                @endif
            </p>
            <p class="text-red-600 mt-2 font-bold">
                @if ($barang->diskon > 0)
                    {{ "DISKON " . $barang->diskon . "% OFF" }}
                @endif
            </p>
            <div class="mt-20 flex justify-end items-center">

                @if($barang->diskon > 0 || $barang->potongan > 0)
                    <span class="text-xl font-bold text-red-500 mr-4 line-through">Rp {{ number_format($barang->harga_asli, 0, ',', '.') }}</span>
                @endif
                <span class="text-xl font-bold mr-4">Harga: Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                @if ( $barang->stok_barang <= 0)
                <div class="bg-gray-500 text-white px-4 py-2 rounded">
                    Tambah ke Keranjang
                </div>
                @else
                <form class="add-form-keranjang" action="{{ route('customerKeranjang.tambah') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 add-button" data-id="{{ $barang->id_barang }}" {{ $barang->stok_barang <= 0 ? 'disabled' : '' }}>
                        Tambah ke Keranjang
                    </button>                    
                </form>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('keranjang') }}" class="bg-white m-5 fixed bottom-5 right-1 border border-green-500 text-green-500 p-3 rounded-full shadow-lg hover:bg-green-500 hover:text-white">
        <i class="fas fa-shopping-cart text-2xl"></i>    
        <span class="absolute top-0 right-0 bg-green-700 text-white rounded-full px-2 py-1 text-xs font-bold" id="cart-notification">{{ $totalJumlah > 0 ? $totalJumlah : '0' }}</span>
    </a>

    @if($rekomendasiBarang->isNotEmpty())
    <div class="mt-10">
        <h3 class="text-2xl font-bold mb-4">Produk Lainnya dari kategori {{ $barang->kategori_barang }}</h3>
        <div class="grid grid-cols-1 mb-4 md:grid-cols-4 gap-1">
            @foreach($rekomendasiBarang as $barang)
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
        
                    <a href="{{ route('customer.detail', ['id_barang' => $barang->id_barang]) }}">
                        <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="Foto Barang" class="w-64 h-48 object-cover">
                    </a>
                </div>
                <div class="w-64 p-4 flex flex-col items-start">
                    <h2 class="text-xl font-bold">{{ $barang->nama_barang }}</h2>
                    <p class="text-gray-600 mt-2 stok-barang" data-id="{{ $barang->id_barang }}">Stok: {{ $barang->stok_barang }}</p>
                    <p class="text-gray-600 stok-barang">cabang : {{ $barang->cabang->nama_cabang }}</p>
                    <div class="mt-2 flex justify-between w-full items-center">
                        @if($barang->diskon || $barang->potongan)
                            <div class="flex flex-col">
                                <span class="text-red-500 font-bold line-through">Rp {{ number_format($barang->harga_asli, 0, ',', '.') }}</span>
                                <span class="text-gray-600 font-bold text-lg">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <span class="text-gray-600 font-bold text-lg">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                        @endif
                        <form class="add-form-keranjang" action="{{ route('customerKeranjang.tambah') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                            <button type="submit" class="bg-green-400 text-white px-4 py-2 rounded-full hover:bg-green-700 add-button" data-id="{{ $barang->id_barang }}" {{ $barang->stok_barang <= 0 ? 'disabled' : '' }}>
                                +
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        function updateUI() {
            $('.stok-barang').each(function() {
                var stok = parseInt($(this).text().replace('Stok: ', ''));
                var idBarang = $(this).data('id');
                var button = $('button[data-id="' + idBarang + '"]');

                if (stok <= 0) {
                    button.removeClass('bg-green-500 hover:bg-green-700').addClass('bg-gray-400 cursor-not-allowed').prop('disabled', true);
                } else {
                    button.prop('disabled', false).removeClass('bg-gray-400').addClass('bg-green-500');
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

                        var notifBtnKeranjang = $('#cart-notification');
                        if (totalJumlah > 0) {
                            notifBtnKeranjang.text(totalJumlah);
                        } else {
                            notifBtnKeranjang.text('0');
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

        updateUI();
    });
</script>
@endsection
