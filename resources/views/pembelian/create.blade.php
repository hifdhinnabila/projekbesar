@extends('layouts.app') {{-- Menggunakan layout utama dari aplikasi --}}

@section('title', 'Tambah Pembelian') {{-- Menentukan judul halaman --}}
@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Pembelian</h2>

   {{-- Form untuk menyimpan data pembelian baru --}}
    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf {{-- Token keamanan untuk mencegah CSRF --}}

        <div class="mb-3">
            <label for="barang_id" class="form-label">Barang</label>
            <select class="form-control @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
            {{-- Tampilkan pesan error jika ada --}}
            @error('barang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->nama }}
                    </option>
                @endforeach
            </select>
            {{-- Tampilkan pesan error jika ada --}}
            @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" placeholder="Masukkan jumlah pembelian" value="{{ old('jumlah') }}" required min="1">
            {{-- Tampilkan pesan error jika ada --}}
            @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
            {{-- Tampilkan pesan error jika ada --}}
            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
