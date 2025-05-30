@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Foto lingkaran/logo --}}
    <div class="text-center mb-4">
        <img src="{{ asset('images/home.jpg') }}" class="rounded-circle" alt="Logo Indoapril" width="150" height="150">
    </div>

    {{-- Judul --}}
    <h2 class="text-center">Selamat Datang di <span style="color:#CD5C5C">Indoapril</span>!</h2>
    <p class="text-center text-muted">Manajemen stok dan transaksi kini lebih mudah ✨</p>

    {{-- Stat Cards --}}
    <div class="row text-center mt-4">
        <div class="col-md-3 mb-3">
            <div class="card p-3 shadow-sm border-0">
                <div class="text-success mb-2">
                    <i class="fas fa-coins fa-2x"></i>
                </div>
                <h6>Total Pendapatan</h6>
                <h5 class="text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3 shadow-sm border-0">
                <div class="text-primary mb-2">
                    <i class="fas fa-boxes fa-2x"></i>
                </div>
                <h6>Jumlah Barang</h6>
                <h5 class="text-primary">{{ $jumlahBarang }}</h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3 shadow-sm border-0">
                <div class="text-warning mb-2">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
                <h6>Total Penjualan</h6>
                <h5 class="text-warning">{{ $jumlahPenjualan }}</h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card p-3 shadow-sm border-0">
                <div class="text-danger mb-2">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <h6>Stok Rendah</h6>
                <h5 class="text-danger">{{ $barangStokRendah->count() }} Barang</h5>
            </div>
        </div>
    </div>

    {{-- Statistik Hari Ini --}}
    <div class="row text-center mt-3">
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm border-0 bg-light">
                <h6 class="text-muted">Pendapatan Hari Ini</h6>
                <h5 class="text-success">Rp {{ number_format($rupiahHariIni, 0, ',', '.') }}</h5>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm border-0 bg-light">
                <h6 class="text-muted">Barang Terjual Hari Ini</h6>
                <h5 class="text-info">{{ $barangHariIni }}</h5>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm border-0 bg-light">
                <h6 class="text-muted">Transaksi Hari Ini</h6>
                <h5 class="text-primary">{{ $jumlahTransaksiHariIni }}</h5>
            </div>
        </div>
    </div>

    {{-- Tabel Barang Stok Rendah --}}
    <div class="mt-5">
        <h5><i class="fas fa-box-open"></i> Barang dengan Stok Rendah (≤ 5)</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangStokRendah as $index => $barang)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Semua stok aman 🎉</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
