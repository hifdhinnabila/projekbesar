@extends('layouts.app') {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Edit Kategori') {{-- Menentukan judul tab browser --}}

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Form Ubah Kategori</h4>
        {{-- Tombol kembali ke halaman daftar kategori --}}
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('kategori.index') }}">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

      {{-- Menampilkan pesan error validasi jika ada --}}
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
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf {{-- Token keamanan CSRF --}}
        @method('PUT') {{-- Menggunakan method PUT untuk update data --}}

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required>
            {{-- Tampilkan error jika validasi gagal --}}
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection