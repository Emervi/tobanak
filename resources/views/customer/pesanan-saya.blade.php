@extends('layouts.app')

@section('body')

    @php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    @endphp

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Pesanan Saya</h1>

    {{-- filter --}}
    <div class="border-b border-gray-200 mb-6">
        <ul class="flex space-x-8">
            <li class="cursor-pointer">
                <a href="{{ route('customer.pesanan', ['status' => '']) }}" 
                    class="{{ request('status') == '' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-600 hover:text-gray-800' }} pb-2">
                    Semua
                </a>
            </li>
            <li class="cursor-pointer">
                <a href="{{ route('customer.pesanan', ['status' => 'diproses']) }}" 
                    class="{{ request('status') == 'diproses' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-600 hover:text-gray-800' }} pb-2">
                    Diproses
                </a>
            </li>
            <li class="cursor-pointer">
                <a href="{{ route('customer.pesanan', ['status' => 'dikirim']) }}" 
                    class="{{ request('status') == 'dikirim' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-600 hover:text-gray-800' }} pb-2">
                    Dikirim
                </a>
            </li>
            <li class="cursor-pointer">
                <a href="{{ route('customer.pesanan', ['status' => 'diterima']) }}" 
                    class="{{ request('status') == 'diterima' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-600 hover:text-gray-800' }} pb-2">
                    Diterima
                </a>
            </li>
            <li class="cursor-pointer">
                <a href="{{ route('customer.pesanan', ['status' => 'dibatalkan']) }}" 
                    class="{{ request('status') == 'dibatalkan' ? 'text-red-500 border-b-2 border-red-500' : 'text-gray-600 hover:text-gray-800' }} pb-2">
                    Dibatalkan
                </a>
            </li>
        </ul>
    </div>

    <div class="flex flex-col gap-4 items-center">
        @foreach($barangs as $barang)
            <div x-data='{ openModals: false, isRated: {{ $barang->rated_barang ? 'true' : 'false' }} }' class="bg-white shadow-sm rounded-lg p-4 w-full md:w-3/4">
                <div class="w-full flex justify-between mr-4 text-gray-700 text-center">
                    <div class="text-sm bg-rose-500 text-white p-1 rounded">
                        <i class="fa-solid fa-store mx-1"></i> {{ $barang->nama_cabang }}
                    </div>
                    <div class="text-gray-800 text-sm -mt-1">
                        @if ($barang->status_barang == 'Dibatalkan')
                            <span class="text-lg font-semibold text-rose-600">{{ $barang->status_barang }}</span>
                        @else
                            Estimasi diterima : 
                            @if ($barang->estimasi_pengiriman > 1)
                                {{ Carbon::parse($barang->barang_created_at)->translatedFormat('d') }}
                                -
                                {{ Carbon::parse($barang->barang_created_at)->addDays($barang->estimasi_pengiriman)->translatedFormat('d F') }}
                            @else
                                {{ Carbon::parse($barang->barang_created_at)->translatedFormat('d F') }}
                            @endif  
                            | <span class="text-lg font-semibold text-rose-600">{{ $barang->status_barang }}</span>
                        @endif
                    </div>
                </div>
                <hr class="my-3">
                <div class="mt-4">
                    <div class="flex justify-between">
                        <div class="flex gap-4">
                            <a href="{{ route('customer.detail', ['id_barang' => $barang->id_barang]) }}">
                                <img src="{{ asset('images/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}" class="w-32 h-32 object-cover rounded-lg bg-gray-100 p-1">
                            </a>
                            <div class="">
                                <h4 class="text-lg font-semibold text-gray-800">{{ $barang->nama_barang }}</h4>
                                <p class="text-gray-600 text-sm mt-1">Kuantitas: {{ $barang->kuantitas }}</p>
                                <p class="text-gray-600 text-sm mt-1">{{ $barang->deskripsi_barang }}</p>
                                <div class="flex items-center mt-2">
                                    @if ($barang->diskon > 0)
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded mr-2">Diskon {{ $barang->diskon }}%</span>
                                    @elseif ($barang->potongan > 1000)
                                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">Potongan Rp. {{ number_format($barang->potongan, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-10">
                            <p class="text-gray-600 font-semibold">Rp {{ number_format($barang->harga * $barang->kuantitas, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-sm">Harga Satuan: Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <hr class="my-3">
                <div class="w-full items-end text-end">
                    <p class="text-gray-800 my-3">total harga : 
                        <span class="text-lg text-rose-500 font-semibold">
                            Rp. {{ number_format($barang->harga * $barang->kuantitas + $barang->harga_ekspedisi, 0, ',', '.') }}
                        </span>
                    </p>
                    @if ($barang->status_barang === 'Dikirim')                            
                            <form action="{{ route('customer.konfirmasiPesanan') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_transaksi" value="{{ $barang->id_transaksi }}">
                                <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                                <input type="hidden" name="kuantitas" value="{{ $barang->kuantitas }}">
                                <input type="hidden" name="total_harga_barang" value="{{ $barang->total_harga_barang }}">
                                <button class="bg-pink-500 text-white hover:bg-pink-700 px-4 py-2 rounded">Terima</button>    
                            </form>
                    @elseif ($barang->status_barang === 'Diproses')
                        <form action="{{ route('customer.batalPesanan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_transaksi" value="{{ $barang->id_transaksi }}">
                            <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                            <input type="hidden" name="kuantitas" value="{{ $barang->kuantitas }}">
                            <input type="hidden" name="total_harga_barang" value="{{ $barang->total_harga_barang }}">
                            <button class="bg-pink-400 text-white px-4 py-2 rounded">Batal</button>    
                        </form>
                    @elseif ($barang->status_barang === 'Dibatalkan')
                        <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>Dibatalkan</button>                        
                    @else
                        <div class="gap-1 flex justify-end">
                            @if (!$barang->rated_barang)
                                <button @click="openModals = true" class="border border-pink-500 text-pink-500 hover:text-white hover:bg-pink-500 px-4 py-2 rounded">Nilai</button>                            
                            @elseif($barang->rated_barang)
                                <p class="text-gray-700 px-4 py-2 font-semibold text-xl"><i class="fa-solid fa-star"></i>{{ $barang->rating }}</p>
                            @endif

                            <div x-show="openModals" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50" x-cloak>
                                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Nilai Barang</h2>
                                    <form action="{{ route('customer.rating') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_transaksi" value="{{ $barang->id_transaksi }}">
                                        <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
                                        <div class="mb-4">
                                            <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating:</label>
                                            <select name="rating" id="rating" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                                                <option value="5">5 - Sangat Baik</option>
                                                <option value="4">4 - Baik</option>
                                                <option value="3">3 - Cukup</option>
                                                <option value="2">2 - Buruk</option>
                                                <option value="1">1 - Sangat Buruk</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="review" class="block text-gray-00 font-semibold mb-2">Review:</label>
                                            <textarea name="review" id="review" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="button" @click="openModals = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                                            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded">Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <button class="bg-pink-500 text-white px-4 py-2 rounded cursor-not-allowed" disabled>Selesai</button>                        
                        </div>
                    @endif
                
                </div>
            </div>

            <!-- Modal untuk Penilaian -->
            
        @endforeach
    </div>

    <!-- Pagination -->
    {{-- <div class="mt-6">
        {{ $barangs->links() }}
    </div> --}}
</div>

@endsection
