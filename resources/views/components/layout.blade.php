{{-- File: resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'BPR BDP') }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        .navbar.scrolled {
            background-color: rgba(33, 37, 41, 0.9) !important;
            backdrop-filter: blur(5px);
            transition: background-color 0.4s ease-in-out;
        }
    </style>
    @stack('styles')
</head>
<body data-bs-spy="scroll" data-bs-target=".navbar">

    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('halaman.index') }}">BPR BDP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('halaman.index') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('halaman.index') }}#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('halaman.index') }}#produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengajuan.cek') }}">Cek Pengajuan</a></li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-primary fw-bold" href="{{ route('halaman.form') }}">Buka Rekening</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        {{-- Ini adalah area kosong tempat konten spesifik halaman akan disisipkan --}}
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'BPR BDP') }}. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Ini adalah area kosong tempat script spesifik halaman akan disisipkan --}}
    @stack('scripts')
</body>
</html>