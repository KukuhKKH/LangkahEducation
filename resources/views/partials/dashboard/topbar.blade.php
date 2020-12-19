<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-light topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        @hasanyrole('mentor|siswa')
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{ count($chat_masuk) }}</span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Chat
                </h6>
                @foreach ($chat_masuk as $value)
                    @if (auth()->user()->getRolenames()->first() == 'siswa')
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('mentorig.siswa') }}">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ ($value->mentor->user->foto) ? asset("upload/users/". $value->mentor->user->foto) : asset('assets/img/default_avatar.svg') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">{{ (strlen($value->pesan) > 30) ? substr($value->pesan, 0, 30). "...." : $value->pesan }}</div>
                            <div class="small text-gray-500">{{ $value->mentor->user->name }}</div>
                        </div>
                    </a>
                    @else
                    {{-- Buat Mentor --}}
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('mentorig.mentoring', $value->siswa->id) }}">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="{{ ($value->siswa->user->foto) ? asset("upload/users/". $value->siswa->user->foto) : asset('assets/img/default_avatar.svg') }}" alt="">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">{{ (strlen($value->pesan) > 30) ? substr($value->pesan, 0, 30). "...." : $value->pesan }}</div>
                            <div class="small text-gray-500">{{ $value->siswa->user->name }}</div>
                        </div>
                    </a>
                    @endif
                @endforeach
                @hasanyrole('siswa')
                <a class="dropdown-item text-center small text-gray-500" href="{{ route('mentorig.siswa') }}">Lihat Semua</a>
                @endhasanyrole
                @hasanyrole('mentor')
                <a class="dropdown-item text-center small text-gray-500" href="{{ route('mentorig.mentor') }}">Lihat Semua</a>
                @endhasanyrole
                    
            </div>
        </li>
        @endhasanyrole

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                <img class="img-profile rounded-circle" src="{{ (auth()->user()->foto) ? asset("upload/users/". auth()->user()->foto) : asset('assets/img/default_avatar.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda benar-benar ingin keluar ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih ‘Logout’ apabila Anda ingin menyudahi sesi ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-dark" type="button" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-light text-danger">Logout</button>
                </div>
            </form>
        </div>
    </div>
</div>
