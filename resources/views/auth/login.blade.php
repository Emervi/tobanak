<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-md">
        @if ( session('success') )
        <div class="w-full bg-green-400 mx-auto mb-2 text-center font-medium p-0.5">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if ( session('error') )
        <div class="w-full bg-green-400 mx-auto mb-2 text-center font-medium p-0.5">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <h1 class="text-2xl font-semibold mb-6 text-center">Login</h1>

        <form method="POST" action="{{ route('auth.login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">username</label>
                <input id="username" name="username" type="text" autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-pink-400 sm:text-sm">
            </div>

            <div class="flex items-center justify-between">
                <p> Belum punya akun? <a href="{{ route('auth.register') }}" class=" text-blue-600 hover:text-blue-900">Register</a> </p>
                <button type="submit" class="px-4 py-2 bg-pink-400 text-white rounded-md shadow-sm hover:bg-pink-700">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>
</html>