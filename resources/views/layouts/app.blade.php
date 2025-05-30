<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'INDOAPRIL')</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm rounded-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="{{ route('barang.index') }}">INDOAPRIL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-3">

                    <!-- Manajemen Barang -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" id="dropdownBarang" role="button" data-bs-toggle="dropdown">
                            Manajemen Barang
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('kategori.index') }}">Kategori</a></li>
                            <li><a class="dropdown-item" href="{{ route('barang.index') }}">Barang</a></li>
                        </ul>
                    </li>

                    <!-- Pembeli -->
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-bold" href="{{ route('pembeli.index') }}">Pembeli</a>
                    </li>

                    <!-- Kulakan Barang -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" id="dropdownKulakan" role="button" data-bs-toggle="dropdown">
                            Pembelian Stok
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('supplier.index') }}">Supplier</a></li>
                            <li><a class="dropdown-item" href="{{ route('pembelian.index') }}">Restok Barang</a></li>
                        </ul>
                    </li>

                    <!-- Penjualan -->
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-bold" href="{{ route('penjualan.index') }}">Penjualan</a>
                    </li>

                    <!-- User Session -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">{{ session('namayangmasuk') }}</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">Keluar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div id="page-content" class="container mt-4 p-4 bg-white rounded shadow fade-in">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow-sm rounded-top mt-4">
        <div class="container text-center p-3">
            <div class="mb-2">
                <a href="https://www.instagram.com/indoapril" class="text-danger me-3" target="_blank" data-bs-toggle="tooltip" title="Ikuti kami di Instagram">
                    <i class="bi bi-instagram fs-4"></i>
                </a>
                <a href="https://www.facebook.com/indoapril" class="text-primary me-3" target="_blank" data-bs-toggle="tooltip" title="Sukai kami di Facebook">
                    <i class="bi bi-facebook fs-4"></i>
                </a>
                <a href="https://wa.me/628123456789" class="text-success" target="_blank" data-bs-toggle="tooltip" title="Hubungi kami di WhatsApp">
                    <i class="bi bi-whatsapp fs-4"></i>
                </a>
            </div>
            <div class="fw-bold text-dark">
                © {{ date('Y') }} INDOAPRIL. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Toastr Notification -->
    @if (session('success'))
        <script>toastr.success("{{ session('success') }}");</script>
    @endif
    @if (session('error'))
        <script>toastr.error("{{ session('error') }}");</script>
    @endif

    <!-- Tooltip Activation -->
    <script>
        const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltips.map(t => new bootstrap.Tooltip(t));
    </script>

    <!-- Stack for additional JS -->
    @stack('scripts')
</body>
</html>
