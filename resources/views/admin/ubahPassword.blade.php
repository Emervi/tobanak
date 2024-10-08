@extends('layouts.sidebar')

@section('title', 'Ubah Password')

@section('content')

    {{-- tombol kembali --}}
    <div class="w-1/2 mx-auto mt-10">

        @isset($user)
            {{-- Jika $user ada maka akan muncul form edit --}}
            <div class="bg-white shadow-2xl font-medium p-2 mb-10 rounded-lg">

                <h2 class="text-center font-bold text-xl">Ubah Password</h2>

                @foreach ($user as $atribut)
                    {{-- form untuk pengisian edit user --}}
                    <form action="{{ route('admin.updatePassword', [$atribut->id_user]) }}" method="POST">
                        @csrf
                        @method('put')

                        {{-- edit data user --}}
                        <div class="grid grid-cols-1 gap-5 mt-3">

                            {{-- column 1 --}}
                            <div class="w-1/2 mx-auto">

                                <div class="mb-3">
                                    <label for="password_awal" class="block">Password Sebelumnya</label>
                                    <input type="password" name="password_awal" id="password_awal" placeholder="Masukan password sebelumnya"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('password_awal')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_baru" class="block">Password Baru</label>
                                    <input type="password" name="password_baru" id="password_baru" placeholder="Masukan password baru"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('password_baru')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="password_konfirmasi" class="block">Konfirmasi Password</label>
                                    <input type="password" name="password_konfirmasi" id="password_konfirmasi" placeholder="Masukan konfirmasi password"
                                        class="p-1 shadow rounded-md w-11/12 focus:outline-none focus:ring-2 focus:ring-pink-400 border border-gray-300">
                                    @error('password_konfirmasi')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- footer berisi tombol kembali dan submit --}}
                        <div class="flex justify-between">
                            <a href="{{ route('admin.editUser', [$atribut->id_user]) }}"
                                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>
                            <button type="submit"
                                class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                                <i class="fas fa-wrench mr-1"></i>
                                Konfirmasi
                            </button>
                        </div>
                    </form>
                @endforeach
            </div>
        @else
        @endisset

    </div>
@endsection
