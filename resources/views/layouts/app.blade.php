<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="langkah edu, langkah education, tryout sma, sbmptn online, bimbel sbmptn, info sbmptn, simulasi sbmptn, ,lolos sbmptn, lolos ptn, info ptn, passing grade,trik lulus sbpmtn,bimbingan sbmptn, bimbel saintek, bimbel soshum, soal sbmptn, pengumuman sbmptn, sbmptn, maba, soshum, saintek ,ptn, utul, simak ui">
    <meta name="description" content="Langkah Education adalah website belajar untuk persiapan tes seleksi masuk PTN">
    <meta property="og:site_name" content="Langkah Education">
    <meta property="og:url" content="https://langkaheducation.com">
    <meta property="og:title" content="Langkah Education">
    <meta property="og:description"
        content="Belajar persiapan masuk PTN secara praktis dan efektif. Dilengkapi fitur tryout latihan beserta statistik pencapaian.">

    <!-- Favicons -->
    <link href="{{asset('assets-landingpage/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets-landingpage/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('assets-landingpage/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets-landingpage/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets-landingpage/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets-landingpage/css/landing.css')}}" rel="stylesheet">
    <title>Langkah Education</title>
    @yield('css')

</head>

<body>
@yield('content')

@include('partials.landingpage.footer')
@yield('js')
</body>

</html>
