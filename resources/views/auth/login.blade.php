<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-md">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative transition duration-300 ease-in-out transform animate-slide-in" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a.5.5 0 00-.706 0L10 9.293 6.354 5.646a.5.5 0 10-.708.708L9.293 10l-3.647 3.646a.5.5 0 10.708.708L10 10.707l3.646 3.647a.5.5 0 10.708-.708L10.707 10l3.647-3.646a.5.5 0 000-.702z"/></svg>
                </span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative transition duration-300 ease-in-out transform animate-slide-in" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a.5.5 0 00-.706 0L10 9.293 6.354 5.646a.5.5 0 10-.708.708L9.293 10l-3.647 3.646a.5.5 0 10.708.708L10 10.707l3.646 3.647a.5.5 0 10.708-.708L10.707 10l3.647-3.646a.5.5 0 000-.702z"/></svg>
                </span>
            </div>
        @endif

        
        
        <h1 class="flex-1 text-2xl font-semibold mb-6 flex items-center">
            <a href="{{ route('landingPage') }}"><i class="fas fa-home text-pink-400 hover:text-black"></i></a>
            <p class="flex-1 text-center mr-6">Login</p>
        </h1>

        <form method="POST" action="{{ route('auth.login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                    @error('username')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
                    @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
            </div>

            <div class="flex items-center justify-between text-sm">
                <p> Belum punya akun? <a href="{{ route('auth.register') }}" class=" text-blue-600 hover:text-blue-900">Register</a> </p>
                <button type="submit" class="px-4 py-2 bg-pink-400 text-white rounded-md shadow-sm hover:bg-pink-700">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>
</html>
