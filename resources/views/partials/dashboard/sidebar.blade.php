<!-- Sidebar -->
<ul class="navbar-nav bg-white sidebar sidebar-light accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <img id="logoDashboard" src="{{ asset('assets/img/logo-primary.svg') }}" class="img-fluid p-2" alt="" srcset="">
    </a>

    <hr class="sidebar-divider my-0 mb-3">


    <li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        FITUR
    </div>
    
    @hasanyrole('superadmin|admin')
    @php
        $nav_tryout = request()->is('dashboard/tryout/*') ? true : false
    @endphp
    <li class="nav-item {{ (request()->is('dashboard/tryout/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTryOut"
            aria-expanded="{{ $nav_tryout }}" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>TryOut</span>
        </a>
        <div id="collapseTryOut" class="{{ ($nav_tryout) ? 'show collapse' : 'collapse' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Try Out :</h6>
                <a class="collapse-item {{ request()->is('dashboard/tryout/paket/*') ? 'active' : '' }}" href="{{ route('paket.index') }}">Paket Soal</a>
                <a class="collapse-item {{ request()->is('dashboard/tryout/kategori-soal') ? 'active' : '' }}" href="{{ route('kategori-soal.index') }}">Kategori Soal</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->segment(2) == 'pendaftaran' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pendaftaran.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Pendaftaran Batch</span>
        </a>
    </li>
    
    <li class="nav-item {{ request()->segment(2) == 'universitas' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('universitas.index') }}">
            <i class="fas fa-fw fa-percent"></i>
            <span>Passing Grade</span>
        </a>
    </li>

    @endhasanyrole

    @hasanyrole('siswa')

    {{-- Try Out Siswa --}}

    <li class="nav-item {{ (request()->segment(2) == 'siswa' && request()->segment(3) == 'tryout') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.tryout.index') }}">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Try Out</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-percent"></i>
            <span>Passing Grade</span>
        </a>
    </li> --}}

    <li class="nav-item {{ (request()->is('dashboard/mentoring/virtual')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mentorig.siswa') }}">
            <i class="fas fa-fw fa-microphone"></i>
            <span>Virtual Mentoring</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Statistik</span>
        </a>
    </li> --}}

    <li class="nav-item {{ request()->is('dashboard/daftar/gelombang') ? 'active' : "" }}">
        <a class="nav-link" href="{{ route('gelombang.siswa') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Daftar Try Out</span>
        </a>
    </li>

    @endhasanyrole
    @hasanyrole('mentor')
    <li class="nav-item {{ (request()->segment(2) == 'mentoring') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mentorig.mentor') }}">
            <i class="fas fa-fw fa-microphone"></i>
            <span>Virtual Mentoring</span>
        </a>
    </li>
    @endhasanyrole
    @hasanyrole('sekolah')
    <li class="nav-item {{ (request()->segment(2) == 'mentorig') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mentoring.sekolah') }}">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>List Siswa</span>
        </a>
    </li>
    @endhasanyrole
    <hr class="sidebar-divider">

    @hasanyrole('siswa|admin|superadmin')

    <div class="sidebar-heading">
        Umum
    </div>

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('pemberitahuan.index') }}">
            <i class="fas fa-bell fa-fw"></i>
            <span>Pemberitahuan</span>
            @hasanyrole('siswa|sekolah')
            <span class="badge badge-success">0</span>
            @endhasanyrole
        </a>
    </li> --}}
    @endhasanyrole
    @hasanyrole('siswa')

    <li class="nav-item {{ request()->is('dashboard/pembayaran-siswa') ? 'active' : "" }}">
        <a class="nav-link" href="{{ route('pembayaran.siswa') }}">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Pembayaran</span> <span class="badge badge-success">{{ $total_pembayaran }}</span>
        </a>
    </li>
    @endhasanyrole

    @hasanyrole('author')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('blog.index') }}">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>Blog</span>
            </a>
        </li>
    @endhasanyrole

    @hasanyrole('superadmin|admin')
    @php
    $aktif_bayar = (request()->is('dashboard/pembayaran/belum-bayar')|request()->is('dashboard/pembayaran/sudah-bayar')) ? true : false
    @endphp
    <li class="nav-item {{ ($aktif_bayar) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePembayaran"
            aria-expanded="{{ $aktif_bayar }}" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Pembayaran</span> <span class="badge badge-success">{{ ($pembayaran_notif->total_belum + $pembayaran_notif->total_sudah) }}</span>
        </a>
        <div id="collapsePembayaran" class="{{ ($aktif_bayar) ? 'show collapse' : 'collapse' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pembayaran :</h6>
                <a class="collapse-item" href="{{ route('pembayaran.show', 'belum-bayar') }}">Belum Bayar <span class="badge badge-danger">{{ $pembayaran_notif->total_belum }}</span></a>
                <a class="collapse-item" href="{{ route('pembayaran.show', 'sudah-bayar') }}">Sudah Bayar <span class="badge badge-success">{{ $pembayaran_notif->total_sudah }}</span></a>
            </div>
        </div>
    </li>
    @endhasanyrole

    @hasanyrole('superadmin|admin')
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        ROLE USER
    </div>
    
    <li class="nav-item">
    <li class="nav-item {{ (request()->is('dashboard/siswa')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.index') }}">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Siswa</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('dashboard/sekolah')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sekolah.index') }}">
            <i class="fas fa-fw fa-school"></i>
            <span>Sekolah</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('dashboard/mentor')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mentor.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Mentor</span>
        </a>
    </li>

    <li class="nav-item {{ (request()->is('dashboard/author')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('author.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Author</span>
        </a>
    </li>
    
    <li class="nav-item">
    @hasanyrole('superadmin')
    <li class="nav-item {{ (request()->is('dashboard/admin')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-headphones"></i>
            <span>Admin</span>
        </a>
    </li>

    <li class="nav-item {{ (request()->is('dashboard/superadmin')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('superadmin.index') }}">
            <i class="fas fa-fw fa-crown"></i>
            <span>Superadmin</span>
        </a>
    </li>
