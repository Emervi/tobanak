<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">

    <div class="w-1/3 bg-white mx-auto p-5 rounded-md shadow-xl mt-7">

        <h1 class="flex-1 text-2xl font-semibold mb-6 flex items-center">
            <a href="{{ route('landingPage') }}"><i class="fas fa-home text-pink-400 hover:text-black"></i></a>
            <p class="flex-1 text-center mr-7">Register</p>
        </h1>

        <form action="{{ route('auth.register') }}" method="POST">
            @csrf

            <div class="mb-4 text-sm">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" autofocus placeholder="Masukan username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                @error('username')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4 text-sm">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukan nama lengkap" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-sm">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukan email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-sm">
                <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="text" name="no_telp" id="no_telp" oninput="formatNomorTelepon(this)" maxlength="14" value="{{ old('no_telp') }}" placeholder="Masukan nomor telepon" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                @error('no_telp')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-sm">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukan password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-sm">
                <label for="password2" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password2" id="password2" placeholder="Masukan konfirmasi password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                @error('password2')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-sm">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" placeholder="Masukan alamat lengkap" class="mt-1 block resize-none h-16 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">{{ old('alamat') }}</textarea>
                @error('alamat')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror                
            </div>


            <div class="mb-4 text-sm">
                <p>Sudah punya akun? <a href="{{ route('auth.login') }}" class="text-blue-600 hover:text-blue-900">Login disini!</a></p>
            </div>

            <div class="flex justify-end text-sm">
                <button type="submit" class="bg-pink-400 p-2 rounded-md text-white hover:bg-pink-700">Register</button>
            </div>
        </form>

    </div>

    <script>
        function formatNomorTelepon(input){
            const digits = input.value.replace(/\D/g, '');
            const terFormat = digits.match(/.{1,4}/g)?.join('-') || '';
            input.value = terFormat;
        }
    </script>

</body>
</html>
