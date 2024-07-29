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
                <label for="username" class="text-gray-500">username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('username')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="name" class="text-gray-500">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="text-gray-500">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="text-gray-500">Password</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password2" class="text-gray-500">Konfirmasi Password</label>
                <input type="password" name="password2" id="password2" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:ring-blue-300">
                @error('password2')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <p>Sudah punya akun? <a href="{{ route('auth.login') }}" class="text-blue-600 font-medium hover:text-blue-900">Login disini!</a></p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-pink-400 p-2 rounded-md font-medium text-white hover:bg-pink-700">Register</button>
            </div>
        </form>

    </div>
    
</body>
</html>
