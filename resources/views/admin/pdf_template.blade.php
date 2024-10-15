<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: calc(100% - 2px);
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan Transaksi Keuangan</h1>
    <h4>Tanggal {{ $showTglAwal }} hingga {{ $showTglAkhir }}.</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pendapatan</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $tanggalPendapatan[$index] }}</td>
                    <td> Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $item->metode_pembayaran }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6">Total Pendapatan: Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
