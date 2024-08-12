@extends('layouts.app')

@section('title', 'Detail Produk')

@section('body')
<div class="mt-8 ml-10">
    <div class="flex items-center mb-4">
        <a href="{{ route('homeUser') }}" class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">Kembali</a>
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
                <form class="add-form-keranjang" action="{{ route('keranjang.tambah') }}" method="POST">
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
        <span class="absolute top-0 right-0 bg-green-700 text-white rounded-full px-2 py-1 text-xs font-bold">{{ $totalJumlah > 0 ? $totalJumlah : '0' }}</span>
    </a>
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
                button.removeClass('bg-green-500 hover:bg-green-700').addClass('bg-gray-400').prop('disabled', true);
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

    updateUI();
});

</script>
@endsection
