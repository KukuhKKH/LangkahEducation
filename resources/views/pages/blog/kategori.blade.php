@extends('layouts.app')

@section('title', 'Kategori Blog - Langkah Education')
    @section('content')
    <!-- ======= Header ======= -->
    @include('partials.landingpage.header-blog')
    <main id="main">
        <section id="blog" class="blog">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 mb-3">
                        <label style="font-size:10pt" for="">Urutkan berdasarkan</label>
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <select class="custom-select custom-select-sm" name="time">
                                            <option selected disabled>== Waktu ==</option>
                                            <option value="DESC">Terbaru</option>
                                            <option value="ASC">Terdahulu</option>
                                          </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <select class="custom-select custom-select-sm" name="pop">
                                            <option selected disabled>== Popularitas ==</option>
                                            <option value="popular">Terpopuler</option>
                                            <option value="euh">Biasa</option>
                                          </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <button type="submit" class="btn btn-light text-secondary btn-sm">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 mb-3">
                        @forelse ($artikel as $value)
                            <div class="card shadow mb-4">
                                <div class="card-img-top">
                                    @if ($value->foto)
                                    <img src="{{asset("upload/blog/$value->foto")}}" class=""
                                    height="200px">
                                    @else
                                    <img src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" class="img-cover"
                                        height="200px">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('page.blog.detail', $value->slug) }}">
                                        <h4 class="font-weight-bold mb-4">{{ $value->judul }}</h4>
                                    </a>
                                    <div class="d-flex justify-content-start align-items-center mb-4">
                                        <i class="fa fa-sm fa-user"></i>
                                        <a href="{{ route('page.blog.author', $value->user->api_token) }}"><small class="mx-2">{{ $value->user->name }}</small></a>

                                        <i class="fa fa-sm fa-clock"></i>
                                        <small class="mx-2">{{ Carbon\Carbon::parse($value->updated_at)->format('F d, Y') }}</small>
                                    </div>

                                    @php
                                        $string = preg_replace("/&#?[a-z0-9]+;/i", " ", $value->isi);
                                    @endphp
                                    <p>{{ (strlen(strip_tags($string)) > 200) ? substr(strip_tags($string), 0, 200) . '...' : strip_tags($string) }}</p>

                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <a href="{{ route('page.blog.detail', $value->slug) }}" class="btn-link">Read More</a>
                                        </div>
                                        <div class="col-6 text-right d-flex justify-content-end">
                                            <h6 class="font-weight-bold text-dark mt-3 mr-2"><i class="fa fa-thumbs-up"></i> {{ count($value->like) }}</h6>
                                            <h6 class="font-weight-bold text-dark mt-3"><i class="fa fa-comment"></i> {{ count($value->komentar) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        @empty
                        <div class="text-center">
                            <img class="mb-3" height="50px" src="{{asset('/assets-landingpage/img/null-icon.svg')}}" alt="">
                            <h6>Tidak Ada Artikel</h6>
                        </div>
                        @endforelse
                        {{ $artikel->links() }}
                    </div>
                    <div class="col-xl-4">
                        <div class="card shadow">
                            <div class="sidebar">
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
                                                <h4 class="text-dark">
                                                    <a href="{{ route('page.blog.detail', $value->slug) }}">{{ $value->judul }}</a>
                                                </h4>
                                                <time datetime="2020-01-01">{{ Carbon\Carbon::parse($value->updated_at)->format('F d, Y') }}</time>
                                            </div>
                                        <hr>
    
                                        @empty
                                            <h6>Belum ada artikel</h6>
                                        @endforelse
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

        #blog a{
            color: #444444;
        }

        #blog a:hover,
        #blog a:hover small {
            color: #ECB811 !important;
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
