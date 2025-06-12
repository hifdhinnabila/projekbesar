@extends('layouts.app')  {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Daftar Kategori') {{-- Menentukan judul tab browser --}}

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Data Kategori</h2>
        {{-- form pencarian berdasarkan kategor --}}
        <form action="{{ route('kategori.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari kategori..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <div class="mb-3">
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    {{-- Tampilkan notifikasi sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

     {{-- Menampilkan daftar kategori jika data tersedia --}}
    @if($kategori->count())
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        @foreach($kategori as $item)
            <div class="col">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-3 text-center">
                        <h6 class="card-title mb-2">{{ $item->nama }}</h6>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination untuk navigasi antar halaman data --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $kategori->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
    @else
    {{-- Tampilkan pesan jika tidak ada data --}}
        <div class="alert alert-secondary text-center mt-4">Tidak ada data barang</div>
    @endif
</div>
@endsection
