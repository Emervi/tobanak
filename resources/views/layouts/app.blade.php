<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tobanak | {{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="w-full p-5 mb-2">
        <h1 class="font-medium text-2xl ml-2">{{ $header }}</h1>
    </header>
    
    <main>
        {{ $body }}
    </main>

</body>
</html>

{{-- UNUSED ASSET --}}
{{-- <div class="bg-white p-8 rounded-lg shadow-lg w-80">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <form action="/register" method="POST">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama</label>
            <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>
        <button type="submit" class="w-full bg-pink-500 text-white p-2 rounded hover:bg-pink-600">Register</button>
    </form>
    <p class="mt-4 text-center text-gray-600">Sudah punya akun? <a href="/login" class="text-blue-500 hover:underline">Login disini!</a></p>
</div> --}}