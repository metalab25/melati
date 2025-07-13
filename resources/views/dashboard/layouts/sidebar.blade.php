<aside class="app-sidebar shadow" data-bs-theme="light">
    <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
            <img src="{{ asset('assets/img/logo_simelati.png') }}" alt="AdminLTE Logo" class="brand-image">
            <span class="brand-text fw-light text-uppercase">{{ config('app.alias') }}</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link  {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staf.index') }}"
                        class="nav-link  {{ request()->segment(1) == 'staf' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Staf</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('data-tamu.index') }}"
                        class="nav-link  {{ request()->segment(1) == 'data-tamu' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-secret"></i>
                        <p>Data Tamu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}"
                        class="nav-link  {{ request()->segment(1) == 'laporan-kunjungan' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-memo"></i>
                        <p>Laporan</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
