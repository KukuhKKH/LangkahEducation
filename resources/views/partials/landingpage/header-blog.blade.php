<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">
 
        <!-- Uncomment below if you prefer to use an image logo -->
    <a href="{{ url('/') }}" class="logo"><img id="navLogo" src="{{asset('assets/img/logo-secondary.svg')}}" alt=""
                class="img-fluid"></a>
 
        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                @foreach ($kategori as $value)
                <li><a href="{{ route('page.blog.kategori', $value->nama) }}">{{ strtoupper($value->nama) }}</a></li>
                @endforeach
                <li><a href="{{ route('page.blog.index') }}">Recent</a></li>
                <li><a href="{{ route('page.blog.index', ['pop' => 'popular']) }}">Populer</a></li>
                <li>
                    <form action="{{ route('page.blog.index') }}" method="get">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <button class="btn btn-warning text-white" type="button"><i class="fa fa-search"></i></button>
                            </div>
                            <input type="text" class="form-control" placeholder="Cari Artikel" aria-label="" aria-describedby="basic-addon1" name="keyword">
                          </div>
                    </form>
                </li>
                {{-- <li><a href="{{ route('page.blog.kategori', 'UNBK') }}">UTBK</a></li>
                <li><a href="{{ route('page.blog.kategori', 'SBMPTN') }}">SBMPTN</a></li>
                <li><a href="{{ route('page.blog.kategori', 'SAINTEK') }}">SAINTEK</a></li>
                <li><a href="{{ route('page.blog.kategori', 'SOSHUM') }}">SOSHUM</a></li> --}}
            </ul>
        </nav><!-- .nav-menu -->
 
    </div>
 </header><!-- End Header -->