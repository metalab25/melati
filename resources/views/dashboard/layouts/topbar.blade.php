<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link title">{{ $title }}</a></li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/logo_simelati.png') }}" class="shadow user-image rounded-circle"
                        alt="User Image" />
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('assets/img/logo_simelati.png') }}" class="shadow rounded-circle"
                            alt="User Image" />
                        <p>
                            {{ Auth::user()->name }}
                        </p>
                    </li>
                    <li class="user-footer">
                        {{-- <a href="#" class="btn btn-warning">Ganti Password</a> --}}
                        <a href="{{ route('password.change') }}" class="py-2 btn btn-warning btn-sm float-start">
                            Ganti Password
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" class="py-1 btn btn-danger btn-sm float-end"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sign Out') }}
                            </x-dropdown-link>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
