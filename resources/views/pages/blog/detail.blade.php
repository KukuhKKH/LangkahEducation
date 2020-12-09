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
                        <div class="card-img-top">
                            @if ($artikel->foto)
                            <img src="{{asset("upload/blog/$artikel->foto")}}" class="img-cover"
                            height="200vh">
                            @else
                            <img src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" class="img-cover"
                                height="200vh">
                            @endif
                        </div>
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-4">{{$artikel->judul}}</h4>
                            <div class="d-flex justify-content-start align-items-center mb-4">
                                <i class="fa fa-sm fa-user"></i>
                                <a id="author" href="{{ route('page.blog.author', $artikel->user->api_token) }}"><small class="mx-2">{{ $artikel->user->name }}</small></a>

                                <i class="fa fa-sm fa-clock"></i>
                                <small class="mx-2">{{ Carbon\Carbon::parse($artikel->created_at)->format('d F Y, H:i') }}</small>
                            </div>
                            @php
                                $string = preg_replace("/&#?[a-z0-9]+;/i", " ", $artikel->isi);
                            @endphp
                            {!! $string !!}

                            <div class="text-right">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <small id="textLike" class="mr-2"><span>123</span> Suka</small>
                                        <button id="btnLike" class="btn btn-primary btn-sm"><i id="icoLike"class="fa fa-thumbs-up mr-1"></i>Like</button>
                                    </div>
                            </div>

                            <hr>
                            
                            <div id="add-comment">
                                @guest
                                <h4>Login jika ingin membuat komentar</h4>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm text-white">Login</a>
                                @else    
                                <form action="{{ route('page.blog.komentar.store', $artikel->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-auto">
                                            @if (auth()->user()->foto)
                                            <?php $foto = auth()->user()->foto ?>
                                            <img src="{{asset("upload/>user/$foto") }}" class="avatar " alt="Avatar">    
                                            @else
                                            <img src="{{asset('assets/img/undraw_profile.svg') }}" class="avatar " alt="Avatar">    
                                            @endif
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <textarea name="komentar" id="add-komentar"
                                                    class="form-control @error('komentar') is-invalid @enderror"
                                                    placeholder="Masukkan Komentar" rows="4"></textarea>
                                                @error('komentar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-12 text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane"></i> Kirim Komentar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endguest
                            </div>
                            <label class="mt-3">Komentar :</label>

                            <div id="comment-list" class="bg-light p-4">
                                @forelse ($komentar as $value)
                                    <div class="row my-2" id="komentar">
                                        <div class="col-auto">
                                            @if ($value->user->foto)
                                            <img src="{{asset("upload/>user/$value->foto") }}" class="avatar " alt="Avatar">    
                                            @else
                                            <img src="{{asset('assets/img/undraw_profile.svg') }}" class="avatar " alt="Avatar">    
                                            @endif
                                        </div>
                                        <div class="col">
                                            <h6 class="font-weight-bold">{{ $value->user->name }}</h6>
                                            <p>{{ $value->komentar }}</p>
                                            <hr>
                                        </div>
                                    </div>
                                @empty
                                <h6 class="font-weight-bold">Belum ada komentar</h6>
                                @endforelse
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
                                        <img src="{{asset("upload/blog/$value->foto")}}" alt="">
                                        <h4>
                                            <a href="{{ route('page.blog.detail', $value->slug) }}">{{ $value->judul }}</a>
                                        </h4>
                                        <time datetime="2020-01-01">{{ Carbon\Carbon::parse($value->created_at)->format('F d, Y') }}</time>
                                    </div>
                                @empty
                                    <h6>Belum ada artikel</h6>
                                @endforelse

                                <hr>
                            </div>
                        </div>
                        <div id="similar-post">
                            <h4 class="sidebar-title">Artikel Terkait</h4>
                            <div class="sidebar-item recent-posts">
                                @forelse ($terkait as $value)
                                    <div class="post-item clearfix">
                                        <img src="{{asset("upload/blog/$value->foto")}}" alt="">
                                        <h4><a href="{{ route('page.blog.detail', $value->slug) }}">{{ $value->judul }}</a></h4>
                                        <time datetime="2020-01-01">{{ Carbon\Carbon::parse($value->created_at)->format('F d, Y') }}</time>
                                    </div>
                                @empty
                                    <h6>Belum ada artikel</h6>
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

    #blog #author {
        color: #aaaaaa;
        text-decoration: underline;
    }

    #blog a{
        color: #444444;
    }

    #blog a:hover,
    #blog a:hover small {
        color: #ECB811 !important;
    }

    #blog .btn-primary i {
        color: #fff !important;
    }

    #textLike{
        color: #000000;
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
<script>
var like = 1;
$("#btnLike").click(function() {
    if (like == 1) {
        $("#btnLike").removeClass('btn-primary');
        $("#btnLike").addClass('btn-secondary');
        $("#btnLike").html('<i id="icoLike"class="fa fa-thumbs-down mr-1"></i>Batal');
        like = 0;
    }else if(like==0){
        $("#btnLike").addClass('btn-primary');
        $("#btnLike").removeClass('btn-secondary');
        $("#btnLike").html('<i id="icoLike"class="fa fa-thumbs-up mr-1"></i>Like');
        like = 1;
    }
});

</script>
@endsection
