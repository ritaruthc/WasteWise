<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">PISAH</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.materials.index') ? 'active' : '' }}" href="{{ route('admin.materials.index') }}">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('admin.material-categories.index') ? 'active' : '' }}" href="{{ route('admin.material-categories.index') }}">Kategori</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link" href="#" role="button">
                        <i class="bi bi-bell"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('admin.profile') }}">
                        <img src="{{ auth()->user()->avatar ?? 'https://via.placeholder.com/32x32' }}" alt="{{ auth()->user()->name }}" class="rounded-circle me-2" width="32" height="32">
                        {{ auth()->user()->name }}
                    </a>
                </li>                    
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link"><i class="bi bi-box-arrow-right"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
