@extends('layouts.app')
    @section('content')
    <!-- ======= Header ======= -->
    @include('partials.landingpage.header-blog')
    <main id="main">
        <section id="blog" class="blog">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card shadow mb-4 text-center p-4">
                            <div class="card-body text-align-center">
                                @if ($user->foto)
                                <?php $foto = $user->foto ?>
                                <img src="{{asset("upload/>user/$foto") }}" class="avatar " alt="Avatar">    
                                @else
                                <img src="{{asset('assets/img/undraw_profile.svg') }}" class="avatar " alt="Avatar">    
                                @endif
                                <h4 class="font-weight-bold mt-3">{{ $user->name }}</h4>
                                {{-- <h6 class="text-grey">Mahasiswa Ideal</h6>
                                <div class="bg-light mt-3 p-5">
                                    <p class="font-italic">"Cobalah melihat pada sisi yang tak terlihat. Jika tetep ga kelihatan coba deh nyalain lampu"
                                    </p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        @forelse ($artikel as $value)
                            <div class="card shadow mb-4">
                                <div class="card-img-top">
                                    <img src="{{asset('assets-landingpage/img/blog/blog-1.jpg')}}" class="img-cover"
                                        height="200vh">
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('page.blog.detail', $value->slug) }}">
                                        <h4 class="font-weight-bold mb-4">{{ $value->judul }}</h4>
                                    </a>
                                    <div class="d-flex justify-content-start align-items-center mb-4">
                                        <i class="fa fa-sm fa-user"></i>
                                        <a href=""><small class="mx-2">{{ $value->user->name }}</small></a>

                                        <i class="fa fa-sm fa-clock"></i>
                                        <small class="mx-2">{{ Carbon\Carbon::parse($value->created_at)->format('F d, Y') }}</small>
                                    </div>

                                    @php
                                        $string = preg_replace("/&#?[a-z0-9]+;/i", " ", $value->isi);
                                    @endphp
                                    <p>{{ (strlen(strip_tags($string)) > 200) ? substr(strip_tags($string), 0, 200) . '...' : strip_tags($string) }}</p>

                                    <a href="{{ route('page.blog.detail', $value->slug) }}" class="btn-link">Read More</a>
                                </div>
                            </div>    
                        @empty
                            <h4>Tidak ada artikel</h4>
                        @endforelse
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