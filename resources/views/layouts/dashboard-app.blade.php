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
    <link href="{{asset('assets/css/dashboard.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/langkahedu.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link href="{{asset('assets-landingpage/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets-landingpage/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
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
        .sidebar-brand{
          background: #000 !important;
          border-radius: 20px;
        }
        
        
        .sidebar-dark .sidebar-heading {
          color:  #fff !important;
          margin-bottom: 5px;
        }
        .sidebar-dark .nav-item.active .nav-link i {
          color:  #fff !important;
        }
        
        .sidebar-dark .nav-item .nav-link:hover {
          color:  #fff !important;
        }
        
        .sidebar-dark .nav-item .nav-link a{
          color:  #ffffff!important;
        }
        .sidebar-dark .nav-item.active{
          background-color:  #fff!important;
          border-radius: 10px;
          margin: 3px;
        }
        
        .sidebar-dark .nav-item.active .nav-link {
          color: #ECB811 !important;
        }
        
        .sidebar-dark .nav-item.active .nav-link i {
          color: #ECB811 !important;
        }
        
        .sidebar-dark .nav-item.active .nav-link:hover i {
          color: #ECB811 !important;
        }
        
        .sidebar-dark .nav-item .nav-link a:hover{
          color:  #ffffff !important;
        }
        
        .sidebar-dark .nav-item:hover .nav-link i {
          color:  #ffffff!important;
        }
        
        
        .sidebar-dark .nav-item.active .nav-link[data-toggle=collapse]::after {
          color: #fff !important;
        }
        
        @media only screen and (min-width: 768px) {
          .sidebar{
              margin: 0.5rem !important;
          }
        }
        
        .toggled .sidebar-brand{
          padding: 1.5rem !important;
        }
        
        .sidebar-dark #sidebarToggle {
          background-color: #000 !important;
        }
        
        .sidebar-dark #sidebarToggle:hover {
          background-color: rgba(0, 0, 0, 0.75) !important;
        }
        
        .sidebar-dark #sidebarToggle::after {
          color: rgba(255,255,255,1) !important;
        }
        
        .sidebar .nav-item{
            margin: 3px;
        }
        
        .sidebar .nav-item:hover{
            background-color: #5e480046;
            border-radius: 10px;
        }

        .sidebar .nav-item:hover #userDropdown{
            background-color: #ffffff00 !important;
            border-radius: 10px;
        }
        
        .sidebar.toggled .nav-item .nav-link {
            width:100% !important;
        }
    </style>
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-EM1ZQM2LE7"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-EM1ZQM2LE7');
    </script> --}}

    @yield('css')
</head>

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
    <script src="{{asset('assets/js/dashboard.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/sweet-alert/sweetalert.min.js') }}"></script>
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
    <script>
        @if(request()->is('dashboard/siswa/hasil/tryout/*') || request()->is('dashboard/hasiltryout/siswa/*'))
        let pg1 = {{ $nil_pg1 ?? 0 }}
        let pg2 = {{ $nil_pg2 ?? 0 }}

        var pg1_name = "{{ $pg1->universitas->nama }} - {{ $pg1->prodi }}";
        var pg2_name = "{{ $pg2->universitas->nama }} -  {{ $pg2->prodi }}";
        @endif
        @if(request()->is('dashboard'))
        let pg1 = {{ $nil_pg1 ?? 0 }}
        let pg2 = {{ $nil_pg2 ?? 0 }}

            @if(request()->get('prodi-1'))
                var pg1_name = "{{ $pg1->universitas->nama }} - {{ $pg1->prodi }}";
                var pg2_name = "{{ $pg2->universitas->nama }} -  {{ $pg2->prodi }}";
            @endif
        @endif
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
                        scaleBeginAtZero: true,
                        maxTicksLimit: 7,
                        callback: function(tick) {
                            var characterLimit = 10;
                            if ( tick.length >= characterLimit) {
                                return tick.slice(0, tick.length).substring(0, characterLimit -1).trim() + '...';;
                            } 
                            return tick;
                        }   
                    }
                }],
                yAxes: [{
                    ticks: {
                        min:0,
                        max: 100,
                        scaleBeginAtZero: true,
                        maxTicksLimit: 10,
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
            @if(request()->get('prodi-1') != '')
            annotation: {
                annotations: [{
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: 'y-axis-0',
                    value: pg1,
                    borderColor: '#1cc88a',
                    borderWidth: 2,
                    label: {
                        enabled: true,
                        content: pg1_name
                    }
                }, {
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: 'y-axis-0',
                    value: pg2,
                    borderColor: '#4e73df',
                    borderWidth: 2,
                    label: {
                        enabled: true,
                        content: pg2_name
                    }
                }]
            }
            @endif
        };

        var barOption2 = {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                },
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date',
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        scaleBeginAtZero: true,
                        maxTicksLimit: 7,
                        callback: function(tick) {
                            var characterLimit = 5;
                            if ( tick.length >= characterLimit) {
                                return tick.slice(0, tick.length).substring(0, characterLimit -1).trim() + '...';;
                            } 
                            return tick;
                        }   
                    }
                }],
                yAxes: [{
                    ticks: {
                        scaleBeginAtZero: true,
                        min:0,
                        // max:100,
                        maxTicksLimit: 10,
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
            }
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
