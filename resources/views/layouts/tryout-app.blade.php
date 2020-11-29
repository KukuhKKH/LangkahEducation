<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>@yield('title', 'Langkah Education')</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <!-- Custom styles for this template-->
    <link href="{{asset('assets-tryout/css/sb-admin-2.min.css')}}" rel="stylesheet">

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
    <script src="{{ asset('assets/vendor/sweet-alert/sweetalert.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    
    @yield('js')
    <!-- <script src="js/quiz.js"></script> -->
    {{-- <script src="{{asset('assets-tryout/js/tryout.js')}}"></script> --}}
    <script src="{{asset('assets-tryout/js/tryout_new.js')}}"></script>

    <script>
        var x
        var y
        function sisawaktu(t) {
            clearInterval(x)
            clearTimeout(y)
            var time = new Date(t);
            var n = new Date();
            x = setInterval(function() {
                if(time.getTime() > n.getTime()) {
                    var now = new Date().getTime();
                    var dis = time.getTime() - now;
                    var h = Math.floor((dis % (1000 * 60 * 60 * 60)) / (1000 * 60 * 60));
                    var m = Math.floor((dis % (1000 * 60 * 60)) / (1000 * 60));
                    var s = Math.floor((dis % (1000 * 60)) / (1000));
                    h = ("0" + h).slice(-2);
                    m = ("0" + m).slice(-2);
                    s = ("0" + s).slice(-2);
                    var cd = h + ":" + m + ":" + s;
                    if(h >= 0) {
                        $('.sisawaktu').html(cd);
                    }
                } else {
                    return
                }
            }, 100);
            y = setTimeout(function() {
                waktuHabis();
            }, (time.getTime() - n.getTime()));
        }
    </script>

</body>

</html>