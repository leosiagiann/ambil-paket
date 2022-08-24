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
        <a class="nav-link" href="{{ route('finance.index') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Menu
    </div>
    <li class="nav-item {{ $page == 'Users' ? 'active' : ''}}">
        <a class="nav-link" href="{{ route('finance.agen') }}">
            <i class="fas fa-users"></i>
            <span>Agen</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <i class="fas fa-fw fa-gift"></i>
            <span>Paket</span>
        </a>
        <div id="collapseThree" class="collapse {{ ($page == 'Paket') ? 'show' : ''}}" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilihan Paket:</h6>
                <a class="collapse-item {{ $title == 'Pengiriman Paket' ? 'active' : ''}}"
                    href="{{ route('finance.item') }}">Pengiriman Paket</a>
                <a class="collapse-item {{ $title == 'Riwayat Pengiriman' ? 'active' : ''}}"
                    href="{{ route('finance.item.done') }}">Riwayat Pengiriman</a>
                <a class="collapse-item {{ $title == 'Riwayat Penolakan' ? 'active' : ''}}"
                    href="{{ route('finance.item.cancel') }}">Riwayat Penolakan</a>
            </div>
        </div>
    </li>
</ul>
<!-- Side Bar -->
@endsection