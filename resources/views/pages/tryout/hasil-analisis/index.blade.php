@extends('layouts.dashboard-app')
@section('title', 'Hasil & Analisis')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Hasil & Analisis</h1>


<div class="row">
    <div class="col-xl-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Try Out - Batch 1</h6>
            </div>
            <div class="card-body">
                <table>
                    <tr>
                        <td class="font-weight-bold w-50">
                            Tanggal
                        </td>
                        <td>:</td>
                        <td>
                            DD/MM/YYYY
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">
                            Jam
                        </td>
                        <td>:</td>
                        <td>
                            HH:MM WIB
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">
                            Formasi
                        </td>
                        <td>:</td>
                        <td>
                            SAINTEK
                        </td>
                    </tr>
                </table>

                <form action="#" class="mt-4">
                    <div class="form-group">
                        <label for="prodi-1">Pilihan 1</label>
                        <select name="prodi-1" id="prodi-1" class="form-group">
                            <option value="">== Program Studi Pilihan 1 ==</option>
                            <option value="">(58%) Universitas Indonesia - Bahasa Inggris</option>
                            <option value="">(48%) Universitas Indonesia - Bahasa Indonesia</option>
                            <option value="">(52%) Universitas Indonesia - Kimia</option>
                            <option value="">(56%) Univesitas Brawijaya - Fisika</option>
                            <option value="">(54%) Universitas Gadjah Mada - Fisika</option>
                            <option value="">(56%) Institut Teknologi Sepuluh Nopember - Fisika</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi-2">Pilihan 2</label>
                        <select name="prodi-2" id="prodi-2" class="form-group">
                            <option value="">== Program Studi Pilihan 1 ==</option>
                            <option value="">(58%) Universitas Indonesia - Bahasa Inggris</option>
                            <option value="">(48%) Universitas Indonesia - Bahasa Indonesia</option>
                            <option value="">(52%) Universitas Indonesia - Kimia</option>
                            <option value="">(52%) Universitas Indonesia - Fisika</option>
                            <option value="">(56%) Univesitas Brawijaya - Fisika</option>
                            <option value="">(54%) Universitas Gadjah Mada - Fisika</option>
                            <option value="">(56%) Institut Teknologi Sepuluh Nopember - Fisika</option>
                        </select>
                    </div>

                    <button class="btn btn-langkah btn-block">Cek Hasil</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card shadow mb-4" height="100%">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Passing Grade</h6>
            </div>
            <div class="card-body">
                <h4 class="small font-weight-bold">(56%) Institut Teknologi Sepuluh Nopember - Fisika <span
                        class="float-right">90%</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="20"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <p class="mb-4 mt-2">Status : <span class="text-danger">BELUM LULUS</span></p>

                <h4 class="small font-weight-bold">(52%) Universitas Indonesia - Fisika <span
                        class="float-right">100%</span></h4>
                <div class="progress ">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="20"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-4 mt-2">Status : <span class="text-success">LULUS</span></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Hasil Try Out</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="w-50">Kategori</th>
                            <th>Benar</th>
                            <th>Salah</th>
                            <th>Kosong</th>
                            <th>Nilai</th>
                            <th>Pembahasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Penalaran Umum (PU)</td>
                            <td>8</td>
                            <td>2</td>
                            <td>0</td>
                            <td>30</td>
                            <td><a href="#" class="btn btn-primary">Lihat</a></td>
                        </tr>
                        <tr>
                            <td>Pemahaman Membaca dan Menulis (PMM)</td>
                            <td>8</td>
                            <td>2</td>
                            <td>0</td>
                            <td>30</td>
                            <td><a href="#" class="btn btn-primary">Lihat</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-8">
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
    <div class="col-xl-4 col-lg-4">
        <div class="card shadow mb-4 text-center">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Komentar Mentor</h6>
            </div>
            <div class="card-body">
                <img class="my-3" src="{{asset('assets/img/undraw_profile.svg')}}" alt="profil-mentor"
                style="height:100px">
                <div class="form-group">
                    <textarea class="form-control mt-4" id="komentarMentor" rows="5" disabled>Bagus Pertahankan</textarea>
                </div>
                @hasanyrole('mentor')
                <button class="btn btn-langkah btn-block" type="submit">Kirim Komentar</button>
                @endhasanyrole
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Persaingan Nilai Batch - 1</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myPersaingan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<!-- Page level plugins -->
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('assets/js/hasil-riwayat-nilai.js') }}"></script>
<script src="{{ asset('assets/js/hasil-persaingan-nilai.js') }}"></script>
{{-- <script src="{{ asset('assets/js/hasil-pg-prodi1.js') }}"></script>
<script src="{{ asset('assets/js/hasil-pg-prodi2.js') }}"></script> --}}

<script>
    $("#prodi-1").select2();
    $("#prodi-2").select2();

</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endsection
