@section('sidebar')
<!-- Side Bar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <text class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-text mx-3">
            Ambil Paket
        </div>
    </text>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ $title == 'Dashboard' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('customer.index') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Menu
    </div>
    @auth
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-gift"></i>
            <span>Paket</span>
        </a>
        <div id="collapseTwo" class="collapse {{ ($title != 'Dashboard' && $title != 'Profile') ? 'show' : ''}}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilihan Paket:</h6>
                <a class="collapse-item {{ $title == 'Kirim Paket' ? 'active' : ''}}"
                    href="{{ route('customer.item') }}">Kirim Paket</a>
                <a class="collapse-item {{ $title == 'Lacak Paket' ? 'active' : ''}}"
                    href="{{ route('customer.lacak-paket') }}">Lacak
                    Paket</a>
                <a class="collapse-item {{ $title == 'Riwayat Pengiriman' ? 'active' : ''}}"
                    href="{{ route('customer.riwayat-pengiriman') }}">Riwayat
                    Pengiriman</a>
            </div>
        </div>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-users"></i>
            <span>User</span>
        </a>
    </li>
    @endauth
</ul>
<!-- Side Bar -->
@endsection