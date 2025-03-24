<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">My Website</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/even') }}">Even Numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/prime') }}">Prime Numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/multable') }}">Multiplication Table</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/minitest') }}">Mini Test</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/transcript') }}">Transcript</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/users') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/tasks') }}">tasks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/products') }}">Products</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            Welcome, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <a class="dropdown-item" href="{{ route('users.profile') }}">
                                    <i class="fas fa-user"></i> My Profile
                                </a>
                            </li>
                          
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
