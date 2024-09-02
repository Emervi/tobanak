@extends('layouts.sidebar')

@section('title', 'Daftar User')

@section('content')

    {{-- tombol kembali --}}
    <div class="w-full mx-auto mt-10 mb-12">

        <div class="mt-7 w-11/12 mx-auto flex flex-col">

            {{-- tombol kembali dan tambah --}}
            <div class="flex items-start justify-between mb-2">

                {{-- div kosong --}}
                <div></div>

                <a href="{{ route('admin.tambahUser') }}"
                    class="text-green-500 text-center p-2 bg-white border border-green-500 rounded-md hover:text-white hover:bg-green-600">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah User
                </a>

            </div>

            {{-- notifikasi CRUD barang dan fitur pencarian barang --}}
            <div class="flex justify-between items-center w-1/3">

                <form action="{{ route('admin.daftarUser') }}" method="POST" class="flex gap-1 w-full">
                    @csrf

                    {{-- form pencarian barang --}}
                    <div class="flex gap-1 w-full">
                        <button type="submit"
                            class="text-orange-400 py-1.5 px-2 bg-white border border-orange-400 rounded-md hover:text-white hover:bg-orange-400">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" name="keyword_user" placeholder="Masukan username"
                            class="bg-white w-full p-1 shadow rounded-sm focus:outline-none">
                    </div>

                    {{-- tombol untuk mengembalikan pencarian seperti semula --}}
                    <a href="{{ route('admin.daftarUser') }}"
                        class="text-blue-400 py-2 px-2 bg-white border border-blue-400 rounded-md hover:text-white hover:bg-blue-400">
                        <i class="fas fa-sync"></i>
                    </a>

                </form>

                @if (session('success'))
                    <div class="fixed top-4 right-4 bg-green-700 border border-green-800 text-white px-4 py-3 rounded shadow-lg transition-transform transform-gpu duration-300 ease-in-out"
                        role="alert">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">{{ session('success') }}</span>
                            <button
                                onclick="this.parentElement.parentElement.style.transform='translateX(100%)'; setTimeout(() => this.parentElement.parentElement.remove(), 300);"
                                class="ml-4 text-green-500 hover:text-green-700">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

            </div>

            <div class="container w-full bg-white p-3 shadow-xl mt-5 rounded-xl relative overflow-hidden">

                <h1 class="text-2xl font-bold text-center">Daftar User</h1>

                <div class="overflow-x-auto overflow-y-clip">
                    {{-- table daftar barang --}}
                    <table class="min-w-full bg-white border border-gray-200 mt-3 text-center">
                        <thead class="border border-b-black">
                            <th class="p-2">No</th>
                            <th class="py-1">Username</th>
                            <th class="py-1">Nama</th>
                            <th class="py-1">Email</th>
                            <th class="py-1">Status</th>
                            <th class="py-1">Cabang</th>
                            <th class="text-center w-1/12">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="odd:bg-gray-200 hover:bg-gray-300">
                                    @if ($offset > -1)
                                        <td>{{ $offset + $index + 1 }}</td>
                                    @else
                                        <td>{{ $index + 1 }}</td>
                                    @endif
                                    <td>{{ $user->username }}</td>
                                    <td>{{ ucwords($user->name) }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>
                                        @empty($user->id_cabang)
                                            Online
                                        @else
                                            {{ $user->nama_cabang }}
                                        @endempty
                                    </td>
                                    <td class="flex justify-center my-3">

                                        <div x-data="{ dropdown: false, isActive: false }" @click.away="isActive = false"
                                            class="relative inline-block">
                                            <button @click="dropdown = !dropdown; isActive = !isActive"
                                                :class="isActive ?
                                                    'bg-gray-400 {{ $loop->last ? 'rounded-t' : 'rounded-b' }}' :
                                                    ''"
                                                class="hover:bg-gray-400 px-2 rounded-full p-1">
                                                <i class="fas fa-bars text-xl"></i>
                                            </button>

                                            <div x-show="dropdown" @click.away="dropdown = false"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                class="origin-top-right p-1 absolute right-0 w-24 shadow-lg bg-gray-400 z-10 {{ $loop->first && $loop->last ? 'rounded-b rounded-tl top-0 w-48' : ($loop->last ? 'bottom-full rounded-t rounded-bl' : 'rounded-b rounded-tl') }}"
                                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button">

                                                <div class="flex gap-1 {{ $loop->first && $loop->last ? '' : 'flex-col' }}"
                                                    role="none">
                                                    <a href="{{ route('admin.editUser', [$user->id_user]) }}"
                                                        class="text-blue-600 py-1 bg-white border border-blue-600 rounded-md text-center hover:text-white hover:bg-blue-600 {{ $loop->first && $loop->last ? 'w-1/2' : 'w-full' }}">
                                                        <i class="fas fa-pen mr-1"></i>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.hapusUser', [$user->id_user]) }}"
                                                        method="POST"
                                                        class="{{ $loop->first && $loop->last ? 'w-1/2' : 'w-full' }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button
                                                            class="text-red-600 w-full py-1 bg-white border border-red-600 rounded-md hover:text-white hover:bg-red-600"
                                                            onclick="confirmDelete(event)">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            @if ($offset > -1)
                                {{-- pagination --}}
                                {{ $users->links() }}
                            @endif

                            @if (empty($user->name))
                                <tr>
                                    <td colspan="9" class="text-center font-bold text-xl p-3">User tidak ditemukan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
