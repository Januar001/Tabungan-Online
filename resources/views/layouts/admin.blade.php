<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }}</title>

    {{-- Aset CSS & Ikon --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @livewireStyles
    @stack('styles')

    {{-- CSS untuk layout admin responsif --}}
    <style>
        :root {
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }

        .admin-layout {
            display: flex;
        }

        .admin-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: margin-left 0.3s ease-in-out;
        }

        .admin-main-content {
            padding: 1.5rem;
            width: 100%;
            transition: margin-left 0.3s ease-in-out;
        }

        .topbar {
            height: 60px;
        }

        /* Tampilan Desktop */
        @media (min-width: 768px) {
            .admin-main-content {
                margin-left: var(--sidebar-width);
            }
        }

        /* Tampilan Mobile */
        @media (max-width: 767.98px) {
            .admin-sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .admin-sidebar.is-open {
                margin-left: 0;
            }

            .content-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1020;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .content-overlay.is-visible {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    <div class="admin-layout">
        {{-- Memanggil Sidebar --}}
        @include('layouts.partials.admin-sidebar')

        {{-- Konten Utama --}}
        <div class="admin-main-content">
            {{-- Topbar untuk tombol menu mobile & user dropdown --}}
            <header class="topbar d-flex justify-content-between align-items-center d-md-none mb-3">
                <button id="sidebarToggle" class="btn btn-dark">
                    <i class="bi bi-list fs-4"></i>
                </button>
                {{-- User dropdown bisa ditambahkan di sini untuk mobile --}}
            </header>

            {{-- Slot untuk konten halaman dinamis --}}
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Overlay untuk background saat sidebar mobile terbuka --}}
        <div class="content-overlay" id="contentOverlay"></div>
    </div>

    {{-- Aset JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const contentOverlay = document.getElementById('contentOverlay');

            // Fungsi untuk membuka sidebar
            const openSidebar = () => {
                sidebar.classList.add('is-open');
                contentOverlay.classList.add('is-visible');
            };

            // Fungsi untuk menutup sidebar
            const closeSidebar = () => {
                sidebar.classList.remove('is-open');
                contentOverlay.classList.remove('is-visible');
            };

            // Event listener untuk tombol toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (sidebar.classList.contains('is-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            }

            // Event listener untuk overlay (menutup sidebar saat area gelap diklik)
            if (contentOverlay) {
                contentOverlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>

</html>
