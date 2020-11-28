<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Langkah Education')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">--}}

    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <!-- Custom styles for this template-->
    <link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/langkahedu.css')}}" rel="stylesheet">

    <style>
        .toast-success {
            color: #ffffff;
            border-color: #1bbf89;
            background-color: #1bbf89;
        }
        .toast-warning {
            color: #ffffff;
            border-color: #f7af3e;
            background-color: #f7af3e;
        }
        .toast-info {
            color: #ffffff;
            border-color: #56c0e0;
            background-color: #56c0e0;
        }
        .toast-error {
            color: #ffffff;
            border-color: #db524b;
            background-color: #db524b;
        }
        #toast-container > div {
            opacity: 1;
            margin-top: 20px;
            border-radius: 4px;
            padding: 20px 20px 20px 50px;
            -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }
        #toast-container > div:hover {
            -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
            -moz-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
        }
        #toast-container.toast-top-right > div {
            margin-top: 60px;
        }
        #btn-submit {
            cursor: pointer;
        }
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
    </style>

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
        <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>

        <script src="{{ asset('assets/vendor/sweet-alert/sweetalert.min.js') }}"></script>

        <script>
            const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            var barOptions = {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            scaleBeginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 10,
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
            };
        </script>

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
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
                @if (session('success'))
                toastr.success('{!! session('success') !!}', 'Suksess')
                @endif

                @if (session('error'))
                toastr.error(`{!! session('error') !!}`, 'Error')
                @endif

                @foreach ($errors->all() as $error)
                    toastr.error(`{!! $error !!}`, 'Error')
                @endforeach
            })
        </script>

    </body>

</html>
