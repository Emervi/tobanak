<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Barang</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropzone {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s ease;
            position: relative;
        }
        .dropzone.dragover {
            border-color: #3490dc;
        }
        .dropzone img { 
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .dropzone .file-name {
            margin-top: 10px;
            color: #555;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <form action="{{ route('dropzone.store') }}" method="POST" enctype="multipart/form-data" id="barangForm">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Barang:</label>
                <input type="text" name="nama" id="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok Barang:</label>
                <input type="number" name="stok" id="stok" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Barang:</label>
                <div id="dropzone" class="dropzone">
                    <span>Klik di sini atau drag & drop gambar</span>
                    <img id="preview" src="" alt="" style="display: none;">
                    <div id="file-name" class="file-name"></div>
                </div>
                <input type="file" name="image" id="image" class="hidden" accept="image/*" required>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Submit
                </button>
            </div>

        </form>
    </div>

    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('image');
        const previewImage = document.getElementById('preview');
        const fileName = document.getElementById('file-name');

        dropzone.addEventListener('click', function () {
            fileInput.click();
        });

        dropzone.addEventListener('dragover', function (event) {
            event.preventDefault();
            event.stopPropagation();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', function (event) {
            event.preventDefault();
            event.stopPropagation();
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', function (event) {
            event.preventDefault();
            event.stopPropagation();
            dropzone.classList.remove('dragover');

            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                updatePreview(files[0]);
            }
        });

        fileInput.addEventListener('change', function (event) {
            const files = event.target.files;
            if (files.length > 0) {
                updatePreview(files[0]);
            }
        });

        function updatePreview(file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                fileName.textContent = file.name;
            }
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>
