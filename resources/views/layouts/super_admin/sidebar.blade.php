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
        <a class="nav-link" href="{{ route('super_admin.index') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Menu
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
        <div id="collapseTwo" class="collapse {{ ($title != 'Dashboard') ? 'show' : ''}}" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Role:</h6>
                <a class="collapse-item {{ $title == 'Admin' ? 'active' : ''}}"
                    href="{{ route('super_admin.admin') }}">Admin</a>
                <a class="collapse-item {{ $title == 'Finance' ? 'active' : ''}}"
                    href="{{ route('super_admin.finance') }}">Finance</a>
            </div>
        </div>
    </li>
</ul>
<!-- Side Bar -->
@endsection