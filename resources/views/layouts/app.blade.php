<!doctype html>
<!--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">-->
<html lang="en">

<head>
     <meta charset="utf-8">
     <title>@yield('title', 'Langkah Education - #OneStepForThousandFutures')</title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
      <!-- Meta -->
      <meta name="keywords" content="@yield('keyword', 'Langkah Education, langkah edu, tryout sma, sbmptn online, bimbel sbmptn, info sbmptn, simulasi sbmptn, ,lolos sbmptn, lolos ptn, info ptn, passing grade,trik lulus sbpmtn,bimbingan sbmptn, bimbel saintek, bimbel soshum, soal sbmptn, pengumuman sbmptn, sbmptn, maba, soshum, saintek ,ptn, utul, simak ui')">
      <meta name="description" content="@yield('deskripsi', 'Langkah Education adalah website belajar untuk persiapan tes seleksi masuk PTN')">
    
      <meta property="og:site_name" content="Langkah Education">
      <meta property="og:url" content="https://langkaheducation.com">
      <meta property="og:title" content="Langkah Education - #OneStepForThousandFutures">
      <meta property="og:description" content="@yield('deskripsi', 'Langkah Education adalah website belajar untuk persiapan tes seleksi masuk PTN')">
      <meta property="og:image" content="{{asset('assets-landingpage/img/favicon.png')}}">
      <meta property="og:type" content="website">

    <!-- Favicons -->
    <link href="{{asset('assets-landingpage/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets-landingpage/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> --}}

    <!-- Vendor CSS Files -->
    <link href="{{asset('assets-landingpage/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets-landingpage/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets-landingpage/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets-landingpage/css/landing.css')}}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-74085S0Q6Y"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-74085S0Q6Y');
    </script>

    @yield('css')

</head>

<body>
@yield('content')
<div id="preloader"></div>

@include('partials.landingpage.footer')
@yield('js')
<script src="{{ asset('assets/vendor/sweet-alert/sweetalert.min.js') }}"></script>
<script>
    @if (session('success'))
    swal.fire({
        'Berhasil!',
        `{!! session('success') !!}`,
        'success'
    })
    @endif

    @if (session('error'))
    Swal.fire({
        icon: 'error',
        title: `{!! session('error') !!}`,
        text: 'Something went wrong!'
    })
    @endif
</script>
<script src="{{asset('assets-landingpage/js/main.js')}}"></script>

</body>

</html>