@php
    $aktif_role = (request()->is('dashboard/role')|request()->is('dashboard/permission')|request()->is('dashboard/permission/attach')|request()->segment(2)=='permission') ? true : false
@endphp
    <li class="nav-item {{ ($aktif_role) ? 'active' : '' }}">
        <a class="nav-link {{ ($aktif_role) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseRolePermission"
           aria-expanded="{{ $aktif_role }}" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Role & permission</span>
        </a>
        <div id="collapseRolePermission" class="{{ ($aktif_role) ? 'show collapse' : 'collapse' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ (request()->is('dashboard/role')) ? 'active' : '' }}" href="{{ route('role.index') }}">Role</a>
                <a class="collapse-item {{ (request()->is('dashboard/permission')) ? 'active' : '' }}" href="{{ route('role.permission') }}">Permission</a>
            </div>
        </div>
    </li>
    @endhasanyrole
    @endhasanyrole

    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Heading -->
    <div class="sidebar-heading">
        PENGATURAN
    </div>
    @hasanyrole('admin|superadmin')
    @php
        $aktif_halaman = (request()->is('dashboard/testimoni')|request()->is('dashboard/layanan')|request()->is('dashboard/landing-page')|request()->is('dashboard/blog')|request()->segment(2)=='permission'|request()->segment(2)=='kategori-blog') ? true : false
    @endphp
    <li class="nav-item {{ ($aktif_halaman) ? 'active' : '' }}">
        <a class="nav-link {{ ($aktif_halaman) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseHalaman" aria-expanded="{{ $aktif_halaman }}" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Halaman</span>
        </a>
        <div id="collapseHalaman" class="{{ ($aktif_halaman) ? 'show collapse' : 'collapse' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Halaman :</h6>
                <a class="collapse-item {{ (request()->segment(2) == 'landing-page') ? 'active' : '' }}" href="{{ route('landing_page.index') }}">Landing Page</a>
                <a class="collapse-item {{ (request()->segment(2) == 'layanan') ? 'active' : '' }}" href="{{ route('layanan.index') }}">Produk/Layanan</a>
                <a class="collapse-item {{ (request()->segment(2) == 'testimoni') ? 'active' : '' }}" href="{{ route('testimoni.index') }}">Testimonial</a>
                <a class="collapse-item {{ (request()->segment(2) == 'blog') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                <a class="collapse-item {{ (request()->segment(2) == 'kategori-blog') ? 'active' : '' }}" href="{{ route('kategori-blog.index') }}">Kategori Blog</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->segment(2) == 'rekening' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rekening.index') }}">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Rekening Pembayaran</span>
        </a>
    </li>
    <li class="nav-item {{ request()->segment(2) == 'gambar' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('gambar.index') }}">
            <i class="fas fa-fw fa-image"></i>
            <span>Gambar Soal</span>
        </a>
    </li>
    @endhasanyrole
    <li class="nav-item {{ request()->segment(2) == 'profil' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profile.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profil</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 bg-warning" id="sidebarToggle"></button>
    </div>
    
</ul>
<!-- End of Sidebar -->
