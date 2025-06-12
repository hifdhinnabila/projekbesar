@extends('layouts.app') {{-- Menggunakan layout utama dari file layouts.app --}}

@section('title', 'Tambah Penjualan') {{-- Menentukan judul tab browser --}}

@section('content')
@if (session('error'))
{{-- Tampilkan notifikasi error jika ada session 'error' --}}
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif

<form action="{{ url('penjualan') }}" method="POST">
    @csrf
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>1. Pilih Pembeli</h5>
            <a class="btn btn-outline-secondary btn-sm" href="{{ url('penjualan') }}">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <select name="pembeli_id" class="form-select" required>
                    <option value="">Pilih Pembeli</option>
                    @foreach ($pembelis as $p)
                        <option value="{{ $p->id }}" {{ old('pembeli_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
                @error('pembeli_id')
                {{-- Validasi error pembeli --}}
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Bagian Barang -->
        <div class="col-md-9">
            <div class="card mt-3">
                <div class="card-header">
                    <h5>2. Pilih Barang</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <select class="form-select barang_id">
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $b)
                                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control jumlahdibeli" placeholder="Jumlah">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary addbarang">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    {{-- Tabel barang yang sudah ditambahkan --}}
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="innerBarang"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Pembayaran -->
        <div class="col-md-3">
            <div class="card mt-3">
                <div class="card-header">
                    <h5>3. Pembayaran</h5>
                </div>
                <div class="card-body">
                     {{-- Input tersembunyi untuk total harga dan jumlah barang --}}
                    <input type="hidden" name="total_harga" id="totalharga" value="0">
                    <input type="hidden" id="jmlbarangdibeli" value="0">

                      {{-- Tampilan total harga --}}
                    <h6>Total Harga</h6>
                    <h3 class="text-success" id="vtotalharga">Rp. 0</h3>

                    {{-- Input bayar dari pembeli --}}
                    <h6>Bayar</h6>
                    <input type="number" name="bayar" class="form-control bayar" required value="{{ old('bayar') }}">

                    <hr>
                    {{-- Kembalian otomatis --}}
                    <h6>Kembalian</h6>
                    <h3 class="text-secondary" id="vkembalian">Rp. 0</h3>

                    <button type="submit" class="btn btn-primary w-100 mt-2">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
// Fungsi format angka ke format Rupiah
function formatRupiah(angka, prefix){
    var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
        split    = number_string.split(','),
        sisa     = split[0].length % 3,
        rupiah     = split[0].substr(0, sisa),
        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

// Ketika tombol tambah barang ditekan
$(document).on('click', '.addbarang', function () {
    let barangId = $('.barang_id').val();
    let jumlah = parseInt($('.jumlahdibeli').val() || 0);
    if (!barangId || jumlah <= 0) {
        alert("Pilih barang dan masukkan jumlah dengan benar.");
        return;
    }

    // Ambil data barang dari API
    $.getJSON('/api/barang/' + barangId, function (barang) {
        let subtotal = barang.harga * jumlah;
        let totalHarga = parseInt($('#totalharga').val()) + subtotal;

        // Tambahkan ke tabel barang
        $('#innerBarang').append(`
            <tr class="databrg">
                <td>
                    <input type="hidden" name="barang_idnya[]" value="${barang.id}"/>
                    ${barang.nama}
                </td>
                <td>
                    <input type="hidden" name="jumlahdibeli[]" value="${jumlah}"/>
                    ${jumlah}
                </td>
                <td>
                    <input type="hidden" name="hargabarang[]" value="${barang.harga}"/>
                    Rp. ${formatRupiah(barang.harga)}
                </td>
                <td>
                    <input type="hidden" name="totaldibeli[]" value="${subtotal}"/>
                    Rp. ${formatRupiah(subtotal)}
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm hapusbarang" data-harga="${subtotal}">Hapus</button>
                </td>
            </tr>
        `);

        // Update total harga
        $('#totalharga').val(totalHarga);
        $('#vtotalharga').text('Rp. ' + formatRupiah(totalHarga));
        $('#jmlbarangdibeli').val(parseInt($('#jmlbarangdibeli').val()) + 1);

        // Reset input
        $('.barang_id').val('');
        $('.jumlahdibeli').val('');
    });
});

// Hapus baris barang
$(document).on('click', '.hapusbarang', function () {
    let harga = parseInt($(this).data('harga'));
    $(this).closest('tr').remove();

    // Update total harga
    let totalHarga = parseInt($('#totalharga').val()) - harga;
    $('#totalharga').val(totalHarga);
    $('#vtotalharga').text('Rp. ' + formatRupiah(totalHarga));

    $('#jmlbarangdibeli').val(parseInt($('#jmlbarangdibeli').val()) - 1);
});

// Hitung kembalian saat bayar diinput
$(document).on('input', '.bayar', function () {
    let bayar = parseInt($(this).val() || 0);
    let total = parseInt($('#totalharga').val());
    let kembali = bayar - total;
    $('#vkembalian').text('Rp. ' + formatRupiah(kembali));
});
</script>

@if (old('barang_idnya'))
<script>
$(function () {
    let ids = {!! json_encode(old('barang_idnya')) !!};
    let jmls = {!! json_encode(old('jumlahdibeli')) !!};
    let hargas = {!! json_encode(old('hargabarang')) !!};
    let totals = {!! json_encode(old('totaldibeli')) !!};
    let totalHarga = 0;

    ids.forEach((id, index) => {
        $.getJSON('/api/barang/' + id, function (barang) {
            let jumlah = jmls[index];
            let harga = hargas[index];
            let subtotal = totals[index];
            totalHarga += subtotal;

            $('#innerBarang').append(`
                <tr class="databrg">
                    <td><input type="hidden" name="barang_idnya[]" value="${barang.id}"/> ${barang.nama}</td>
                    <td><input type="hidden" name="jumlahdibeli[]" value="${jumlah}"/>${jumlah}</td>
                    <td><input type="hidden" name="hargabarang[]" value="${harga}"/>Rp. ${formatRupiah(harga)}</td>
                    <td><input type="hidden" name="totaldibeli[]" value="${subtotal}"/>Rp. ${formatRupiah(subtotal)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm hapusbarang" data-harga="${subtotal}">Hapus</button></td>
                </tr>
            `);

            $('#totalharga').val(totalHarga);
            $('#vtotalharga').text('Rp. ' + formatRupiah(totalHarga));
            $('#jmlbarangdibeli').val(index + 1);
        });
    });
});
</script>
@endif
@endpush
