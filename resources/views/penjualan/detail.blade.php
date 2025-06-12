@extends('layouts.app') {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Detail Penjualan') {{-- Menentukan judul tab browser --}}

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex bd-highlight">
                <div class="p-2 bd-highlight">
                    <h5>Detail Penjualan</h5>
                </div>
                <div class="ms-auto p-2 bd-highlight">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ url('penjualan') }}">
                        <i class="fa-solid fa-arrow-left"></i> Kembali {{-- Tombol kembali ke daftar penjualan --}}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- Informasi Umum Transaksi --}}
            <table class="table table-borderless">
                <tr>
                    <td width="15%"><b>Nomor Transaksi</b></td>
                    <td width="1%">:</td>
                    <td>{{ $penjualan->id }}</td> {{-- ID penjualan --}}
                </tr>
                <tr>
                    <td><b>Kasir</b></td>
                    <td>:</td>
                    <td>{{ $penjualan->kasir->username }}</td> {{-- Nama kasir dari relasi --}}
                </tr>
                <tr>
                    <td><b>Pembeli</b></td>
                    <td>:</td>
                    <td>{{ $penjualan->pembeli->nama }}</td> {{-- Nama pembeli dari relasi --}}
                </tr>
                <tr>
                    <td><b>Tanggal</b></td>
                    <td>:</td>
                    <td>{{ $penjualan->tanggal_pesan }}</td> {{-- Tanggal transaksi --}}
                </tr>
            </table>
            <h5>Daftar Barang</h5>
            <hr>
            <div class="table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $tot = 0; @endphp {{-- Inisialisasi total harga --}}
                        @foreach ($detail as $d => $dd)
                            <tr>
                                <td>{{ $d + 1 }}</td> {{-- Nomor urut --}}
                                <td>{{ $dd->barang->nama }}</td> {{-- Nama barang --}}
                                <td>{{ $dd->jumlah }}</td> {{-- Jumlah barang --}}
                                <td>Rp. {{ number_format($dd->barang->harga, 0, '.', '.') }}</td> {{-- Harga satuan --}}
                                <td>Rp. {{ number_format($dd->total_harga, 0, '.', '.') }}</td> {{-- Total per item --}}
                                @php $tot += $dd->total_harga; @endphp {{-- Tambah ke total keseluruhan --}}
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right"><b>Total :</b></td>
                            <td><b>Rp. {{ number_format($tot, 0, '.', '.') }}</b></td> {{-- Total seluruh transaksi --}}
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- Tombol Cetak PDF --}}
        <div class="card-footer p-2">
            <a href="{{ url('cetak/detailpenjualan/' . $penjualan->id) }}" target="_blank" class="btn btn-success">
                <i class="fa-solid fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    </div>
@endsection
