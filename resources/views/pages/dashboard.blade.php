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
                        <canvas id="myPengunjung"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="text-center" id="loading" style="display: none">
                <div class="spinner-border text-primary spinner-border-lg" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <form action="" method="GET">
                <div class="row align-items-center mb-4">
                    <div class="col-xl-5">
                        <select name="gelombang" id="gelombang" class="form-control" autocomplete="off">
                            <option value="" selected disabled>-- Pilih Gelombang --</option>
                            @foreach ($gelombang as $value)
                                <option value="{{ $value->id }}">{{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-5">
                        <select name="paket" id="paket" class="form-control" autocomplete="off">
                            <option value="" selected disabled>-- Pilih Paket --</option>
                        </select>
                    </div>
                    <div class="col-xl-auto">
                        <button type="submit" class="btn btn-primary mt-2 mb-2">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        @if (request()->get('gelombang') && request()->get('paket'))
            <div class="col-xl-3 col-md-3 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Sudah Dikomentari</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudah_komentar ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Belum Dikomentari</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belum_komentar ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Siswa Lolos Prodi 1</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa_pg['total_lolos_1'] ?? 0 }} / {{ $total_siswa_pg['total_siswa'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-rocket fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Siswa Lolos Prodi 2</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa_pg['total_lolos_2'] ?? 0 }} / {{ $total_siswa_pg['total_siswa'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-rocket fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Nilai Siswa - Saintek</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row justify-content-end">
                                    <div class="col-xl-12" style="height: 275px">
                                        <canvas id="mySaintekChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-xl-4">
                <div class="row">
                    <div class="col-xl-12 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2 ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Nilai Maksimal - Saintek</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa_pg['maxSaintek'] ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Nilai Maksimal - Soshum</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa_pg['maxSoshum'] ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Nilai Siswa - Soshum</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row justify-content-end">
                                    <div class="col-xl-12" style="height: 275px">
                                        <canvas id="mySoshumChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Penyebaran Kelompok</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPenyebaran"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> SAINTEK
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> SOSHUM
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endhasanyrole

@hasanyrole('sekolah')
    <div class="row">
        <div class="col-xl-12 text-center">
            <img class="img-fluid" src="{{asset('assets/img/welcome-illustration.svg')}}" alt="">
            <h3 class="mt-3">Selamat Datang <span class="font-weight-bold">{{ auth()->user()->name }}</span></h3>
        </div>
    </div>
@endhasanyrole

@hasanyrole('siswa')
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">Riwayat Nilai</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myRiwayatNilai"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- @if ($kelompok)
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <form action="#" class="mt-4">
                            <input type="hidden">
                            <div class="form-group">
                                <label for="kelompok">Kelompok</label>
                                <select name="kelompok"class="form-control" required>
                                    <option value="" selected disabled>== Kelompok Ujian ==</option>
                                    <option value="0">SAINTEK</option>
                                    <option value="1">SOSHUM</option>
                                </select>
                            </div>
                            <input type="hidden" value="{{ $kelompok->kelompok_passing_grade_id }}">
                            <div class="form-group">
                                <label for="prodi-1">Pilihan 1</label>
                                <select name="prodi-1" id="prodi-1" class="form-control" required>
                                    <option value="" selected disabled>== Program Studi Pilihan 1 ==</option>
                                    @foreach ($passing_grade as $value)
                                    <option value="{{ $value->id }}">({{ $value->passing_grade }}%)
                                        {{ $value->universitas->nama }} - {{ $value->prodi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="prodi-2">Pilihan 2</label>
                                <select name="prodi-2" id="prodi-2" class="form-control" required>
                                    <option value="" selected disabled>== Program Studi Pilihan 1 ==</option>
                                    @foreach ($passing_grade as $value)
                                    <option value="{{ $value->id }}">({{ $value->passing_grade }}%)
                                        {{ $value->universitas->nama }} - {{ $value->prodi }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <button class="btn btn-langkah btn-block">Ubah Pilihan</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif --}}
    </div>
@endhasanyrole

@hasanyrole('mentor')
    <div class="row">
        <div class="col-xl-12">
            <div class="text-center" id="loading" style="display: none">
                <div class="spinner-border text-primary spinner-border-lg" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <form action="" method="GET">
                <div class="row align-items-center mb-4">
                    <div class="col-xl-5">
                        <select name="gelombang" id="gelombang" class="form-control" autocomplete="off">
                            <option value="" selected disabled>-- Pilih Gelombang --</option>
                            @foreach ($gelSekolah as $value)
                                <option value="{{ $value->id }}">{{ $value->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-5">
                        <select name="paket" id="paket" class="form-control i" autocomplete="off">
                            <option value="" selected disabled>-- Pilih Paket --</option>
                        </select>
                    </div>
                    <div class="col-xl-auto">
                        <button type="submit" class="btn btn-primary mt-2 mb-2">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Siswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Nilai Tertinggi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nilai_tertinggi ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rocket fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Rata-Rata Nilai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ round($rata, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (request()->get('gelombang') && request()->get('paket'))
            <div class="col-xl-3 col-md-3 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Sudah Dikomentari</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudah_komentar ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Belum Dikomentari</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belum_komentar ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Siswa Lolos Prodi 1</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['total_lolos_1'] ?? 0 }} / {{ $data['total_siswa'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-rocket fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Siswa Lolos Prodi 2</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['total_lolos_2'] ?? 0 }} / {{ $data['total_siswa'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-rocket fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Nilai Siswa - Saintek</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row justify-content-end">
                                    <div class="col-xl-12" style="height: 275px">
                                        <canvas id="mySaintekChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-xl-4">
                <div class="row">
                    <div class="col-xl-12 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2 ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Nilai Maksimal - Saintek</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['maxSaintek'] ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Nilai Maksimal - Soshum</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['maxSoshum'] ?? 0 }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Nilai Siswa - Soshum</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row justify-content-end">
                                    <div class="col-xl-12" style="height: 275px">
                                        <canvas id="mySoshumChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Penyebaran Kelompok</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPenyebaran"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> SAINTEK
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> SOSHUM
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endhasanyrole
@hasanyrole('author|superadmin|mentor|admin')
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Artikel Terpublish</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $artikel_publish ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-search fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah Artikel Di Draft</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $artikel_draft ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-search fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Jumlah Seluruh Artikel</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_artikel ?? 0 }}</div>
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
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel Saya dengan Like Terbanyak</h6>
                </div>
                <div class="card-body">
                    {{-- CUMA 3 ARTIKEL --}}
                    @forelse ($artikelmu_like as $value)
                        <div class="row align-items-center">
                            <div class="col-3">
                            <?php $foto = $value->foto; ?>
                            @if ($value->foto)
                            <img class="img-cover" src="{{asset("upload/blog/$foto")}}" alt="" width="100%" height="75px">
                            @else
                            <img class="img-cover" src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" alt="" width="100%" height="75px">
                            @endif
                            </div>
                            <div class="col-9">
                                <h6 class="font-weight-bold">{{ $value->judul }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-gray-800" href="{{ route('page.blog.detail', $value->slug) }}">Lihat Artikel</a>
                                    <small class="font-weight-bold text-primary mt-3 mr-2"><i class="fa fa-thumbs-up"></i> {{ $value->like_count }}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @empty
                    <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Artikel</h6>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel Saya dengan Komentar Terbanyak</h6>
                </div>
                <div class="card-body">
                    {{-- CUMA 3 ARTIKEL --}}
                    @forelse ($artikelmu_komentar as $value)
                        <div class="row align-items-center">
                            <div class="col-3">
                            <?php $foto = $value->foto; ?>
                            @if ($value->foto)
                            <img class="img-cover" src="{{asset("upload/blog/$foto")}}" alt="" width="100%" height="75px">
                            @else
                            <img class="img-cover" src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" alt="" width="100%" height="75px">
                            @endif

                            </div>
                            <div class="col-9">
                                <h6 class="font-weight-bold">{{ $value->judul }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-gray-800" href="{{ route('page.blog.detail', $value->slug) }}">Lihat Artikel</a>
                                    <small class="font-weight-bold text-primary mt-3 mr-2"><i class="fa fa-comment"></i> {{ $value->komentar_count }}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @empty
                    <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Artikel</h6>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Semua Artikel dengan Like Terbanyak</h6>
                </div>
                <div class="card-body">
                    {{-- CUMA 3 ARTIKEL --}}
                    @forelse ($artikel_like as $value)
                        <div class="row align-items-center">
                            <div class="col-3">
                            <?php $foto = $value->foto; ?>
                            @if ($value->foto)
                            <img class="img-cover" src="{{asset("upload/blog/$foto")}}" alt="" width="100%" height="75px">
                            @else
                            <img class="img-cover" src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" alt="" width="100%" height="75px">
                            @endif
                            </div>
                            <div class="col-9">
                                <h6 class="font-weight-bold">{{ $value->judul }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-gray-800" href="{{ route('page.blog.detail', $value->slug) }}">Lihat Artikel</a>
                                    <small class="font-weight-bold text-primary mt-3 mr-2"><i class="fa fa-thumbs-up"></i> {{ $value->like_count }}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @empty
                    <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Artikel</h6>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Semua Artikel dengan Komentar Terbanyak</h6>
                </div>
                <div class="card-body">
                    {{-- CUMA 3 ARTIKEL --}}
                    @forelse ($artikel_komentar as $value)
                        <div class="row align-items-center">
                            <div class="col-3">
                            <?php $foto = $value->foto; ?>
                             @if ($value->foto)
                            <img class="img-cover" src="{{asset("upload/blog/$foto")}}" alt="" width="100%" height="75px">
                            @else
                            <img class="img-cover" src="{{asset('assets-landingpage/img/blog/default-blog.jpg')}}" alt="" width="100%" height="75px">
                            @endif
                            </div>
                            <div class="col-9">
                                <h6 class="font-weight-bold">{{ $value->judul }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="text-gray-800" href="{{ route('page.blog.detail', $value->slug) }}">Lihat Artikel</a>
                                    <small class="font-weight-bold text-primary mt-3 mr-2"><i class="fa fa-comment"></i> {{ $value->komentar_count }}</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @empty
                    <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Artikel</h6>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
@endhasanyrole

@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/annotation.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>

    <!-- Page level custom scripts -->
    {{-- <script src="{{ asset('assets/js/chart-pengunjung-harian.js') }}"></script> --}}
    @hasanyrole('superadmin|admin')
        <script>
            var ctx3 = document.getElementById("myPengunjung");
            var myLineChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: {!!     json_encode($label3 ?? []) !!},
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
                data: {!! json_encode($totals ?? []) !!},
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
        </script>

    @endhasanyrole

    @hasanyrole('siswa')
        @php
            $nmKelompok= [];
        @endphp
        @foreach ($idKelompok as $item)
            @php
                $nmKelompok[]= App\Models\KelompokPassingGrade::find($item->idKel)->nama;

            @endphp
        @endforeach
        @php
            $siswaKategori = [];
            for ($i=0; $i <count($nama_paket) ; $i++) { 
                $paket = $nama_paket[$i];
                $kategori = strtoupper($nmKelompok[$i]);
                $siswaKategori[]=$paket."\n(".$kategori.")";
            }
        @endphp
        <script>
                $("#prodi-1").select2();
                $("#prodi-2").select2();
        </script>
        <script>
            let ctx = document.getElementById("myRiwayatNilai")
            let data_riwayat = {
                labels: {!! json_encode($siswaKategori ?? []) !!}  ,
                datasets: [{
                    label: "Nilai",
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
                    data: {!! json_encode($nilai_grafik ?? []) !!},
                }],
            }
            new Chart(ctx, {
                type: 'line',
                data: data_riwayat,
                options: barOptions
            })
        </script>
    @endhasanyrole

    @hasanyrole('mentor|superadmin|admin')
        <script>
            var ctx = document.getElementById("myPenyebaran");
            var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["SAINTEK", "SOSHUM"],
                    datasets: [{
                        data: {!! json_encode($val ?? []) !!},
                        backgroundColor: ['#4e73df', '#1cc88a'],
                        hoverBackgroundColor: ['#2e59d9', '#17a673'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 50,
                },
            });
            
            // Grafik Persaingan Saintek
            let ctxSaintek = document.getElementById("mySaintekChart");
            let data_saingan = {
                // labels: {!! json_encode($siswaKategori ?? []) !!},
                labels: {!! json_encode($labelSaintek ?? []) !!},
                datasets: [{
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: {!! json_encode($valSaintek ?? []) !!},
                }],
            }
            new Chart(ctxSaintek, {
                type: 'bar',
                data: data_saingan,
                options: barOption2
            })

            // Grafik Persaingan Soshum
            let ctxSoshum = document.getElementById("mySoshumChart");
            let data_saingan2 = {
                // labels: {!! json_encode($label2 ?? []) !!},
                labels: {!! json_encode($labelSoshum ?? []) !!},
                datasets: [{
                    backgroundColor: "#1cc88a",
                    hoverBackgroundColor: "#18b87e",
                    borderColor: "#1cc88a",
                    data: {!! json_encode($valSoshum ?? []) !!},
                }],
            }
            new Chart(ctxSoshum, {
                type: 'bar',
                data: data_saingan2,
                options: barOption2
            })
        </script>
    @endhasanyrole

    @hasanyrole('author')
    @endhasanyrole
    
    <script>
        const URL = `{{ url('api/v1/paket-tryout') }}`
        $('#gelombang').on('change', function() {
            $("#loading").show()
            let gelombang_id = $(this).val()
            new Promise((resolve, reject) => {
                $.ajax({
                    url: `${URL}/${gelombang_id}`,
                    method: 'GET',
                    dataType: 'JSON'
                })
                .done(res => {
                    $("#loading").hide()
                    $("#paket").html(`<option value="" selected disabled>-- Pilih Paket --</option>`)
                    res.data.tryout.forEach(el => {
                        $("#paket").append(`<option value="${el.id}">${el.nama}</option>`)
                    })
                })
                .fail(err => {
                    $("#loading").hide()
                    console.log(err)
                })
            })
        })
    </script>
@endsection