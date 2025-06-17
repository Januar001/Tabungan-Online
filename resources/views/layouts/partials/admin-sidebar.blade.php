<nav class="sidebar text-white">
    <div class="position-sticky pt-3">
        <h4 class="px-3">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.pengajuan.*') ? 'active bg-primary' : '' }}"
                    href="{{ route('admin.pengajuan.index') }}">
                    <i class="bi bi-file-earmark-text"></i> Pengajuan Rekening
                </a>
            </li>
            @if (auth()->user()->isSuperAdmin())
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-primary' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <i class="bi bi-person-gear"></i> Manajemen User
                    </a>
                </li>
            @endif
        </ul>

        <hr>

        <div class="px-3">
            <a class="btn btn-dark w-100" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>
