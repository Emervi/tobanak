<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Tobanak')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="w-full p-5 flex justify-between bg-pink-400">
        <div class="flex justify-between gap-10">
        <div class="font-bold text-2xl">
            <p>LOGO</p>
        </div>
        <ul class="flex justify-between gap-7">
            <li><a href="" class="text-white p-2 hover:bg-pink-900">Home</a></li>
            <li><a href="" class="text-white p-2 hover:bg-pink-900">About</a></li>
            <li><a href="" class="text-white p-2 hover:bg-pink-900">Contact</a></li>
        </ul>
        </div>

        <div>
            <a href="" class="p-2 bg-gray-500 rounded-md text-white">Logout</a>
        </div>
    </nav>

    <main>
        @yield('body')
    </main>

</body>
</html>