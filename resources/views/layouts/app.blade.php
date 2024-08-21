<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Tobanak')</title>
    <link rel="icon" href="{{ asset('tobanak.ico') }}" type="image/x-icon">

    {{-- Tailwindcss --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    {{-- Javascript --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @keyframes fadeIn {
          from { opacity: 0; }
          to { opacity: 1; }
        }
        .fade-in {
          animation: fadeIn 1s ease-in-out;
        }

        @keyframes check-anim {
            from { transform: rotateY(0deg) }
            to { transform: rotateY(360deg) }
        }
        .check-anim {
            animation: check-anim 1300ms linear 1;
        }

        @keyframes pop-up {
            from { transform: translateY(110px) }
            to { transform: translateY(0) }
        }
        .pop-up {
            animation: pop-up 1300ms linear;
        }

        @keyframes landing-page {
            from { transform: translateY(60px)}
            to { transform: translateY(0px) }
        }
        .landing-page {
            animation: landing-page 1s linear;
        }


        .alert {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            min-width: 250px;
            display: none;
        }

        .alert.show {
            display: block;
        }

        /* @keyframes laju {
            from { transform: translateX(-500px) }
            to { transform: translateX(1300px) }
        }
        .laju {
            animation: laju 5s linear infinite forwards;
        }

        @keyframes laju-red {
            from { transform: translateX(-500px) }
            to { transform: translateX(1300px) }
        }
        .laju-red {
            animation: laju-red 5s linear infinite forwards;
        }

        @keyframes laju-blue {
            from { transform: translateX(-500px) }
            to { transform: translateX(1300px) }
        }
        .laju-blue {
            animation: laju-blue 5s linear infinite forwards;
        } */

        
        .notif-badge {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            background-color: #f00; /* Red background */
            color: #fff; /* White text */
            border-radius: 9999px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .notif-badge.show {
            display: block;
        }
    
    </style>
    <style>
        .scroll-container {
            /* Container styling */
            max-height: 200px; /* Adjust the height as needed */
            overflow: hidden;
            position: relative;
        }
    
        .scroll-content {
            max-height: 100%;
            overflow-y: scroll;
            padding-right: 15px; /* Ensure there's space for the scrollbar */
        }
    
        /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
        .scroll-content::-webkit-scrollbar {
            width: 0;
            background: transparent; /* optional */
        }
    
        /* Hide scrollbar for Firefox */
        .scroll-content {
            scrollbar-width: none; /* Firefox */
        }
    </style>

    @yield('style')
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Apakah anda yakin ingin menghapus data tersebut?')) {
                event.target.closest('form').submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100">

    <nav class="w-full p-3 flex justify-between bg-rose-400 items-center">
        <div class="flex justify-between gap-10 items-center">
        <div class="font-bold text-2xl ml-5">
            @if (session()->has('user'))
                <a href="{{ route('homeUser') }}">
                    <img src="{{ asset('images/tobanak.png') }}" class="w-10 h-10">
                </a>
            @elseif (session()->has('admin'))
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/tobanak.png') }}" class="w-10 h-10">
                </a>
            @else
                <a href="{{ route('auth.login') }}">
                    <img src="{{ asset('images/tobanak.png') }}" class="w-10 h-10">
                </a>
            @endif

        </div>
        @if ( session()->has('user') )
        <ul class="flex justify-between gap-7">
            <li><a href="{{ route('homeUser') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Home</a></li>
            <li><a href="{{ route('keranjang') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Keranjang</a></li>
            <li><a href="{{ route('distribusi') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Distribusi</a></li>
            <li><a href="" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500"></a></li>
        </ul>
        @elseif ( session()->has('admin') )
        <ul class="flex justify-between gap-7">
            <li><a href="{{ route('admin.dashboard') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Home</a></li>
            <li><a href="{{ route('admin.daftarUser') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">User</a></li>
            <li><a href="{{ route('admin.daftarBarang') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Barang</a></li>
            <li><a href="{{ route('admin.daftarTransaksi') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Transaksi</a></li>
            <li><a href="{{ route('admin.daftarCabang') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Cabang</a></li>
            <li><a href="{{ route('admin.daftarEkspedisi') }}" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500 transition">Ekspedisi</a></li>
        </ul>
        @else

        @endif
        </div>

        <div>

            @if ( session()->has('admin') || session()->has('user') )
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="p-1 hover:text-pink-600 rounded-md text-white mr-5 transition">
                    Logout
                </button>
            </form> 
            @else
            <a href="{{ route('auth.register') }}" class="p-1 hover:text-pink-600 rounded-md text-white mr-5">Register</a>
            <a href="{{ route('auth.login') }}" class="p-1 hover:text-pink-600 rounded-md text-white mr-5">Login</a>
            @endif

                       
        </div>
    </nav>

    <main>
        {{-- <div class="w-full bg-white p-1 relative">
            <i class="fas fa-shopping-cart text-2xl laju">Belanja</i>
            <i class="fas fa-shopping-cart text-red-500 text-2xl laju-red">Di</i>
            <i class="fas fa-shopping-cart text-blue-500 text-2xl laju-blue">Tobanak</i>
        </div> --}}
        @yield('body')
    </main>


    <script>
        function formatNumber(value) {
            // Menghapus semua karakter non-digit
            value = value.replace(/\D/g, '');

            // Batasi input hingga 100.000.000
            if (parseInt(value) > 100000000) {
                value = '100000000';
            }

            // Format angka sesuai format Indonesia
            return new Intl.NumberFormat('id-ID').format(value);
        }

        // Format uang untuk halaman keranjang
        const formattedInputElement = document.getElementById('formatUang');
        const hiddenInputElement = document.getElementById('uang_pembayaran');

        formattedInputElement.addEventListener('input', function(e) {
            let rawValue = e.target.value.replace(/\D/g, ''); // Simpan nilai asli tanpa format
            
            // Format angka dan set nilai terformat kembali ke input
            e.target.value = formatNumber(rawValue);

            // Simpan nilai asli ke elemen hidden input
            hiddenInputElement.value = rawValue;
        });

        formattedInputElement.addEventListener('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter, dan .
            if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode === 65 && (e.ctrlKey || e.metaKey)) ||
                // Allow: Ctrl+C
                (e.keyCode === 67 && (e.ctrlKey || e.metaKey)) ||
                // Allow: Ctrl+V
                (e.keyCode === 86 && (e.ctrlKey || e.metaKey)) ||
                // Allow: Ctrl+X
                (e.keyCode === 88 && (e.ctrlKey || e.metaKey)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // Biarkan event terjadi
                return;
            }

            // Cegah jika bukan angka
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        // Cegah input dengan karakter non-digit saat menempel
        formattedInputElement.addEventListener('paste', function(e) {
            e.preventDefault();
            let pastedData = e.clipboardData.getData('text');
            let formattedData = formatNumber(pastedData.replace(/\D/g, ''));
            formattedInputElement.value = formattedData;
            hiddenInputElement.value = pastedData.replace(/\D/g, '');
        });

        // Saat form disubmit, pastikan nilai di elemen hidden input disiapkan untuk dikirim
        document.getElementById('myForm').addEventListener('submit', function() {
            hiddenInputElement.value = formattedInputElement.value.replace(/\D/g, '');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>
</body>
</html>