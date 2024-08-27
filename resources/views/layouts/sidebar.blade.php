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
        /* Custom animations and styles */
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
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="min-w-56 h-screen bg-gray-800 text-white flex flex-col sticky top-0">
        <div class="flex items-center justify-center h-20 border-b border-gray-700">
            @if (session()->has('kasir'))
                <a class="flex" href="{{ route('homeKasir') }}">
                    <img src="{{ asset('images/tobanak.png') }}" class="w-10 h-10">
                    <span class="ml-3 text-2xl font-bold">Tobanak</span>
                </a>
            @elseif (session()->has('admin'))
                <a class="flex" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/tobanak.png') }}" class="w-10 h-10">
                    <span class="ml-3 text-2xl font-bold">Tobanak</span>
                </a>
            @else
                <img src="{{ asset('images/tobanak.png') }}" class="w-10 h-10">
                    <span class="ml-3 text-2xl font-bold">Tobanak</span>
            @endif
        </div>
        <nav class="flex-grow">
            @if (session()->has('kasir'))
            <ul class="mt-10">
                <li class="hover:bg-gray-700">
                    <a href="{{ route('homeKasir') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('keranjang') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-shopping-cart mr-2"></i> Keranjang
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('distribusi') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-truck mr-2"></i> Distribusi
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('kasir.daftarPesanan') }}" class="flex items-center px-4 py-2">
                        <i class="fa-brands fa-shopify mr-2"></i> Pesanan
                    </a>
                </li>
            </ul>
            @elseif (session()->has('admin'))
            <ul class="mt-10">
                <li class="hover:bg-gray-700">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('admin.daftarUser') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-users mr-2"></i> Pelanggan
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('admin.daftarBarang') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-box mr-2"></i> Barang
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('admin.daftarCabang') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-store mr-2"></i> Cabang
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('admin.daftarTransaksi') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-money-bill-alt mr-2"></i> Transaksi
                    </a>
                </li>
                <li class="hover:bg-gray-700">
                    <a href="{{ route('admin.daftarEkspedisi') }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-shipping-fast mr-2"></i> Ekspedisi
                    </a>
                </li>
            </ul>
            @endif
        </nav>

        <div class="mt-auto">
            @if (session()->has('admin') || session()->has('kasir') || session()->has('customer'))
            <form action="{{ route('logout') }}" method="POST" class="flex justify-center py-4">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 rounded-md">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
            @else
            <div class="flex justify-around py-4">
                <a href="{{ route('auth.register') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-md">
                    Register
                </a>
                <a href="{{ route('auth.login') }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 rounded-md">
                    Login
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Main content -->
    <main class="flex-grow p-6">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>
</body>
</html>
