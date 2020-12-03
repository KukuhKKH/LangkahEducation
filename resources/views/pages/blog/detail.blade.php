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
                            <h4 class="font-weight-bold mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Quibusdam, velit.</h4>
                            <div class="d-flex justify-content-start align-items-center mb-4">
                                <i class="fa fa-sm fa-user"></i>
                                <a href=""><small class="mx-2">Ammar Muhammads</small></a>

                                <i class="fa fa-sm fa-clock"></i>
                                <small class="mx-2">11 Nov 2020, 16:00</small>
                            </div>

                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, nisi quae cumque blanditiis
                                reprehenderit autem magnam soluta omnis fugit consectetur asperiores quo illum quasi,
                                obcaecati eveniet unde vitae, inventore ab. Neque impedit iure hic quos vel. Veritatis
                                temporibus quae quaerat animi sequi qui expedita possimus, eveniet aliquam tempora! Odio
                                quidem temporibus doloremque distinctio facilis enim corporis totam maiores, cum ullam
                                vero praesentium nihil qui consequuntur? Nam maiores quaerat maxime, quasi aliquid natus
                                fugiat voluptatibus nesciunt officia architecto consequuntur eaque reprehenderit,
                                nostrum ut molestias labore eligendi atque neque obcaecati mollitia assumenda
                                praesentium eius! Dolores veniam expedita repudiandae labore adipisci nam provident.</p>

                            <hr>

                            <div id="add-comment">
                                <form action="">
                                    <div class="row">
                                        <div class="col-auto">
                                            <img src="{{asset('assets/img/undraw_profile.svg') }}" class="avatar-lg"
                                                alt="Avatar">
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <textarea name="add-komentar" id="add-komentar"
                                                    class="form-control @error('add-komentar') is-invalid @enderror"
                                                    placeholder="Masukkan Komentar" rows="4"></textarea>
                                                @error('add-komentar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12 text-right">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-paper-plane"></i> Kirim Komentar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <label class="mt-3">Komentar :</label>

                            <div id="comment-list" class="bg-light p-4">
                                <div class="row my-2" id="komentar">
                                    <div class="col-auto">
                                        <img src="{{asset('assets/img/undraw_profile.svg') }}" class="avatar "
                                            alt="Avatar">
                                    </div>
                                    <div class="col">
                                        <h6 class="font-weight-bold">Kukuh</h6>
                                        <p>Kenapa ya kak ak jomblo terus?
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil, cum.
                                        </p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row my-2" id="komentar">
                                    <div class="col-auto">
                                        <img src="{{asset('assets/img/undraw_profile.svg') }}" class="avatar "
                                            alt="Avatar">
                                    </div>
                                    <div class="col">
                                        <h6 class="font-weight-bold">Sopo Yo</h6>
                                        <p>Makanya Cari Jodoh. Sini aku promosiin di T#kopedia
                                        </p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="sidebar">
                            <div id="other-post">
                                <h4 class="sidebar-title">Artikel Lainnya</h4>
                                <div class="sidebar-item recent-posts">
                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-1.jpg')}}" alt="">
                                        <h4>Nihil blanditiis at in nihil autem</h4>
                                        <time datetime="2020-01-01">Jan 1, 2020</time>
                                    </div>

                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-2.jpg')}}" alt="">
                                        <h4>Quidem autem et impedit</h4>
                                        <time datetime="2020-01-01">Jan 1, 2020</time>
                                    </div>

                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-3.jpg')}}" alt="">
                                        <h4>Id quia et et ut maxime similique occaecati
                                            ut</h4>
                                        <time datetime="2020-01-01">Jan 1, 2020</time>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div id="similar-post">
                                <h4 class="sidebar-title">Artikel Terkait</h4>
                                <div class="sidebar-item recent-posts">
                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-1.jpg')}}" alt="">
                                        <h4>Nihil blanditiis at in nihil autem</h4>
                                        <time datetime="2020-01-01">Jan 1, 2020</time>
                                    </div>

                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-2.jpg')}}" alt="">
                                        <h4>Quidem autem et impedit</h4>
                                        <time datetime="2020-01-01">Jan 1, 2020</time>
                                    </div>

                                    <div class="post-item clearfix">
                                        <img src="{{asset('assets-landingpage/img/blog/blog-3.jpg')}}" alt="">
                                        <h4>Id quia et et ut maxime similique occaecati
                                            ut</h4>
                                        <time datetime="2020-01-01">Jan 1, 2020</time>
                                    </div>
                                    <hr>

                                </div>
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

    #blog a {
        color: #aaaaaa;
        text-decoration: underline;
    }

    #blog a:hover,
    #blog a:hover small {
        color: #ECB811 !important;
    }

    #blog .btn-primary i {
        color: #fff !important;
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
