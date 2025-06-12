@extends('layouts.app') {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Daftar Penjualan') {{-- Menentukan judul tab browser --}}

@section('content')
    @include('message.message') {{-- Menampilkan notifikasi pesan (sukses/gagal) --}}
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex bd-highlight">
                <div class="p-2 bd-highlight">
                    <h5>Data Penjualan </h5>
                </div>
                <div class="ms-auto p-2 bd-highlight">
                    <a class="btn btn-primary btn-sm" href="{{ url('penjualan/create') }}">Tambah Penjualan</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Form Filter Tanggal -->
            <form action="" method="get">
                <div class="row align-items-center">
                    <div class="col-md-3">
                <input type="date" name="tgl_awal" class="form-control">
                </div>
                <div class="col-md-1 text-center">
                    <span>s/d</span> {{-- Separator tanggal --}}
                </div>
                <div class="col-md-3">
                    <input type="date" name="tgl_akhir" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="submit" value="Cari" class="btn btn-outline-primary">
                </div>
                <div class="col-md-3 d-flex flex-row-reverse bd-highlight">
                    <a href="{{ url('cetak/penjualan') }}" target="_blank" class="btn btn-outline-danger bd-highlight">
                        <i class="fa-solid fa-file-pdf"></i> Cetak PDF {{-- Tombol cetak PDF --}}
                    </a>
                </div>
            </div>
            </form>
            <table class="table table-condensed table-hover mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kasir</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($penjualans->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data!</td>
                        </tr>
                    @else
                        @foreach($penjualans as $d => $r)
                            <tr>
                                <td>{{ $d + 1 }}</td> {{-- Nomor urut --}}
                                <td>{{ $r->kasir->username }}</td> {{-- Nama kasir dari relasi --}}
                                <td>{{ $r->pembeli->nama }}</td> {{-- Nama pembeli dari relasi --}}
                                <td>{{ $r->tanggal_pesan }}</td> {{-- Tanggal transaksi --}}
                                <td>
                                    <form action="{{ url('penjualan/' . $r->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ url('penjualan/' . $r->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <input onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" type="submit" class="btn btn-danger btn-sm" value="Hapus">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $penjualans->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
    </div>
    </div>
@endsection
