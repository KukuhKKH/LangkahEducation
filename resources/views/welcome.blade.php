@extends('layouts.app')
@section('content')
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="index.html" class="logo"><img id="navLogo" src="assets/img/logo-secondary.svg" alt=""
          class="img-fluid"></a>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="#about">Tentang Kami</a></li>
          <li><a href="#products">Produk</a></li>
          <li><a href="#blog">Blog</a></li>
          <li><a href="#testimoni">Testimonial</a></li>
          <li><a href="#pricing">Biaya</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-1 order-lg-2 hero-img">
                <img src="{{asset('assets-landingpage/img/hero-img.png')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 pt-2 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                <h1>BUILD BETTER FUTURE</h1>
                <h2>-ONE STEP FOR THOUSAND FUTURES-</h2>
                <div class="mt-5">
                    <a href="#" class="btn-langkah">Register</a>
                    <a href="#" class="btn-outline-langkah">Login</a>
                </div>
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container">
            <div class="row content align-items-center">
                <div class="col-lg-6 order-2 order-lg-1 text-center">
                    <img src="{{asset('assets-landingpage/img/about-img.png')}}" class="img-fluid w-75" alt="">
                </div>
                <div class="col-lg-6 pt-2 pt-lg-0 order-1 order-lg-2">
                    <h3 class="h3 font-weight-bold">Siapa Kita?</h3>
                    <p>
                        Langkah Education merupakan Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatem
                        odit quis
                        numquam mollitia minus nisi modi est ea esse eveniet?

                        Langkah Education merupakan Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatem
                        odit quis
                        numquam mollitia minus nisi modi est ea esse eveniet?
                    </p>
                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="products" class="products">
        <div class="container">
            <div class="section-title">
                <h2>Produk</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="box">
                        <span class="price">14 - 15 November 2020</span>
                        <h4>Dibuka <span>Try Out Batch 1</span></h4>
                        <h6>Biaya Pendaftaran <span>Rp. 100.000</span></h6>
                        <a href="#" class="btn-buy">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Why Us Section -->

    <section id="blog" class="blog bg-dark section-light">
        <div class="container py-4">
            <div class="section-title">
                <h2>Blog</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                    consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                    fugiat sit
                    in iste officiis commodi quidem hic quas.</p>
                <a href="" class="btn-outline-langkah mt-5">Kunjungi Blog Kami </a>
            </div>
        </div>
    </section>

    <!-- ======= Testimonials Section ======= -->
    <section id="testimoni" class="testimonials">
        <div class="container">

            <div class="section-title">
                <h2>Testimonials</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                    consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                    fugiat sit
                    in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="owl-carousel testimonials-carousel">

                <div class="testimonial-item">
                    <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus.
                        Accusantium
                        quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                    <img src="{{asset('assets-landingpage/img/testimonials/testimonials-1.jpg')}}" class="testimonial-img" alt="">
                    <h3>Saul Goodman</h3>
                    <h4>Guru <span>- MAN 2 MALANG</span></h4>
                </div>

                <div class="testimonial-item">
                    <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram
                        malis
                        quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                    <img src="{{asset('assets-landingpage/img/testimonials/testimonials-2.jpg')}}" class="testimonial-img" alt="">
                    <h3>Sara Wilsson</h3>
                    <h4>Siswa <span>- SMAN 1 MALANG</span></h4>
                </div>

                <div class="testimonial-item">
                    <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis
                        minim tempor
                        labore quem eram duis noster aute amet eram fore quis sint minim.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                    <img src="{{asset('assets-landingpage/img/testimonials/testimonials-3.jpg')}}" class="testimonial-img" alt="">
                    <h3>Jena Karlis</h3>
                    <h4>Siswa <span>- SMAN 1 SURABAYA</span></h4>
                </div>

                <div class="testimonial-item">
                    <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim
                        velit minim
                        dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                    <img src="{{asset('assets-landingpage/img/testimonials/testimonials-4.jpg')}}" class="testimonial-img" alt="">
                    <h3>Matt Brandon</h3>
                    <h4>Siswa <span>- SMAN 1 PALANGKARAYA</span></h4>
                </div>

                <div class="testimonial-item">
                    <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim
                        culpa
                        labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                    <img src="{{asset('assets-landingpage/img/testimonials/testimonials-5.jpg')}}" class="testimonial-img" alt="">
                    <h3>John Larson</h3>
                    <h4>Siswa <span>- SMAN 2 MAKASAR</span></h4>
                </div>

            </div>

        </div>
    </section><!-- End Testimonials Section -->
    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
        <div class="container">

            <div class="section-title">
                <h2>Pricing</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                    consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                    fugiat sit
                    in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-4 box">
                    <h3>Individu</h3>
                    <h4>Rp.100.000<span>per month</span></h4>
                    <ul>
                        <li><i class="fas fa-check"></i> Quam adipiscing vitae proin</li>
                        <li><i class="fas fa-check"></i> Nec feugiat nisl pretium</li>
                        <li><i class="fas fa-check"></i> Nulla at volutpat diam uteera</li>
                        <li><i class="fas fa-check"></i> Pharetra massa massa ultricies</li>
                        <li><i class="fas fa-check"></i> Massa ultricies mi quis hendrerit</li>
                    </ul>
                    <a href="#" class="btn-buy">Get Started</a>
                </div>

                <div class="col-lg-4 box featured">
                    <h3>Sekolah</h3>
                    <h4>Rp.150.000<span>per month</span></h4>
                    <ul>
                        <li><i class="fas fa-check"></i> Quam adipiscing vitae proin</li>
                        <li><i class="fas fa-check"></i> Nec feugiat nisl pretium</li>
                        <li><i class="fas fa-check"></i> Nulla at volutpat diam uteera</li>
                        <li><i class="fas fa-check"></i> Pharetra massa massa ultricies</li>
                        <li><i class="fas fa-check"></i> Massa ultricies mi quis hendrerit</li>
                    </ul>
                    <a href="" class="btn-buy">Hubungi Admin</a>
                </div>

            </div>

        </div>
    </section><!-- End Pricing Section -->
</main><!-- End #main -->
@endsection

@section('js')
  <!-- Vendor JS Files -->
  <script src="{{asset('assets-landingpage/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('assets-landingpage/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets-landingpage/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('assets-landingpage/vendor/owl.carousel/owl.carousel.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets-landingpage/js/main.js')}}"></script>
@endsection
