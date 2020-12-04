@extends('layouts.app')
@section('content')
<!-- ======= Header ======= -->
@include('partials.landingpage.header-blog')
<main id="main">
    <section id="blog" class="blog">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    @forelse ($artikel as $value)
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <a href="{{ route('page.blog.detail', $value->slug) }}">
                                    <h4 class="font-weight-bold mb-4">{{ $value->judul }}</h4>
                                </a>
                                <div class="d-flex justify-content-start align-items-center mb-4">
                                    <i class="fa fa-sm fa-user"></i>
                                    <a href="{{ route('page.blog.author', $value->user->author()->first()->kode) }}"><small class="mx-2">{{ $value->user->name }}</small></a>

                                    <i class="fa fa-sm fa-clock"></i>
                                    <small class="mx-2">{{ Carbon\Carbon::parse($value->created_at)->format('F d, Y') }}</small>
                                </div>

                                @php
                                    $string = preg_replace("/&#?[a-z0-9]+;/i", " ", $value->isi);
                                @endphp
                                {!! $string !!}

                                <a href="{{ route('page.blog.detail', $value->slug) }}" class="btn-link">Read More</a>
                            </div>
                        </div>
                    @empty
                        <h4>Tidak ada artikel</h4>
                    @endforelse
                    
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

    #blog a h4{
        color : #343a40 !important
    }

    #blog a:hover h4{
        color :  #ECB811 !important
    }

    #header {
        background: #ECB811;
    }

    .btn-link{
        color: #aaaaaa  !important;
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
