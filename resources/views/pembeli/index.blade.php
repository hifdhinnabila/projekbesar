@extends('layouts.app')

@section('title', 'Data Pembeli')

@section('content')
<div class="container mt-4">

    {{-- Header dan Form Pencarian --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Data Pembeli</h2>
        <form action="{{ route('pembeli.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari pembeli..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    {{-- Tombol Tambah Pembeli --}}
    <div class="mb-3">
        <a href="{{ route('pembeli.create') }}" class="btn btn-primary">Tambah Pembeli</a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- List Media Style --}}
    @forelse($pembelis as $pembeli)
        <div class="card mb-3 shadow-sm">
            <div class="card-body d-flex">
                <div class="me-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        {{ strtoupper(substr($pembeli->nama, 0, 1)) }}
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-1">{{ $pembeli->nama }}</h5>
                    <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ $pembeli->jenis_kelamin }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> {{ $pembeli->alamat }}</p>
                    <p class="mb-0"><strong>No HP:</strong> {{ $pembeli->no_hp ?? '-' }}</p>
                </div>
                <div class="text-end ms-3 d-flex flex-column justify-content-center">
                    <a href="{{ route('pembeli.edit', $pembeli->id) }}" class="btn btn-warning btn-sm mb-2">Edit</a>
                    <form action="{{ route('pembeli.destroy', $pembeli->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Tidak ada data pembeli.</p>
    @endforelse

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $pembelis->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
</div>
@endsection
