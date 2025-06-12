{{-- Cek apakah ada pesan di session --}}
@if (Session::has('pesan'))
    {{-- Tampilkan alert dengan class dari session (default: alert-info) --}}
    <div class="alert mt-2 {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
        {{ Session::get('pesan') }}
        {{-- Tombol untuk menutup alert --}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
