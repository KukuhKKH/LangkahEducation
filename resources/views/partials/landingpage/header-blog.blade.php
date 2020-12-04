<header id="header" class="fixed-top ">
   <div class="container d-flex align-items-center justify-content-between">

       <!-- Uncomment below if you prefer to use an image logo -->
       <a href="index.html" class="logo"><img id="navLogo" src="assets/img/logo-secondary.svg" alt=""
               class="img-fluid"></a>

       <nav class="nav-menu d-none d-lg-block">
           <ul>
               <li><a href="{{ route('page.blog.index') }}">Beranda</a></li>
               {{-- <li><a href="{{ route('page.blog.kategori', 'UNBK') }}">UTBK</a></li>
               <li><a href="{{ route('page.blog.kategori', 'SBMPTN') }}">SBMPTN</a></li>
               <li><a href="{{ route('page.blog.kategori', 'SAINTEK') }}">SAINTEK</a></li>
               <li><a href="{{ route('page.blog.kategori', 'SOSHUM') }}">SOSHUM</a></li> --}}
           </ul>
       </nav><!-- .nav-menu -->

   </div>
</header><!-- End Header -->