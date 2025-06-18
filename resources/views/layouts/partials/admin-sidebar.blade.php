<nav class="admin-sidebar bg-dark text-white d-flex flex-column p-3">
    {{-- Header Sidebar --}}
    <div>
        <h4 class="px-2 fw-bold">Admin Panel</h4>
        <hr class="bg-secondary">
    </div>

    {{-- Menu Utama --}}
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}" href="{{ route('admin.pengajuan.index') }}">
                <i class="bi bi-file-earmark-text me-2"></i> Pengajuan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->routeIs('admin.nasabah.*') ? 'active' : '' }}" href="{{ route('admin.nasabah.index') }}">
                <i class="bi bi-people-fill me-2"></i> Nasabah
            </a>
        </li>
        @if (auth()->user()->isSuperAdmin())
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-person-gear me-2"></i> Manajemen User
                </a>
            </li>
        @endif
    </ul>

    {{-- User Dropdown di Bawah --}}
    <div class="mt-3">
        <hr class="bg-secondary">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-2" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-4 me-2"></i>
                <strong class="text-truncate" style="max-width: 150px;">{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{ route('halaman.index') }}">Lihat Situs Publik</a></li>
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile & Keamanan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </div>
    </div>
</nav>