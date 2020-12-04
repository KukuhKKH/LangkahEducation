@extends('layouts.app')
@section('content')
<!-- ======= Header ======= -->
@include('partials.landingpage.header-blog')
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
                                <a href="{{ route('page.blog.author', $artikel->user->author()->first()->kode) }}"><small class="mx-2">{{ $artikel->user->name }}</small></a>

                                <i class="fa fa-sm fa-clock"></i>
                                <small class="mx-2">{{ Carbon\Carbon::parse($artikel->created_at)->format('d F Y, H:i') }}</small>
                            </div>
                            @php
                                $string = preg_replace("/&#?[a-z0-9]+;/i", " ", $artikel->isi);
                            @endphp
                            {!! $string !!}

                            <hr>

                            <div id="add-comment">
                                @guest
                                <h4>Login jika ingin membuat komentar</h4>
                                @else    
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
                                @endguest
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
