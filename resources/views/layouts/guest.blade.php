<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'BPR BDP') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
    @livewireStyles
    @stack('styles')
</head>

<body>
    {{-- ====================================================== --}}
    {{--        NAVBAR PINTAR (BERUBAH SESUAI STATUS LOGIN)       --}}
    {{-- ====================================================== --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('halaman.index') }}">BPR BDP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('halaman.index') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengajuan.cek') }}">Cek Pengajuan</a></li>
                    @guest
                        {{-- TAMPILAN UNTUK PENGUNJUNG (GUEST) --}}
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                        </li>
                    @endguest
                    @auth
                        {{-- TAMPILAN UNTUK PENGGUNA YANG SUDAH LOGIN --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                                    </li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">My Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    {{-- KONTEN UTAMA HALAMAN --}}
    <main class="py-3">
        <div class="container">
            <div class="row justify-content-center">
                @if (request()->routeIs('pengajuan.cek'))
                    <div class="col-lg-12" style="margin-bottom: 70px;">
                    @else
                        <div class="col-lg-6" style="margin-bottom: 70px;">
                @endif
                {{-- PESAN SESSI --}}
                @php
                    $showLogo =
                        request()->routeIs('login') ||
                        request()->routeIs('register') ||
                        request()->routeIs('password.request');
                @endphp
                @if ($showLogo)
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo BPR BDP" style="max-width: 300px;">
                    </div>
                @endif
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    {{-- FOOTER --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto w-100 position-fixed bottom-0 start-0">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'BPR BDP') }}. All Rights Reserved.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
