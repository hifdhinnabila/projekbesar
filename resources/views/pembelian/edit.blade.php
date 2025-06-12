@extends('layouts.app') {{-- Menggunakan layout utama --}}

@section('title', 'Edit Pembelian') {{-- Judul halaman --}}

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Pembelian</h2>

    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
        @csrf {{-- Token keamanan CSRF --}}
        @method('PUT') {{-- Spoofing method PUT untuk update data --}}

        <!-- Pilih Barang -->
        <div class="mb-3">
            <label for="barang_id" class="form-label">Barang</label>
            <select name="barang_id" class="form-control @error('barang_id') is-invalid @enderror" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ $barang->id == $pembelian->barang_id ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
              {{-- Tampilkan pesan error jika ada --}}
            @error('barang_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pilih Supplier -->
        <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier->id == $pembelian->supplier_id ? 'selected' : '' }}>
                        {{ $supplier->nama }}
                    </option>
                @endforeach
            </select>
              {{-- Tampilkan pesan error jika ada --}}
            @error('supplier_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Jumlah Pembelian -->
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $pembelian->jumlah) }}" required min="1">
              {{-- Tampilkan pesan error jika ada --}}
            @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tanggal Pembelian -->
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Pembelian</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $pembelian->tanggal) }}" required>
              {{-- Tampilkan pesan error jika ada --}}
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol -->
        <button type="submit" class="btn btn-success">Update Pembelian</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
