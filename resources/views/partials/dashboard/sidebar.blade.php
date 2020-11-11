<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <img src="img/logo-primary.svg" class="img-fluid" alt="" srcset="">
    </a>

    <hr class="sidebar-divider my-0 mb-3">


    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @hasanyrole('siswa')

    <hr class="sidebar-divider">
    
    <div class="sidebar-heading">
        FITUR
    </div>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Try Out</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-percent"></i>
            <span>Passing Grade</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-microphone"></i>
            <span>Virtual Mentoring</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Statistik</span></a>
    </li>

    <hr class="sidebar-divider">
    @endhasanyrole

    @hasanyrole('siswa')
    <div class="sidebar-heading">
        Umum
    </div>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-bell fa-fw"></i>
            <span>Pemberitahuan</span> <span class="badge badge-success">0</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Pembayaran</span> <span class="badge badge-success">0</span>
        </a>
    </li>
    @endhasanyrole
    @hasanyrole('admin|sekolah')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePembayaran"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Pembayaran</span>
        </a>
        <div id="collapsePembayaran" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pembayaran :</h6>
                <a class="collapse-item" href="#">Belum Bayar</a>
                <a class="collapse-item" href="#">Sudah Bayar</a>
            </div>
        </div>
    </li>
    @endhasanyrole

    @hasanyrole('superadmin|sekolah|admin')
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        ROLE USER
    </div>
    @endhasanyrole
    @hasanyrole('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('siswa.index') }}">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Siswa</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sekolah.index') }}">
            <i class="fas fa-fw fa-school"></i>
            <span>Sekolah</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('mentor.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Mentor</span>
        </a>
    </li>
    @endhasanyrole
    @role('superadmin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-headphones"></i>
            <span>Admin</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('superadmin.index') }}">
            <i class="fas fa-fw fa-crown"></i>
            <span>Superadmin</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRolePermission"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Role & permission</span>
        </a>
        <div id="collapseRolePermission" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('role.index') }}">Role</a>
                <a class="collapse-item" href="{{ route('role.permission') }}">Permission</a>
                <a class="collapse-item" href="{{ route('permission.attach') }}">Attach Permission</a>
            </div>
        </div>
    </li>
    @endrole

    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Heading -->
    <div class="sidebar-heading">
        PENGATURAN
    </div>
    @hasanyrole('admin')

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHalaman"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Halaman</span>
        </a>
        <div id="collapseHalaman" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Halaman :</h6>
                <a class="collapse-item" href="#">Landing Page</a>
                <a class="collapse-item" href="#">Blog</a>
            </div>
        </div>
    </li>
    @endhasanyrole
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user"></i>
            <span>Profil</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 bg-warning" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components,
            and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
            Pro!</a>
    </div>

</ul>
<!-- End of Sidebar -->
