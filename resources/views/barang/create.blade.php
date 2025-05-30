@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="container mt-4">

    {{-- Header dan Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Form Tambah Barang</h5>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('barang.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Tampilkan Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Barang --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
            @error('harga')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" required>
            @error('gambar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Tombol Simpan dan Batal --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
