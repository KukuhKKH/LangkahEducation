<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>@yield('title', 'Langkah Education')</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
        }

        .full-height {
            height: 100%;
        }

        .sticky-topbar {
            position: sticky;
            top: 0;
        }

        .quiz-list{
            width: 100%;
        }

        .btn-outline-dark{
            border-width: 2pt;
            font-weight: bold;
        }

        [id*="question"]{
            display: none;
        }

        .show{
            display: block !important;
        }

        @media only screen and (max-width: 999px) {
            #menu-soal{
                display: none;
            }
        }
    </style>

    @yield('css')
</head>

<body>
    @yield('content')

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    
    <!-- <script src="js/quiz.js"></script> -->
    <script src="{{asset('assets/js/tryout.js')}}"></script>

    @yield('js')
</body>

</html>