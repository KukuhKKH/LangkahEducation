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
                                <img class="img-circle img-cover" src="{{asset('assets/img/undraw_profile.svg') }}" height="100px">
                                <h4 class="font-weight-bold mt-3">Ammar Muhammad</h4>
                                <h6 class="text-grey">Mahasiswa Ideal</h6>
                                <div class="bg-light mt-3 p-5">
                                    <p class="font-italic">"Cobalah melihat pada sisi yang tak terlihat. Jika tetep ga kelihatan coba deh nyalain lampu"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <a href="">
                                    <h4 class="font-weight-bold mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Quibusdam, velit.</h4>
                                </a>
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

                                <a href="#" class="btn-link">Read More</a>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <a href="">
                                    <h4 class="font-weight-bold mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Quibusdam, velit.</h4>
                                </a>
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

                                <a href="#" class="btn-link">Read More</a>
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
