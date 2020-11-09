<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@stack('title', 'Langkah Education')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

    @yield('css')
</head>

<body>

    <body id="page-top">
        <div id="wrapper">
            @include('partials.dashboard.sidebar')
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    @include('partials.dashboard.topbar')
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                @include('partials.dashboard.footer')
            </div>
        </div>

        @include('partials.dashboard.scroll-topbar')


        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
        <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>

        @yield('js')

        <script>
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "showEasing": "swing",
                "timeOut": "6000"
            }
            $(document).ready(function() {
                @if (session('success'))
                toastr.success('{!! session('success') !!}', 'Suksess')
                @endif

                @if (session('error'))
                toastr.error(`{!! session('error') !!}`, 'Error')
                @endif
            })
        </script>

    </body>

</html>
