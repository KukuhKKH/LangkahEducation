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
                <li><a href="#">Beranda</a></li>
                <li><a href="#">UTBK</a></li>
                <li><a href="#">SBMPTN</a></li>
                <li><a href="#">SAINTEK</a></li>
                <li><a href="#">SOSHUM</a></li>
            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header><!-- End Header -->
<main id="main">
    <section id="blog" class="blog">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card shadow mb-2">
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-4">{{$artikel->judul}}</h4>
                            <div class="d-flex justify-content-start align-items-center mb-4">
                                <i class="fa fa-sm fa-user"></i>
                                <a href=""><small class="mx-2">{{ $artikel->user->name }}</small></a>

                                <i class="fa fa-sm fa-clock"></i>
                                <small class="mx-2">{{ Carbon\Carbon::parse($artikel->created_at)->format('d F Y, H:i') }}</small>
                            </div>
                            @php
                                $string = preg_replace("/&#?[a-z0-9]+;/i", " ", $artikel->isi);
                            @endphp
                            {!! $string !!}

                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="sidebar">
                        <div id="other-post">
                            <h4 class="sidebar-title">Artikel Lainnya</h4>
                            <div class="sidebar-item recent-posts">
                                @forelse ($lainnya as $value)
                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-1.jpg')}}" alt="">
                                        <h4>{{ $value->judul }}</h4>
                                        <time datetime="2020-01-01">{{ Carbon\Carbon::parse($value->created_at)->format('F d, Y') }}</time>
                                    </div>
                                @empty
                                    <h3>Belum ada artikel</h3>
                                @endforelse

                                <hr>
                            </div>
                        </div>
                        <div id="similar-post">
                            <h4 class="sidebar-title">Artikel Terkait</h4>
                            <div class="sidebar-item recent-posts">
                                @forelse ($terkait as $value)
                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-1.jpg')}}" alt="">
                                        <h4>{{ $value->judul }}</h4>
                                        <time datetime="2020-01-01">{{ Carbon\Carbon::parse($value->created_at)->format('F d, Y') }}</time>
                                    </div>
                                @empty
                                    <h3>Belum ada artikel</h3>
                                @endforelse
                                <hr>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection

@section('css')
<!-- <link rel="stylesheet" href="{{asset('assets-landingpage/css/comment.css')}}"> -->
<style>
    #header {
        background: #ECB811;
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
<script src="{{asset('assets-landingpage/js/main.js')}}"></script>
@endsection
