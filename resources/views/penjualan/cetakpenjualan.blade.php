<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 20px;
            color: #333;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .sub-header {
            text-align: center;
            font-size: 13px;
            margin-top: 5px;
            color: #555;
        }

        hr {
            border: 1px solid #aaa;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .period {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px 6px;
        }

        th {
            background-color: #eaeaea;
            font-weight: bold;
            text-align: center;
        }

        td {
            vertical-align: top;
        }

        td.center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Penjualan Barang</h1>
        <div class="sub-header">INDOAPRIL</div>
    </div>

    <hr>

    @if(isset($tgl_awal) && isset($tgl_akhir))
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($tgl_awal)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($tgl_akhir)->format('d-m-Y') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kasir</th>
                <th>Pembeli</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @if($penjualan->isEmpty())
                <tr>
                    <td colspan="4" style="text-align:center;">Tidak ada data!</td>
                </tr>
            @else
                @foreach($penjualan as $d => $r)
                    <tr>
                        <td class="center">{{ $d + 1 }}</td>
                        <td>{{ $r->kasir->username }}</td>
                        <td>{{ $r->pembeli->nama }}</td>
                        <td class="center">{{ \Carbon\Carbon::parse($r->tanggal_pesan)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y') }}
    </div>

</body>
</html>
