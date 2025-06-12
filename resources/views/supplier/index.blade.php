@extends('layouts.app') {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Daftar Supplier') {{-- Menentukan judul tab browser --}}

@section('content') 
<div class="container mt-4">

    {{-- Header & Pencarian --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Data Supplier</h2>
        <form action="{{ route('supplier.index') }}" method="GET" class="d-flex">
            <input type="text" name="nama_sup" class="form-control me-2" placeholder="Cari supplier..." value="{{ request('nama_sup') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <div class="mb-3">
        <a href="{{ route('supplier.create') }}" class="btn btn-primary">Tambah Supplier</a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Accordion berisi daftar supplier --}}
    @if($suppliers->count())
    <div class="accordion" id="supplierAccordion">
        @foreach($suppliers as $index => $supplier)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-{{ $supplier->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $supplier->id }}" aria-expanded="false" aria-controls="collapse-{{ $supplier->id }}">
                        {{ $loop->iteration + ($suppliers->currentPage() - 1) * $suppliers->perPage() }}. {{ $supplier->nama }}
                    </button>
                </h2>
                {{-- Konten yang muncul saat accordion dibuka --}}
                <div id="collapse-{{ $supplier->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $supplier->id }}" data-bs-parent="#supplierAccordion">
                    <div class="accordion-body">
                        <p><strong>Alamat:</strong> {{ $supplier->alamat }}</p>
                        <p><strong>Kode Pos:</strong> {{ $supplier->kode_pos ?? '-' }}</p>
                        <div>
                            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
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
    @else
        <p class="text-muted">Tidak ada data supplier.</p>
    @endif

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $suppliers->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
@endsection
