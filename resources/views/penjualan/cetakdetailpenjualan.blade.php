<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 20px;
            margin: 30px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 26px;
        }

        .info {
            margin-bottom: 25px;
            line-height: 1.8;
        }

        .info p {
            margin: 6px 0;
            font-size: 16px;
        }

        hr {
            margin: 15px 0;
            border: 0;
            border-top: 1px solid #999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 16px;
        }

        th, td {
            border: 1px solid #999;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            text-align: center;
            font-size: 16px;
        }

        td.center {
            text-align: center;
        }

        tfoot td {
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Detail Transaksi Penjualan</h2>
    </div>

    <div class="info">
        <p><strong>Nomor Transaksi</strong>: {{ $penjualan->id }}</p>
        <p><strong>Kasir</strong>: {{ $penjualan->kasir->username }}</p>
        <p><strong>Pembeli</strong>: {{ $penjualan->pembeli->nama }}</p>
        <p><strong>Tanggal Transaksi</strong>: {{ \Carbon\Carbon::parse($penjualan->tanggal_pesan)->format('d-m-Y') }}</p>
    </div>

    <h4>Daftar Barang</h4>
    <hr>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th class="center">Jumlah</th>
                <th class="center">Harga</th>
                <th class="center">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $tot = 0; @endphp
            @foreach ($detail as $d => $dd)
                <tr>
                    <td class="center">{{ $d + 1 }}</td>
                    <td>{{ $dd->barang->nama }}</td>
                    <td class="center">{{ $dd->jumlah }}</td>
                    <td class="center">Rp {{ number_format($dd->barang->harga, 0, ',', '.') }}</td>
                    <td class="center">Rp {{ number_format($dd->total_harga, 0, ',', '.') }}</td>
                    @php $tot += $dd->total_harga; @endphp
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right"><b>Total:</b></td>
                <td class="center"><b>Rp {{ number_format($tot, 0, ',', '.') }}</b></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        INDOAPRIL {{ date('Y') }}
    </div>

</body>
</html>
