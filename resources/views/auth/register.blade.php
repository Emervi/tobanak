<x-app-layout title="Register">

    @slot('header', 'Register')

    @slot('body')
    @if ( session('success') )
        <div class="w-1/3 bg-green-400 mx-auto mb-2 text-center font-medium p-2">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="w-1/3 bg-white mx-auto p-5 rounded-md shadow-xl">

        <h2 class="font-bold text-center text-2xl mb-4">Register</h2>

        <form action="{{ route('auth.register') }}" method="POST">
            @csrf

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
                @if (session('error'))
                <p class="text-red-500 text-sm">{{ session('error') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <input type="radio" name="status" id="admin" value="admin">
                <label for="admin">admin</label>
                <input type="radio" name="status" id="user" value="user">
                <label for="user">user</label>
            </div>

            <div class="mb-4">
                <p>Sudah punya akun? <a href="" class="text-blue-800 font-medium">Login disini!</a></p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-pink-400 p-2 rounded-md font-medium text-white">Register</button>
            </div>
        </form>

    </div>
    @endslot

</x-app-layout>