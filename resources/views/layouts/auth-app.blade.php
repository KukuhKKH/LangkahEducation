<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Langkah Education')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">

    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/dashboard.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/langkahedu.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link href="{{asset('assets-landingpage/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets-landingpage/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
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

<body class="bg-light">
    <div class="container">
        @yield('content')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/dashboard.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function() {
          $('.only-number').on('keydown', '.number', function(e){
              -1!==$
              .inArray(e.keyCode,[46,8,9,27,13,110,190]) || /65|67|86|88/
              .test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey)
              || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey|| 48 > e.keyCode || 57 < e.keyCode)
              && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
          });
        })
    </script>   
    @yield('js')

</body>

</html>
