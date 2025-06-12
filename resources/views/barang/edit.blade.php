@extends('layouts.app') {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Edit Barang') {{-- Menentukan judul tab browser --}}

@section('content')
<div class="container mt-4">

    {{-- Header dan tombol kembali ke daftar barang --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Form Ubah Data Barang</h2>
        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Tampilkan error validasi --}}
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
    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Barang --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $barang->nama) }}" required>
            @error('nama')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
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
            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $barang->harga) }}" required>
            @error('harga')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Gambar --}}
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
            <small class="form-text text-muted">*Isi jika ingin mengubah gambar</small>
            @if($barang->gambar)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama }}" class="img-thumbnail" width="100" height="100">
                </div>
            @endif
            @error('gambar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
