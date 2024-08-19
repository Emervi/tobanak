<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>

<body>

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

</body>

</html>
