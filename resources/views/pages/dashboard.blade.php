@extends('layouts.dashboard-app')
@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
@hasanyrole('superadmin|admin')
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Belum Dikonfirmasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belum_bayar }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Sekolah
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sekolah }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-home fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $siswa }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pengunjung Hari ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengunjung }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-search fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Statistik Pengunjung Harian</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endhasanyrole

@hasanyrole('sekolah|siswa|mentor|author')
    <div class="row">
        <div class="col-xl-12 text-center">
            <img class="img-fluid" src="{{asset('assets/img/welcome-illustration.svg')}}" alt="">
            <h3 class="mt-3">Selamat Datang <span class="font-weight-bold">{{ auth()->user()->name }}</span></h3>
        </div>
    </div>
@endhasanyrole
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    {{-- <script src="{{ asset('assets/js/chart-pengunjung-harian.js') }}"></script> --}}
    <script>
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!!     json_encode($label ?? []) !!},
            datasets: [{
            label: "Total Pengunjung",
            lineTension: 0.3,
            backgroundColor: "rgba(236, 184, 17, 0.05)",
            borderColor: "rgba(236, 184, 17, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(212, 166, 15, 1)",
            pointBorderColor: "rgba(212, 166, 15, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(51, 51, 51, 1)",
            pointHoverBorderColor: "rgba(51, 51, 51, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: {!! json_encode($total ?? []) !!},
            }],
        },
        options: {
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
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            }
        }
        });
        // history.pushState(null, null, document.URL);
        // window.addEventListener('popstate', function () {
        //     swal.fire({
        //         title: 'WOYYY?',
        //         text: "anda tidak bisa kembali ke kategori sebelumnya!",
        //         icon: 'warning',
        //     })
        //     history.pushState(null, null, document.URL);
        // })
    </script>
@endsection