@extends('layouts.app')
@section('title', 'Langkah Education')
@section('deskripsi'){{ $data->deskripsi}}@endsection

@section('content')
<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-between">
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{ url('/') }}" class="logo"><img id="navLogo" src="assets/img/logo-secondary.svg" alt=""
                class="img-fluid"></a>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#products">Produk</a></li>
                <li><a href="#blog">Blog</a></li>
                <li><a href="#testimoni">Testimonial</a></li>
                {{-- <li><a href="#pricing">Biaya</a></li> --}}
                <li><a href="#contact">Kontak</a></li>
            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header><!-- End Header -->
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 order-1 order-lg-2 hero-img">
                @if ($data->foto_hero)
                <img src="{{asset("landing-page/foto/$data->foto_hero")}}" class="img-fluid" alt="" width="955"
                    height="1024">
                @else
                <img src="{{asset('assets-landingpage/img/hero-img.png')}}" class="img-fluid" alt="">
                @endif
            </div>
            <div class="col-lg-6 pt-2 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                <h1 class="mt-3">{{ $data->headline }}</h1>
                <h2>{{ $data->tagline}}</h2>
                <div class="mt-4 mb-5">
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn-outline-langkah">Buka Dashboard</a>
                    @else
                    <a href="{{ route('register') }}" class="btn-langkah">Register</a>
                    <a href="{{ route('login') }}" class="btn-outline-langkah">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about my-5">
        <div class="container">
            <div class="section-title">
                <h2>Tentang Kami</h2>
            </div>
            <div class="row content align-items-center">
                <div class="col-lg-6 order-1 order-lg-1 hero-img text-center">
                    @if ($data->foto_tentang_kami)
                    <img src="{{asset("landing-page/foto/$data->foto_tentang_kami")}}" class="img-fluid w-75 mb-3" alt=""
                        width="955" height="1024">
                    @else
                    <img src="{{asset('assets-landingpage/img/hero-img.png')}}" class="img-fluid" alt="">
                    @endif
                </div>
                <div class="col-lg-6 pt-2 pt-lg-0 order-1 order-lg-2 mb-4">
                    <div class="card shadow bg-langkah" style="border: none">
                        <div class="card-body text-white">
                            {!! $data->tentang_kami !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="products" class="products mt-3">
        <div class="container">
            <div class="section-title">
                <h2>Produk</h2>
                {!! $data->headline_produk !!}
            </div>
            <div class="row justify-content-center mt-4">
                <div class="owl-carousel products-carousel">
                @forelse ($layanan as $value)
                <div class="products-item p-4">
                    
                    <div class="card shadow bg-langkah text-white">
                        <div class="card-body text-center">
                        <div class="d-flex justify-content-center">
                            @if ($value->foto)
                            <img class="img-cover img-circle"src="{{asset("upload/layanan/$value->foto")}}" alt="">
                            @else
                            <img class="img-cover img-circle "src="{{asset('assets/img/logo-circle-primary.svg')}}" alt="">
                            @endif
                        </div>
                            <h5 class="mt-4 font-weight-bold">{{ $value->nama }}</h5>
                            {!! $value->deskripsi !!}
                        </div>
                    </div>
                </div>
                @empty
                    
                @endforelse
                </div>

            </div>
        </div>
    </section><!-- End Why Us Section -->

    <section id="blog" class="blog bg-dark section-light">
        <div class="container py-4">
            <div class="section-title">
                <h2>Blog</h2>
                <p class="text-white">{!! $data->headline_blog !!}</p>
                {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                    consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia
                    fugiat sit
                    in iste officiis commodi quidem hic quas.</p> --}}
                <a href="{{ route('page.blog.index') }}" class="btn-outline-langkah mt-5">Kunjungi Blog Kami </a>
            </div>
        </div>
    </section>

    <!-- ======= Testimonials Section ======= -->
    <section id="testimoni" class="testimonials mb-4">
        <div class="container">

            <div class="section-title">
                <h2>Testimonial</h2>
                {!! $data->headline_testimoni !!}
            </div>

            <div class="owl-carousel testimonials-carousel">
                @forelse ($testimoni as $value)
                <div class="testimonial-item">
                    <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        {{ $value->testimoni }}
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                    </p>
                    @if ($value->foto)
                    <img src="{{asset("upload/testimoni/$value->foto")}}" class="testimonial-img" alt="">
                    @else
                    <img src="{{asset('assets-landingpage/img/testimonials/default_avatar.svg')}}" class="testimonial-img" alt="">
                    @endif
                    <h3>{{ $value->nama }}</h3>
                    <h4>{{ $value->role }}</h4>
                </div>
                @empty
                @endforelse
            </div>

        </div>
    </section><!-- End Testimonials Section -->
</main><!-- End #main -->
@endsection


@section('css')
<style>
    /* owl nav */

.owl-prev i, .owl-next i {
    padding: 10px;
    font-size: 18pt;
	color: #ECB811 !important;
}

.owl-prev i:hover, 
.owl-next i:hover {
	color: #8199A3 !important;
}

.owl-prev, .owl-next {
	position: absolute;
    top: -15px;
    height: 100%;
}

.owl-prev {
	left: -30px;
}

.owl-next {
	right: -30px;
}

#about .card p{
    margin-bottom : 0 !important;
}

@media (max-width: 767px) {
    .owl-prev i, .owl-next i {
        padding: 10px;
        font-size: 18pt;
        color: #4c4c4c !important;
    }
    .owl-prev {
	    left: 10px;
    }

    .owl-next {
        right: 10px;
    }

    #products .owl-prev{
        margin-left:15px;
    }
    
    #products .owl-next{
        margin-right:15px;
    }
}

button:focus, button:active {
   outline: none;
}

</style>
@endsection
@section('js')
<!-- Vendor JS Files -->
<script src="{{asset('assets-landingpage/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets-landingpage/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets-landingpage/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets-landingpage/vendor/owl.carousel/owl.carousel.min.js')}}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/vendor/sweet-alert/sweetalert.min.js') }}"></script>
<script>
    const URL = `{{ url('dashboard/daftar-gelombang') }}`
    $(".daftar").on('click', function () {
        Swal.fire({
            title: 'Daftar Sekarang',
            text: "Apakah Kamu mau mendaftar sekarang?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).data('id')
                window.location.replace(`${URL}/${id}`)
            }
        })
    })
</script>

@endsection
