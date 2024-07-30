<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Tobanak')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('bat.ico') }}" type="image/x-icon">
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
    </style>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this post?')) {
                event.target.closest('form').submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100">

    <nav class="w-full p-3 flex justify-between bg-pink-300 items-center">
        <div class="flex justify-between gap-10 items-center">
        <div class="font-bold text-2xl ml-5">
            <img src="{{ asset('images/logo_tobanak.png') }}" class="w-10 h-10">

        </div>
        <ul class="flex justify-between gap-7">
            <li><a href="" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500">Home</a></li>
            <li><a href="" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500">About</a></li>
            <li><a href="" class="text-white p-1 hover:text-pink-600 hover:border-b hover:border-pink-500">Contact</a></li>
        </ul>
        </div>

        <div>

            @if ( session()->has('admin') || session()->has('user') )
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="p-1 hover:text-pink-600 rounded-md text-white mr-5">
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
        @yield('body')
    </main>

</body>
</html>