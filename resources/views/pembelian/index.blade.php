@extends('layouts.app') {{-- Menggunakan layout utama --}}

@section('title', 'Daftar Pembelian') {{-- Judul halaman --}}

@push('styles')
{{-- Menyisipkan file CSS khusus untuk halaman pembelian --}}
<link rel="stylesheet" href="{{ asset('css/pembelian.css') }}">
@endpush

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Pembelian</h2>

    <!-- Filter -->
    <form action="{{ route('pembelian.index') }}" method="GET" class="row g-2 align-items-center mb-4">
        <div class="col-md-6 d-flex align-items-center gap-2">
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            <span class="mx-1">s/d</span>
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3">
            <select name="supplier_id" class="form-control">
                <option value="">-- Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Tombol Tambah -->
    <div class="mb-3">
        <a href="{{ route('pembelian.create') }}" class="btn btn-success"></i> Tambah Pembelian</a>
    </div>

    {{-- Notifikasi sukses atau error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   {{-- Cek apakah ada data pembelian --}}
    @if($pembelians->count())
        <div class="feed-container">
            @foreach($pembelians as $item)
                <div class="feed-item d-flex gap-3 mb-4 p-3 rounded shadow-sm">
                    <div class="feed-icon">
                        <i class="fa fa-box fa-2x text-primary"></i> {{-- Icon box --}}
                    </div>
                    <div class="feed-content flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-1">{{ $item->barang->nama }}</h5>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                        </div>
                        <p class="mb-1"><strong>Supplier:</strong> {{ $item->supplier->nama }}</p>
                        <p class="mb-1"><strong>Jumlah:</strong> {{ $item->jumlah }}</p>
                        <div class="d-flex gap-2 mt-2">
                            <a href="{{ route('pembelian.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('pembelian.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
    {{-- Jika tidak ada data pembelian --}}
        <div class="alert alert-warning mt-4">Tidak ada data pembelian.</div>
    @endif

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
         {{-- Pagination tetap membawa query string pencarian --}}
        {{ $pembelians->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
