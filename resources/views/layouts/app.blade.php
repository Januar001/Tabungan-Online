{{-- File Final: resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'BPR BDP') }}</title>

    {{-- CSS Libraries --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Aset Livewire & Styles --}}
    @livewireStyles
    @stack('styles')

    {{-- ====================================================== --}}
    {{--    PINDAHKAN SCRIPT UTAMA KE SINI DENGAN ATRIBUT 'defer' --}}
    {{-- ====================================================== --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer>
    </script>

    {{-- CSS Kustom --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        #mainNavbar {
            background-color: #212529;
            /* Dibuat solid agar konsisten di semua halaman */
        }
    </style>
</head>

<body>
    {{-- Navbar (Layout Induk) --}}
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('halaman.index') }}">BPR BDP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('halaman.index') }}">Beranda</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('halaman.form') }}">Pengajuan</a></li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0"><a href="{{ route('login') }}"
                                class="btn btn-outline-light btn-sm">Login</a></li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0"><a href="{{ route('register') }}"
                                class="btn btn-primary btn-sm">Daftar</a></li>
                    @endguest
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                {{-- SESUDAH --}}
                                @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                    {{-- Menu untuk Admin & Super Admin --}}
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                                    </li>
                                @else
                                    {{-- Menu untuk Nasabah Biasa --}}
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">My Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pengajuan.riwayat') }}">Riwayat
                                            Pengajuan</a></li>
                                @endif
                                {{-- Menu yang bisa diakses semua user yang login --}}
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                            </form>
                        </li>
                    </ul>
                    </li>
                @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">

        @if (request()->routeIs('pengajuan.riwayat'))
            {{ $slot }}
        @else
            @yield('content')
        @endif


    </main>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'BPR BDP') }}. All Rights Reserved.</p>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>

</html>
