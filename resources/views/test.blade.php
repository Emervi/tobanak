<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Test</title>
</head>

<body>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="py-2 px-4 bg-gray-100 border-b text-left">Header 1</th>
          <th class="py-2 px-4 bg-gray-100 border-b text-left">Header 2</th>
          <th class="py-2 px-4 bg-gray-100 border-b text-left">Header 3</th>
          <th class="py-2 px-4 bg-gray-100 border-b text-left">Header 4</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="py-2 px-4 border-b">Data 1</td>
          <td class="py-2 px-4 border-b">Data 2</td>
          <td class="py-2 px-4 border-b">Data 3</td>
          <td class="py-2 px-4 border-b">Data 4</td>
        </tr>
        <tr>
          <td class="py-2 px-4 border-b">Data 5</td>
          <td class="py-2 px-4 border-b">Data 6</td>
          <td class="py-2 px-4 border-b">Data 7</td>
          <td class="py-2 px-4 border-b">Data 8</td>
        </tr>
      </tbody>
    </table>
  </div>
  

  <div class="relative w-full h-screen">
    <!-- This is the responsive absolute div -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-10/12 md:w-8/12 lg:w-6/12 bg-blue-500 p-4">
        <p class="text-white text-center">This is a responsive absolute div</p>
    </div>
</div>


  <div class="container mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full bg-white divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">John Doe</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">john.doe@example.com</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            <a href="#" class="ml-4 text-red-600 hover:text-red-900">Delete</a>
          </td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jane Smith</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">jane.smith@example.com</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">User</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            <a href="#" class="ml-4 text-red-600 hover:text-red-900">Delete</a>
          </td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>

    <div class="relative inline-block text-left">
        <button onclick="toggleDropdown()" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Pilih Halaman
          <!-- Ikon panah bawah -->
          <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06-.02L10 10.46l3.71-3.27a.75.75 0 111.02 1.1l-4.25 3.75a.75.75 0 01-1.02 0L5.23 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd" />
          </svg>
        </button>
      
        <!-- Dropdown menu dengan animasi -->
        <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 transform transition-all duration-300 scale-95 opacity-0 hidden">
          <div class="py-1" role="none">
            <a href="" class="text-gray-700 block px-4 py-2 text-sm">Home</a>
            <a href="" class="text-gray-700 block px-4 py-2 text-sm">Profile</a>
            <a href="" class="text-gray-700 block px-4 py-2 text-sm">Settings</a>
          </div>
        </div>
      </div>
      
      <script>
        function toggleDropdown() {
          const dropdownMenu = document.getElementById('dropdownMenu');
          
          // Toggle visibility and apply animations
          dropdownMenu.classList.toggle('hidden');
          if (!dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.remove('scale-95', 'opacity-0');
            dropdownMenu.classList.add('scale-100', 'opacity-100');
          } else {
            dropdownMenu.classList.remove('scale-100', 'opacity-100');
            dropdownMenu.classList.add('scale-95', 'opacity-0');
          }
        }
      </script>
      

    {{-- <div class="relative inline-block text-left">
        <button onclick="toggleDropdown()" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Pilih Halaman
          <!-- Ikon panah bawah -->
          <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06-.02L10 10.46l3.71-3.27a.75.75 0 111.02 1.1l-4.25 3.75a.75.75 0 01-1.02 0L5.23 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd" />
          </svg>
        </button>
      
        <!-- Dropdown menu -->
        <div id="dropdownMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
          <div class="py-1 text-black" role="none">
            <!-- Gunakan helper Laravel untuk membuat link -->
            <a href="{{ route('admin.daftarBarang') }}" class="text-gray-700 block px-4 py-2 text-sm">Home</a>
            <a href="" class="text-gray-700 block px-4 py-2 text-sm">Profile</a>
            <a href="" class="text-gray-700 block px-4 py-2 text-sm">Settings</a>
          </div>
        </div>
      </div>
      
      <script>
        function toggleDropdown() {
          document.getElementById('dropdownMenu').classList.toggle('hidden');
        }
      </script> --}}
      

    <form action="{{ route('TEST.PUT') }}" method="POST">
        @csrf
        @method('put')

        <ol>
            @foreach ($barangs as $barang)
                <li><input type="checkbox" name="distribusi[{{ $barang->id_barang }}]" value="Dikirim">
                    <label for="">{{ $barang->nama_barang }}</label>
                    <input type="hidden" name="id_barangs[]" value="{{ $barang->id_barang }}">
                </li>
            @endforeach
        </ol>

        <select name="status" id="status">
            <option value="" disabled selected>Pilih tujuan</option>
            <option value="Dikirim">Kirim</option>
            <option value="Ditolak">Tolak</option>
            <option value="Diterima">Terima</option>
        </select>
        <br><br>
        
        <select name="id_cabang" id="id_cabang">
            <option value="" disabled selected>Pilih cabang</option>
            @foreach ( $cabangs as $cabang )
                <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }}</option>
            @endforeach
        </select>
        <br><br>

        <button type="submit">Kirim</button>
    </form>

    <br><br>
    @foreach ($barangs as $barang)
        <label for="">{{ $barang->id_cabang }}</label>
        <label for="">{{ $barang->distribusi }}</label><br>
    @endforeach

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="bg-red-500 w-full p-5 mt-10 mb-10">

        <i class="fas fa-bars text-xl cursor-pointer" id="dropdownMenu" onclick="toggleDropdown()"></i>

    </div>

    <script>
        function toggleDropdown(){

        }
    </script>

</body>

</html>
