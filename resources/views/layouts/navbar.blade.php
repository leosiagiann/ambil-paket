@section('navbar')
<!-- Navbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Admin Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    @auth
                    <div class="text-capitalize">
                        {{ auth()->user()->name }} : {{ auth()->user()->role->name }}
                    </div>
                    @else
                    Guest
                    @endauth
                </span>
                <img class="img-profile rounded-circle" src="{{ asset('assets/img/undraw_profile.svg') }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @auth
                @if (auth()->user()->role->name == 'customer')
                <a class="dropdown-item" href="{{ route(auth()->user()->role->name.'.profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                @endif
                <a class="dropdown-item" href="{{ route('auth.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @else
                <a class="dropdown-item" href="{{ route('auth.login') }}">
                    <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Login
                </a>
                @endauth
            </div>
        </li>
        <!-- End Admin Information -->
    </ul>
</nav>
<!-- End Navbar -->
@endsection