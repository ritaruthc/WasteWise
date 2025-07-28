<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/logo.png" alt="PISAH" width="32" height="32">
        <a class="navbar-brand" href="{{ route('home') }}">PISAH</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Normal Navigation Links -->
                <li class="nav-item">
                    @if(auth()->check() && auth()->user()->is_admin)
                        <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                    @else
                        <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    @endif
                </li>                                                            
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('klasifikasi') ? 'active' : '' }}" href="{{ route('klasifikasi') }}">Klasifikasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('diskusi') ? 'active' : '' }}" href="{{ route('diskusi') }}">Diskusi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('materials.index') ? 'active' : '' }}" href="{{ route('materials.index') }}">Artikel</a>
                </li>

                @auth
                    <!-- Notification Icon -->
                    <li class="nav-item me-2">
                        @if($unreadNotifications > 0)
                            <a href="{{ route('notifications.index') }}" class="nav-link position-relative">
                                <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/app/isNotif.png" alt="Notification Icon" width="24" height="24">
                            </a>
                        @else
                            <a href="{{ route('notifications.index') }}" class="nav-link position-relative">
                                <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/app/noNotif.png" alt="Notification Icon" width="24" height="24">
                            </a>
                        @endif
                    </li>

                    <!-- Admin Dropdown -->
                    @if(auth()->user()->is_admin)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin Panel
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.materials.index') }}">Artikel</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.material-categories.index') }}">Kategori</a></li>
                            </ul>
                        </li>
                    @endif

                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth()->user()->avatar)
                                <img src="{{ route('avatar.show', auth()->user()->id) }}" alt="{{ auth()->user()->name }}" class="rounded-circle me-2" width="32" height="32">
                            @else
                                <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/user.png" alt="{{ auth()->user()->name }}" class="rounded-circle me-2" width="32" height="32">
                            @endif
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bi bi-person"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear"></i> Ubah Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
