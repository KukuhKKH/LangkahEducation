@extends('layouts.app')
@section('title', 'Detail Blog - Langkah Education')
@section('keyword'){{str_replace(' ', ',', $artikel->judul)}}@endsection
@section('content')
<!-- ======= Header ======= -->
@include('partials.landingpage.header-blog')
<main id="main">
    <section id="blog" class="blog">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mb-3">
                    <div class="card shadow mb-2">
                        <div class="card-img-top">
                            @if ($artikel->foto)
                            <img src="{{asset("upload/blog/$artikel->foto")}}" class=""
                            height="200px">
                            @else
                            <img src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" class="img-cover"
                                height="200px">
                            @endif
                        </div>
                        <div class="card-body">
                            <h4 class="font-weight-bold mb-4">{{$artikel->judul}}</h4>
                            <div class="d-flex justify-content-start align-items-center mb-4">
                                <i class="fa fa-sm fa-user"></i>
                                <a id="author" href="{{ route('page.blog.author', $artikel->user->api_token) }}"><small class="mx-2">{{ $artikel->user->name }}</small></a>

                                <i class="fa fa-sm fa-clock"></i>
                                <small class="mx-2">{{ Carbon\Carbon::parse($artikel->updated_at)->format('d F Y, H:i') }}</small>
                            </div>
                            @php
                                $string = preg_replace("/&#?[a-z0-9]+;/i", " ", $artikel->isi);
                            @endphp
                            <div id="isi-artikel" class="table-responsive">
                                {!! $string !!}
                            </div>
                            <div class="text-right mt-3">
                                <div class="d-flex justify-content-end align-items-center">
                                    <small id="textLike" class="mr-2"><span id="totalLike">{{ count($artikel->like) }}</span> Suka</small>
                                    @auth
                                    <button id="btnLike" class="btn btn-primary btn-sm"><i id="icoLike"class="fa fa-thumbs-up mr-1"></i>Like</button>    
                                    @endauth
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
                                            <img class="img-profile rounded-circle avatar" src="{{ (auth()->user()->foto) ? asset("upload/users/". auth()->user()->foto) : asset('assets/img/default_avatar.svg') }}">
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
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-paper-plane"></i> Kirim Komentar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endguest
                            </div>
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <label class="mt-3">Komentar :</label>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="font-weight-bold text-dark mt-3">{{ count($artikel->komentar) }} Komentar</small>
                                </div>
                            </div>
                            <div id="comment-list" class="bg-light p-4">
                                @forelse ($komentar as $value)
                                    <div class="row my-2" id="komentar">
                                        <div class="col-auto">
                                            @if ($value->user->foto)
                                            <?php $foto = $value->user->foto ?>
                                            <img src="{{asset("upload/users/$foto") }}" class="avatar" alt="Avatar">    
                                            @else
                                            <img src="{{asset('assets/img/undraw_profile.svg') }}" class="avatar" alt="Avatar">    
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
                    <div class="card shadow">
                        <div class="sidebar">
                            <div id="other-post">
                                <h4 class="sidebar-title">Recent Post</h4>
                                <div class="sidebar-item recent-posts">
                                    @forelse ($lainnya as $value)
                                        <div class="post-item clearfix">
                                            @if ($value->foto)
                                                <img src="{{asset("upload/blog/$value->foto")}}" alt="">
                                            @else
                                                <img src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" alt="">
                                            @endif
                                            <h4>
                                                <a href="{{ route('page.blog.detail', $value->slug) }}">{{ $value->judul }}</a>
                                            </h4>
                                            <time datetime="2020-01-01">{{ Carbon\Carbon::parse($value->updated_at)->format('F d, Y') }}</time>
                                        </div>
                                    @empty
                                        <h6>Belum ada artikel</h6>
                                    @endforelse
    
                                    <hr>
                                </div>
                            </div>
                            <div id="populer-post">
                                <h4 class="sidebar-title">Populer Post</h4>
                                <div class="sidebar-item recent-posts">
                                    @forelse ($artikel_like as $value)
                                        <div class="post-item clearfix">
                                            @if ($value->foto)
                                                <img src="{{asset("upload/blog/$value->foto")}}" alt="">
                                            @else
                                                <img src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" alt="">
                                            @endif
                                            <h4>
                                                <a href="{{ route('page.blog.detail', $value->slug) }}">{{ $value->judul }}</a>
                                            </h4>
                                            <time datetime="2020-01-01">{{ Carbon\Carbon::parse($value->updated_at)->format('F d, Y') }}</time>
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
                                            @if ($value->foto)
                                                <img src="{{asset("upload/blog/$value->foto")}}" alt="">
                                            @else
                                                <img src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" alt="">
                                            @endif
                                            <h4><a href="{{ route('page.blog.detail', $value->slug) }}">{{ $value->judul }}</a></h4>
                                            <time>{{ Carbon\Carbon::parse($value->updated_at)->format('F d, Y') }}</time>
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

    #isi-artikel a{
        color: #007bff !important;
        text-decoration: none;
        background-color: transparent;
    }

    #isi-artikel a:hover{
        color: #2a2af0 !important;
        text-decoration: underline;
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
var like = {{ $btn_like }};
@auth
const USER_ID = {{ auth()->user()->id }}
@endauth
const BLOG_ID = {{ $artikel->id }}
const ENDPOINT = `{{ url('api/v1/blog/like/status/') }}`
let textLike = $('#totalLike')[0].innerHTML
if(like == 1) {
    $("#btnLike").removeClass('btn-primary');
    $("#btnLike").addClass('btn-secondary');
    $("#btnLike").html('<i id="icoLike"class="fa fa-thumbs-down mr-1"></i>Batal');
} else {
    $("#btnLike").addClass('btn-primary');
    $("#btnLike").removeClass('btn-secondary');
    $("#btnLike").html('<i id="icoLike"class="fa fa-thumbs-up mr-1"></i>Like');
}
$("#btnLike").click(function() {
    if (like == 1) {
        $("#btnLike").addClass('btn-primary');
        $("#btnLike").removeClass('btn-secondary');
        $("#btnLike").html('<i id="icoLike"class="fa fa-thumbs-up mr-1"></i>Like');
        set_like(BLOG_ID, USER_ID, 0)
        like = 0;
        textLike--
        $('#totalLike')[0].innerHTML = textLike
    }else if(like==0){
        $("#btnLike").removeClass('btn-primary');
        $("#btnLike").addClass('btn-secondary');
        $("#btnLike").html('<i id="icoLike"class="fa fa-thumbs-down mr-1"></i>Batal');
        set_like(BLOG_ID, USER_ID, 1)
        like = 1;
        textLike++
        $('#totalLike')[0].innerHTML = textLike
    }
});

function set_like(blog_id, user_id, status) {
    // await Promise((resolve, reject) => {
        fetch(`${ENDPOINT}/${blog_id}/${user_id}/${status}`, {
            method: 'POST',
            body: {
                blog_id:blog_id,
                user_id:user_id,
                status:status
            }
        })
        .then(response => response.json())
        .then(data => console.log(data))
    // })
}

</script>
@endsection
