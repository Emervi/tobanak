@extends('layouts.sidebar')

@section('title', isset($user) ? 'Edit User' : 'Tambah User')

@section('content')

    {{-- tombol kembali --}}
    <div class="w-1/2 mx-auto mt-10">

        @isset($user)
            {{-- Jika $user ada maka akan muncul form edit --}}
            <div class="bg-white shadow-2xl font-medium p-2 mb-10">

                <h2 class="text-center font-bold text-xl">Edit User</h2>

                @foreach ($user as $atribut)
                    {{-- form untuk pengisian edit user --}}
                    <form action="{{ route('admin.updateUser', [$atribut->id_user]) }}" method="POST">
                        @csrf
                        @method('put')

                        {{-- edit data user --}}
                        <div class="grid grid-cols-2 gap-5 mt-3">

                            {{-- column 1 --}}
                            <div>

                                <div class="mb-3">
                                    <label for="username" class="block">Username</label>
                                    <input type="text" name="username" id="username"
                                        value="{{ old('username', $atribut->username) }}"
                                        placeholder="Masukan username"
                                        class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                    @error('username')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="block">Nama</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $atribut->name) }}"
                                        placeholder="Masukan nama lengkap"
                                        class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                    @error('name')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="email" class="block">Email</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $atribut->email) }}"
                                        placeholder="Masukan email"
                                        class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                    @error('email')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- column 2 --}}
                            <div>

                                <label for="">Status</label>
                                <div class="flex gap-5 mb-3 bg-gray-300 p-1 shadow rounded-sm w-11/12">
                                    <div>
                                        <input type="radio" name="status" id="Admin" value="Admin"
                                            {{ $atribut->status == 'Admin' ? 'checked' : '' }}>
                                        <label for="Admin">Admin</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="status" id="Kasir" value="Kasir"
                                            {{ $atribut->status == 'Kasir' ? 'checked' : '' }}>
                                        <label for="Kasir">Kasir</label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block">Pilih cabang</label>
                                    <select name="id_cabang"
                                        class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id_cabang }}"
                                                {{ old('id_cabang', $atribut->id_cabang) == $cabang->id_cabang ? 'selected' : '' }}>
                                                {{ $cabang->nama_cabang }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_cabang')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        @error('iron')
                            {{ $message }}hello pak
                        @enderror

                        {{-- footer berisi tombol kembali dan submit --}}
                        <div class="flex justify-between">
                            <a href="{{ route('admin.daftarUser') }}"
                                class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </a>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.ubahPassword', [$atribut->id_user]) }}"
                                    class="text-blue-600 p-2 bg-white border border-blue-600 rounded-md hover:text-white hover:bg-blue-600">
                                    <i class="fas fa-wrench mr-1"></i>
                                    Ubah Password
                                </a>
                                <button type="submit"
                                    class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                                    <i class="fas fa-upload mr-1"></i>
                                    Update User
                                </button>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        @else
            {{-- Jika $user tidak ada maka akan muncul form input --}}
            <div class="bg-white shadow-2xl font-medium p-2 mb-10">

                <h2 class="text-center font-bold text-xl">Tambah User</h2>

                {{-- form untuk pengisian input user --}}
                <form action="{{ route('admin.tambahUser') }}" method="POST">
                    @csrf

                    {{-- input data user --}}
                    <div class="grid grid-cols-2 gap-5 mt-3">

                        {{-- column 1 --}}
                        <div>

                            <div class="mb-3">
                                <label for="username" class="block">Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}"
                                    placeholder="Masukan username" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                @error('username')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="block">Nama</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="Masukan nama lengkap" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                @error('name')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="block">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="Masukan email" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                @error('email')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label class="block">Pilih cabang</label>
                                <select name="id_cabang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                    <option value="" disabled selected>Pilih cabang</option>
                                    @foreach ($cabangs as $cabang)
                                        <option value="{{ $cabang->id_cabang }}"
                                            {{ old('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>
                                            {{ $cabang->nama_cabang }}</option>
                                    @endforeach
                                </select>
                                @error('id_cabang')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                    <label for="no_telp" class="block">Nomor telepon</label>
                                    <input type="text" name="no_telp" id="no_telp" oninput="formatNomorTelepon(this)"
                                        maxlength="14" value="{{ old('no_telp') }}"
                                        class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                    @error('no_telp')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div> --}}

                            {{-- <div>
                                    <label for="alamat" class="block">Alamat</label>
                                    <textarea name="alamat" id="alamat" placeholder="Masukan alamat"
                                        class="bg-gray-300 p-1 shadow rounded-sm w-full resize-none h-24 focus:outline-none">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                    @enderror
                                </div> --}}

                        </div>

                        {{-- column 2 --}}
                        <div>

                            <div class="mb-3">
                                <label for="password" class="block">Password</label>
                                <input type="password" name="password" id="password"
                                    placeholder="Masukan password" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                @error('password')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password2" class="block">Konfirmasi password</label>
                                <input type="password" name="password2" id="password2"
                                    placeholder="Masukan konfirmasi password" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                                @error('password2')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <div class="flex gap-5 bg-gray-300 p-1 shadow rounded-sm w-11/12">

                                    <div>
                                        <input type="radio" name="status" id="Admin" value="Admin"
                                            {{ old('status') == 'Admin' ? 'checked' : '' }}>
                                        <label for="Admin">Admin</label>
                                    </div>

                                    <div>
                                        <input type="radio" name="status" id="Kasir" value="Kasir"
                                            {{ old('status') == 'Kasir' ? 'checked' : '' }}>
                                        <label for="Kasir">Kasir</label>
                                    </div>

                                </div>
                                @error('status')
                                    <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- footer berisi tombol kembali dan submit --}}
                    <div class="flex justify-between">
                        <a href="{{ route('admin.daftarUser') }}"
                            class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                            <i class="fas fa-upload mr-1"></i>
                            Tambah User
                        </button>
                    </div>
                </form>
            </div>
        @endisset

    </div>

    <script>
        function formatNomorTelepon(input) {
            const digits = input.value.replace(/\D/g, '');
            const terFormat = digits.match(/.{1,4}/g)?.join('-') || '';
            input.value = terFormat;
        }
    </script>
@endsection
