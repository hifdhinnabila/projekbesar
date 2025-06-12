@extends('layouts.app') {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Daftar Barang') {{-- Menentukan judul tab browser --}}

@section('content')
<div class="container mt-4">

    {{-- Menampilkan flash message jika ada (berhasil atau gagal) --}}
    @include('message.message')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Header dan Form Pencarian --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Data Barang</h2>
        {{-- Form pencarian berdasarkan nama barang --}}
        <form action="{{ route('barang.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari barang..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    {{-- Tombol Tambah --}}
    <div class="mb-3">
        <a href="{{ route('barang.create') }}" class="btn btn-primary">Tambah Barang</a>
    </div>

    {{-- Cek apakah ada data barang yang ditampilkan --}}
    @if($barangs->count())
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($barangs as $index => $barang)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        
                        {{-- Tampilkan gambar barang jika ada --}}
                        @if ($barang->gambar)
                            <div class="text-center mt-3">
                                <img src="{{ asset('storage/' . $barang->gambar) }}" width="120" height="120" class="img-fluid rounded">
                            </div>
                        @else
                        {{-- Jika tidak ada gambar --}}
                            <div class="bg-light d-flex justify-content-center align-items-center" style="height: 150px;">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif

                        {{-- Detail Barang --}}
                        <div class="card-body">
                            <h5 class="card-title mb-1">{{ $barang->nama }}</h5>
                            <p class="card-text mb-1"><strong>Kategori:</strong> {{ $barang->kategori->nama }}</p>
                            <p class="card-text mb-1"><strong>Stok:</strong> {{ $barang->stok }}</p>
                            <p class="card-text mb-1"><strong>Harga:</strong> Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

         {{-- Menampilkan pagination jika data lebih dari satu halaman --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $barangs->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
    @else
    {{-- Jika tidak ada data barang sama sekali --}}
        <div class="alert alert-secondary text-center mt-4">Tidak ada data barang</div>
    @endif

</div>
@endsection
