<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">
 
        <!-- Uncomment below if you prefer to use an image logo -->
    <a href="{{ url('/') }}" class="logo"><img id="navLogo" src="{{asset('assets/img/logo-secondary.svg')}}" alt=""
                class="img-fluid"></a>
 
        <nav class="nav-menu d-none d-lg-block">
            <ul class="align-items-center">
                <li><a href="{{ route('page.blog.index') }}">Home Blog</a></li>
                @foreach ($kategori as $value)
                <li><a href="{{ route('page.blog.kategori', $value->nama) }}">{{ strtoupper($value->nama) }}</a></li>
                @endforeach
                <li class="p-2">
                    <form id="searchBlog" class="form-inline" action="{{ route('page.blog.index') }}" method="get">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <button class="btn btn-warning text-white" type="button"><i class="fa fa-search"></i></button>
                            </div>
                            <input type="text" class="form-control" placeholder="Cari Artikel" aria-label="" aria-describedby="basic-addon1" name="keyword">
                          </div>
                    </form>
                </li>
            </ul>
            
        </nav><!-- .nav-menu -->

    </div>
 </header><!-- End Header -->