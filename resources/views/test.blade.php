@extends('layouts.sidebar')

@section('title', 'Test')

@section('content')

    <div>

        <form action="{{ route('printPDF') }}" method="POST" id="formPDF" target="_blank">
            @csrf
            
            <div>
                <label for="">tanggal awal</label>
                <input type="date" name="tanggalAwal" id="tanggalAwal" oninput="handleDateChange()">
            </div>
            <div>
                <label for="">tanggal akhir</label>
                <input type="date" name="tanggalAkhir" id="tanggalAkhir" oninput="handleDateChange()">
            </div>

            <button disabled class="bg-green-300 p-2 disabled:bg-gray-400 disabled:p-2" id="btnsub" type="submit">Submit</button>
        </form>

        <p id="outAwal"></p>
        <p id="outAkhir"></p>
        <p id="hasil"></p>
        <p class="text-red-500 font-bold" id="comparisonResult"></p>

        {{-- <form action="{{ route('printPDF') }}" method="POST" id="pdfForm">
            @csrf
            <input type="date" name="tanggalAwal" placeholder="Masukkan tanggal awal" value="{{ old('tanggalAwal') }}">
            <input type="date" name="tanggalAkhir" placeholder="Masukkan tanggal akhir" value="{{ old('tanggalAkhir') }}">
            <button type="submit">Submit</button>
        </form> --}}

    </div>

    {{-- <script>
        window.onload = function() {
            const tanggalAwal = document.getElementById('tanggalAwal');
            const outAwal = document.getElementById('outAwal');

            const tanggalAkhir = document.getElementById('tanggalAkhir');
            const outAkhir = document.getElementById('outAkhir');

            const nilaiAwal = '';
            const nilaiAkhir = '';

            tanggalAwal.addEventListener('input', function(event) {
                outAwal.textContent = "Tanggal yang dipilih: " + event.target.value;
                nilaiAwal = event.target.value;
            });

            tanggalAkhir.addEventListener('input', function(event) {
                outAkhir.textContent = "Tanggal yang dipilih: " + event.target.value;
                nilaiAkhir = event.target.value;

                if (new Date(nilaiAwal) > new Date(nilaiAkhir)) {
                    let outHasil = document.getElementById('hasil')
                    outHasil.textContent = 'true coy';
                };
            });
        };
    </script> --}}

    <script>
        let dateA = "";
        let dateB = "";

        function handleDateChange() {
            // Ambil nilai tanggal dari inputan
            dateA = document.getElementById('tanggalAwal').value;
            dateB = document.getElementById('tanggalAkhir').value;

            // Jika kedua tanggal sudah diisi, lakukan perbandingan
            if (dateA && dateB) {
                // Bandingkan tanggal
                if (new Date(dateA) > new Date(dateB)) {
                    document.getElementById('btnsub').disabled = true;
                    document.getElementById('comparisonResult').textContent = "Tanggal awal tidak boleh lebih besar dari tanggal akhir!";
                } else {
                    document.getElementById('btnsub').disabled = false;
                    document.getElementById('comparisonResult').textContent = "";
                }
            } else {
                document.getElementById('btnsub').disabled = true;
                document.getElementById('comparisonResult').textContent = "Tanggal tidak boleh kosong!"; // Reset jika input kosong
            }
        }
    </script>

    {{-- <script>
        document.getElementById('pdfForm').addEventListener('submit', function (event) {
            event.preventDefault();

            let tanggalAwal = document.getElementById('tanggalAwal').value;
            let tanggalAkhir = document.getElementById('tanggalAkhir').value;
            let pesanError = document.getElementById('pesanError');

            pesanError.textContent = '';

            if ( new Date(tanggalAwal) > new Date(tanggalAkhir) ) {
                pesanError.textContent = 'Tanggal awal tidak boleh lebih besar dari tanggal akhir';
            } else {
                let formData = new FormData(this);

                pesanError.textContent = 'asdasd';
                fetch('/generate-pdf-url', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    window.open(data, _blank);
                })
                .catch((error) => {
                    console.log('Error', error);
                    pesanError.textContent = 'Terjadi kesalahan!';
                });
            };
        });
    </script> --}}

    <!-- JavaScript untuk membuka halaman cetak PDF di tab baru -->
    {{-- <script>
        document.getElementById('pdfForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;

            fetch(form.action, {
                    method: form.method,
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        window.open(data.url, '_blank'); // Membuka halaman PDF di tab baru
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script> --}}

@endsection

{{-- <button @click="isOpenLaporan = true"
            class="text-green-500 text-center p-2 bg-white border border-green-500 rounded-md hover:text-white hover:bg-green-600">
            <i class="fas fa-file-pdf mr-1 transform -scale-x-100"></i>
            Buat Laporan
        </button>

        <p class="text-red-500 font-bold" id="pesanError"></p>

        <!-- Modal laporan transaksi -->
        <div x-show="isOpenLaporan" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">

                form laporan transaksi
                <form id="pdfForm">
                    @csrf

                    <div class="flex justify-end align-middle">
                        <button type="button" @click="isOpenLaporan = false">
                            <i class="fas fa-times text-2xl cursor-pointer"></i>
                        </button>
                    </div>

                    <h2 class="text-center text-2xl font-bold mb-5">Buat Laporan</h2>

                    <div class="mb-5">
                        <label class="font-semibold">Masukan Tanggal Transaksi: </label>

                        <div class="grid grid-cols-3 mt-3">

                            <div>
                                <input type="date" name="tanggalAwal" id="tanggalAwal" value="{{ old('tanggalAwal') }}"
                                    class="bg-gray-200 p-2 rounded mb-1">
                                @error('tanggalAwal')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-center">
                                <p class="mt-2">-</p>
                            </div>

                            <div>
                                <input type="date" name="tanggalAkhir" id="tanggalAkhir"
                                    value="{{ old('tanggalAkhir') }}" class="bg-gray-200 p-2 rounded mb-1">
                                @error('tanggalAkhir')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>



                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit"
                            class="bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded-lg">Generate</button>
                    </div>
                </form>

            </div>
        </div> --}}
