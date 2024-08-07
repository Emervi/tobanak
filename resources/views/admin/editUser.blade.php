@extends('layouts.app')

@section('title', 'Edit User')

@section('body')

{{-- tombol kembali --}}
<div class="w-1/2 mx-auto mt-10">

    <div class="bg-white shadow-2xl font-medium p-2 mb-10">

        <h2 class="text-center font-bold text-xl">Edit User</h2>

        @foreach ( $user as $atribut )
            
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
                        <input type="text" name="username" id="username" value="{{ old('username', $atribut->username) }}" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'username' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="block">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $atribut->name) }}" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'name' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block">Pilih cabang</label>
                        <select name="id_cabang" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                            @foreach ( $cabangs as $cabang )
                                <option value="{{ $cabang->id_cabang }}" {{ ( old('id_cabang', $atribut->id_cabang) == $cabang->id_cabang ) ? 'selected' : ''  }}>{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                        @error( 'id_cabang' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- column 2 --}}
                <div>

                    <div class="mb-3">
                        <label for="email" class="block">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $atribut->email) }}" class="bg-gray-300 p-1 shadow rounded-sm w-11/12 focus:outline-none">
                        @error( 'email' )
                            <p class="text-red-500 font-medium text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <label for="">Status</label>
                    <div class="flex gap-5 mb-5 bg-gray-300 p-1 shadow rounded-sm w-11/12">
                        <div>
                            <input type="radio" name="status" id="admin" value="admin" {{ $atribut->status == 'admin' ? 'checked' : '' }}>
                            <label for="admin">Admin</label>
                        </div>
                        <div>
                            <input type="radio" name="status" id="user" value="user" {{ $atribut->status == 'user' ? 'checked' : '' }}>
                            <label for="user">User</label>
                        </div>
                    </div>

                </div>
            </div>

            {{-- footer berisi tombol kembali dan submit --}}
            <div class="flex justify-between">
                <a href="{{ route('admin.daftarUser') }}" class="text-pink-400 p-2 bg-white border border-pink-400 rounded-md hover:text-white hover:bg-pink-400">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali
                </a>
                <button type="submit" class="text-green-600 p-2 bg-white border border-green-600 rounded-md hover:text-white hover:bg-green-600">
                    <i class="fas fa-upload mr-1"></i>
                    Update User
                </button>
            </div>
        </form>

        @endforeach        
    </div>

</div>
@endsection