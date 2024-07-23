<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="w-1/3 bg-white mx-auto p-5 rounded-md shadow-xl mt-12">

        <h2 class="font-bold text-center text-2xl mb-4">Register</h2>

        <form action="{{ url('/register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password2" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password2" id="password2" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('password2')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <p class="block text-sm font-medium text-gray-700">Sudah punya akun? <a href="{{ route('auth.login') }}" class="text-blue-600 font-medium hover:text-blue-900">Login disini!</a></p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-pink-400 text-white rounded-md shadow-sm hover:bg-pink-700">Register</button>
            </div>
        </form>

    </div>
    
</body>
</html>
