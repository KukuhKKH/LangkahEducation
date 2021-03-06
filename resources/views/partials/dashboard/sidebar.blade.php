<!-- Sidebar -->
<ul class="navbar-nav bg-langkah sidebar sidebar-dark accordion" id="accordionSidebar" style="border-radius: 20px">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <img id="logoDashboard" src="{{ asset('assets/img/logo-primary-white.svg') }}" class="img-fluid p-2" alt="" srcset="">
    </a>

    <hr class="sidebar-divider my-0 mb-3">


    <li class="nav-item {{ (request()->is('dashboard')) || (request()->is('home')) ? 'active' : '' }}">
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
            <span>Tryout</span>
        </a>
        <div id="collapseTryOut" class="{{ ($nav_tryout) ? 'show collapse' : 'collapse' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tryout :</h6>
                <a class="collapse-item {{ request()->is('dashboard/tryout/paket/*') || request()->is('dashboard/tryout/paket') ? 'active' : '' }}" href="{{ route('paket.index') }}">Paket Soal</a>
                <a class="collapse-item {{ request()->is('dashboard/tryout/kategori-soal') || request()->is('dashboard/tryout/kategori-soal/*') ? 'active' : '' }}" href="{{ route('kategori-soal.index') }}">Kategori Soal</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->segment(2) == 'pendaftaran' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pendaftaran.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Produk / Gelombang</span>
        </a>
    </li>
    
    <li class="nav-item {{ request()->segment(2) == 'universitas' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('universitas.index') }}">
            <i class="fas fa-fw fa-percent"></i>
            <span>Passing Grade</span>
        </a>
    </li>

    <li class="nav-item {{ request()->segment(2) == 'gambar' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('gambar.index') }}">
            <i class="fas fa-fw fa-image"></i>
            <span>Gambar Soal</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    @endhasanyrole

    @hasanyrole('siswa')

    {{-- Tryout Siswa --}}

    <li class="nav-item {{ (request()->segment(2) == 'siswa' && request()->segment(3) == 'tryout') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.tryout.index') }}">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Tryout</span>
        </a>
    </li>

    <li class="nav-item {{ request()->is('dashboard/daftar/gelombang') ? 'active' : "" }}">
        <a class="nav-link" href="{{ route('gelombang.siswa') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Toko Tryout</span>
        </a>
    </li>

    
    <li class="nav-item {{ request()->is('dashboard/riwayat-tryout') ? 'active' : "" }}">
        <a class="nav-link" href="{{ route('tryout.history') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Tryout</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-percent"></i>
            <span>Passing Grade</span>
        </a>
    </li> --}}
    @if (auth()->user()->siswa->batch)
    <li class="nav-item {{ (request()->is('dashboard/mentoring/virtual')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mentorig.siswa') }}">
            <i class="fas fa-fw fa-microphone"></i>
            <span>Virtual Mentoring</span>
        </a>
    </li>
    @endif

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
    <hr class="sidebar-divider">

    @endhasanyrole

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

    @can('create blog')
        <li class="nav-item {{ request()->is('dashboard/blog') ? 'active' : "" }}">
            <a class="nav-link" href="{{ route('blog.index') }}">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>Blog</span>
            </a>
        </li>
    @endcan

    @hasanyrole('superadmin|admin')
    @php
    $aktif_bayar = (request()->is('dashboard/pembayaran/belum-bayar')|request()->is('dashboard/pembayaran/sudah-bayar')|request()->is('dashboard/pembayaran/ditolak')|request()->is('dashboard/pembayaran/sudah-verifikasi')) ? true : false
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
                <a class="collapse-item {{ request()->is('dashboard/pembayaran/belum-bayar') || request()->is('dashboard/pembayaran/belum-bayar/*') ? 'active' : '' }}" href="{{ route('pembayaran.show', 'belum-bayar') }}">Belum Bayar <span class="badge badge-warning">{{ $pembayaran_notif->total_belum }}</span></a>
                <a class="collapse-item {{ request()->is('dashboard/pembayaran/sudah-bayar') || request()->is('dashboard/pembayaran/sudah-bayar/*') ? 'active' : '' }}" href="{{ route('pembayaran.show', 'sudah-bayar') }}">Sudah Bayar <span class="badge badge-primary">{{ $pembayaran_notif->total_sudah }}</span></a>
                <a class="collapse-item {{ request()->is('dashboard/pembayaran/sudah-verifikasi') || request()->is('dashboard/pembayaran/sudah-verifikasi/*') ? 'active' : '' }}" href="{{ route('pembayaran.show', 'sudah-verifikasi') }}">Sudah Diverifikasi <span class="badge badge-success">{{ $pembayaran_notif->total_verifikasi }}</span></a>
                <a class="collapse-item {{ request()->is('dashboard/pembayaran/ditolak') || request()->is('dashboard/pembayaran/ditolak/*') ? 'active' : '' }}" href="{{ route('pembayaran.show', 'ditolak') }}">Ditolak <span class="badge badge-danger">{{ $pembayaran_notif->total_tolak }}</span></a>
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
            <span>Program Khusus</span>
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
        $aktif_halaman = (request()->is('dashboard/testimoni')|request()->is('dashboard/testimoni/*')|request()->is('dashboard/layanan')|request()->is('dashboard/landing-page')|request()->segment(2)=='kategori-blog') ? true : false
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
                <a class="collapse-item {{ (request()->segment(2) == 'kategori-blog') ? 'active' : '' }}" href="{{ route('kategori-blog.index') }}">Kategori Blog</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->segment(2) == 'rekening' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rekening.index') }}">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Metode Pembayaran</span>
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
