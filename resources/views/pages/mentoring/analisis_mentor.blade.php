@extends('layouts.dashboard-app')
@section('title', 'Hasil & Analisis')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Hasil & Analisis</h1>


<div class="row">
    <div class="{{ (request()->get('prodi-1') || request()->get('prodi-2')) ? 'col-xl-6' : 'col-xl-12' }}">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Try Out - {{ $tryout->paket->nama }}</h6>
            </div>
            <div class="card-body">
                <table>
                    <tr>
                        <td class="font-weight-bold w-50">
                            Tanggal
                        </td>
                        <td>:</td>
                        <td>
                            {{ Carbon\Carbon::parse($tryout->created_at)->format('d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">
                            Jam
                        </td>
                        <td>:</td>
                        <td>
                            {{ Carbon\Carbon::parse($tryout->created_at)->format('H:i') }} WIB
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold w-50">
                            Kelompok
                        </td>
                        <td>:</td>
                        <td>
                            {{ Str::upper($kelompok->nama) }}
                        </td>
                    </tr>
                </table>

                <form action="#" class="mt-4">
                    <input type="hidden" name="kelompok" value="{{ request()->get('kelompok') }}">
                    <label for="kelompok">Pilihan Kelompok</label><br>
                    <select disabled name="kelompok" id="kelompok" class="form-control" required autocomplete="off">
                        @foreach ($kelompok_all as $value)
                            @if ($value->id == request()->get('kelompok'))
                            <option value="{{ $value->id }}" selected>{{ strtoupper($value->nama) }}</option>
                            @else
                            <option value="{{ $value->id }}">{{ strtoupper($value->nama) }}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="univ-1">Pilihan Universitas 1</label><br>
                            <select name="univ-1" id="univ-1" class="form-control" required autocomplete="off">
                                <option value="" selected disabled>== Universitas Pilihan 1 ==</option>
                                @foreach ($universitas as $value)
                                    @if (request()->get('univ-1'))
                                        @if ($value->id == request()->get('univ-1'))
                                            <option value="{{ $value->id }}" selected>{{ $value->nama }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                        @endif
                                    @else
                                    <option value="{{ $value->id }}" {{ ($value->id == App\Models\PassingGrade::find(request()->get('prodi-1'))->universitas->id) ? 'selected' : '' }}>{{ $value->nama }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <label for="prodi-1">Prodi 1</label>
                            <select name="prodi-1" id="prodi-1" class="form-control select-prodi" required>
                                @if (request()->get('prodi-1'))
                                <option value="{{ request()->get('prodi-1') }}" selected>{{ App\Models\PassingGrade::find(request()->get('prodi-1'))->prodi }}</option>    
                                @else
                                <option value="" selected disabled>== Program Studi Pilihan 1 ==</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="univ-2">Pilihan Universitas 2</label><br>
                            <select name="univ-2" id="univ-2" class="form-control" required autocomplete="off">
                                <option value="" selected disabled>== Universitas Pilihan 2 ==</option>
                                @foreach ($universitas as $value)
                                    @if (request()->get('univ-2'))
                                        @if ($value->id == request()->get('univ-2'))
                                            <option value="{{ $value->id }}" selected>{{ $value->nama }}</option>
                                        @else
                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                        @endif
                                    @else
                                    <option value="{{ $value->id }}" {{ ($value->id == App\Models\PassingGrade::find(request()->get('prodi-2'))->universitas->id) ? 'selected' : '' }}>{{ $value->nama }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <label for="prodi-2">Prodi 2</label>
                            <select name="prodi-2" id="prodi-2" class="form-control select-prodi" required>
                                @if (request()->get('prodi-2'))
                                <option value="{{ request()->get('prodi-2') }}" selected>{{ App\Models\PassingGrade::find(request()->get('prodi-2'))->prodi }}</option>    
                                @else
                                <option value="" selected disabled>== Program Studi Pilihan 2 ==</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-langkah btn-block mt-4">Ubah Pilihan</button>
                </form>
            </div>
        </div>
    </div>
    @if(request()->get('prodi-1') || request()->get('prodi-2'))
    <div class="col-xl-6">
        <div class="card shadow mb-4" height="100%">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Presentase Nilai</h6>
            </div>
            <div class="card-body">               

                <h4 class="small font-weight-bold">({{ trim($pg1->passing_grade) }}%) {{ $pg1->universitas->nama }} -
                    {{ $pg1->prodi }} <span class="float-right">Nilai : {{ $nilai_user }}%</span></h4>

                    @php
                    $prodi1=($nilai_user/((double)trim($pg1->passing_grade)))*100;
                    if ($prodi1 > 100) {
                        $prodi1 = 100;
                    }
                    @endphp
                    <div class="barwrapp">
                        <div class="progress">
                          <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{ $nilai_user }}%">
                          </div>
                        </div>
                        <div style="width: 3px; height: 100%; position: absolute; background: black; top: 0; left: {{ $pg1->passing_grade}}%;" title="{{$pg1->universitas->nama}}"></div>
                      </div>

                    @if ((double)trim($pg1->passing_grade) < $nilai_user) <p class="mb-4 mt-2">Status : <span
                        class="text-success">LULUS</span></p>
                    @else
                    <p class="mb-4 mt-2">Status : <span class="text-danger">BELUM LULUS</span></p>
                    @endif

                    <h4 class="small font-weight-bold">({{ (double)trim($pg2->passing_grade) }}%) {{ $pg2->universitas->nama }} -
                        {{ $pg2->prodi }}<span class="float-right">Nilai : {{ $nilai_user }}%</span></h4>
                    @php
                    $prodi2=($nilai_user/((double)trim($pg2->passing_grade)))*100;
                    if ($prodi2 > 100) {
                         $prodi2 = 100;
                    }
                    @endphp
                    <div class="barwrapp">
                        <div class="progress">
                          <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{ $nilai_user }}%">
                          </div>
                        </div>
                        <div style="width: 3px; height: 100%; position: absolute; background: black; top: 0; left: {{ $pg2->passing_grade}}%;" title="{{$pg2->universitas->nama}}"></div>
                      </div>

                    @if ($pg2->passing_grade < $nilai_user) <p class="mb-4 mt-2">Status : <span
                            class="text-success">LULUS</span></p>
                        @else
                        <p class="mb-4 mt-2">Status : <span class="text-danger">BELUM LULUS</span></p>
                        @endif
            </div>
        </div>
    </div>
    @endif

</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Hasil Try Out</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="w-50">Kategori</th>
                                <th>Benar</th>
                                <th>Salah</th>
                                <th>Kosong</th>
                                <th>Nilai</th>
                                {{-- <th>Pembahasan</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalBenar = 0;    
                                $totalSalah = 0;    
                                $totalKosong = 0;    
                                $totalNilai = 0;    
                            @endphp
                            @forelse ($tryout_kategori_soal as $value)
                            @if (in_array($value->id, $hasil_to_kategori_id))
                                @php
                                    $to_detail = App\Models\TryoutHasilDetail::where('tryout_hasil_id', $tryout->id)
                                                                ->where('tryout_kategori_soal_id', $value->id)
                                                                ->first();
                                @endphp
                                <tr>
                                    <td>{{ $to_detail->kategori_soal->nama }}({{ $to_detail->kategori_soal->kode }})</td>
                                    <td>{{ $to_detail->benar }}</td>
                                    <td>{{ $to_detail->salah }}</td>
                                    <td>{{ $to_detail->kosong }}</td>
                                    <td>{{ $to_detail->nilai }}</td>
                                </tr>
                                @php
                                    $totalBenar += $to_detail->benar;
                                    $totalSalah += $to_detail->salah;
                                    $totalKosong += $to_detail->kosong;
                                    $totalNilai += $to_detail->nilai;
                                @endphp
                            @else
                                @php
                                    $to_detail = App\Models\TryoutKategoriSoal::find($value)->first();
                                    $total_soal_kategori = App\Models\TryoutSoal::where('tryout_paket_id', $paket->id)
                                                                ->where('tryout_kategori_soal_id', $value->id)
                                                                ->count();
                                @endphp
                                <tr>
                                    <td>{{ $to_detail->nama }}({{ $to_detail->kode }})</td>
                                    <td>{{ 0 }}</td>
                                    <td>{{ 0 }}</td>
                                    <td>{{ $total_soal_kategori }}</td>
                                    <td>{{ 0 }}</td>
                                </tr>
                                @php
                                    $totalBenar += 0;
                                    $totalSalah += 0;
                                    $totalKosong += $total_soal_kategori;
                                    $totalNilai += 0;
                                @endphp
                            @endif
                            @empty
                            <tr>
                                <td colspan="6">Tidak ada data</td>
                            </tr>
                            @endforelse
                            <tr>
                                <td class="font-weight-bold">
                                    Total
                                </td>
                                <td class="font-weight-bold">
                                    {{$totalBenar}}
                                    {{-- TOTAL BENAR --}}
                                </td>
                                <td  class="font-weight-bold">
                                    {{$totalSalah}}
                                    {{-- TOTAL SALAH --}}
                                </td>
                                <td class="font-weight-bold">
                                    {{$totalKosong}}
                                    {{-- TOTAL KOSONG --}}
                                </td>
                                <td class="font-weight-bold">
                                    {{$totalNilai}}
                                    {{-- TOTAL NILAI --}}
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Area Chart -->
    @php
        $hasMentor = $user_siswa->siswa->mentor;
    @endphp
    {{-- <div class="{{ ($hasMentor != '') ? 'col-xl-6 col-lg-6' : 'col-xl-12 col-lg-12' }}"> --}}
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
    @if (count($hasMentor) > 0 && $gelombang->jenis == 2)
    <div class="col-xl-4 col-lg-4">
        <div class="card shadow mb-4 text-center">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Komentar Mentor</h6>
            </div>
            <div class="card-body">
                {{-- IF SISWA (SEKOLAH) --}}
                <form action="{{ route('mentoring.komentar', $tryout->id) }}" method="post">
                    @csrf
                    {{-- @if (auth()->user()->foto)
                    @php $foto = auth()->user()->foto; @endphp
                    <img class="my-3 img-cover" src="{{asset("upload/users/$foto")}}" alt="profil-mentor"
                    style="height:110px; width:110px; border-radius:120px">
                    @else
                    <img class="my-3" src="{{asset('assets/img/undraw_profile.svg')}}" alt="profil-mentor"
                    style="height:110px">
                    @endif --}}
                    {{-- <img class="my-3" src="{{asset('assets/img/undraw_profile.svg')}}" alt="profil-mentor"
                    style="height:100px"> --}}
                    <img id="img-profile" class="img-cover rounded-circle" src="{{ ($user_siswa->foto) ? asset("upload/users/". $user_siswa->foto) : asset('assets/img/default_avatar.svg') }}" style="height:110px; width:110px; border-radius:120px">
                    
                    <div class="form-group">
                        <textarea class="form-control mt-4" name="komentar" id="komentarMentor" rows="5" placeholder="Komentar Mentor">{{ $komentar->komentar ?? '' }}</textarea>
                    </div>
                    @hasanyrole('mentor')
                    <button class="btn btn-langkah btn-block" type="submit">Kirim Komentar</button>
                    @endhasanyrole
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="col-xl-4 col-lg-4">
        <div class="card shadow mb-4 text-center">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Interpretasi Hasil</h6>
            </div>
            <div class="card-body">
                {{-- IF SISWA UMUM (INTERPRETASI) --}}

                @php
                $prodi1=100;
                $prodi2=100;
                    $interpretasi = "-";
                    if ($prodi1 < 100 && $prodi2 < 100) {
                        $interpretasi = $paket->interpretasi_3;
                    }elseif($prodi1 < 100 || $prodi2 < 100){
                        $interpretasi = $paket->interpretasi_2;
                    }elseif($prodi1 == 100 && $prodi2 == 100){
                        $interpretasi = $paket->interpretasi_1;
                    }
                @endphp
                <p>{{ $interpretasi }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Persaingan Nilai - {{ $tryout->paket->nama }}
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
<script src="{{ asset('assets/vendor/chart.js/annotation.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>

<!-- Page level custom scripts -->
{{-- <script src="{{ asset('assets/js/hasil-riwayat-nilai.js') }}"></script>
<script src="{{ asset('assets/js/hasil-persaingan-nilai.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/hasil-pg-prodi1.js') }}"></script>
<script src="{{ asset('assets/js/hasil-pg-prodi2.js') }}"></script> --}}

<script>
    const URL_GET = `{{ url('api/v1/get-prodi') }}`
    $(document).ready(function() {
        $("#univ-1").select2();
        $("#univ-2").select2();
        $("#prodi-1").select2();
        $("#prodi-2").select2();
    })

    $('#kelompok').on('change', function() {
        $("#prodi-1").empty()
        $("#prodi-2").empty()
        $("#univ-1").val('').trigger("change")
        $("#univ-2").val('').trigger("change")
    })

    let kelompok = $('#kelompok').val()
    // kelompok-2 univ-2 prodi-2
    $('#univ-1').on('change', function() {
        kelompok = $('#kelompok').val()
        let univ1 = $('#univ-1').val()
        new Promise((resolve, reject) => {
            $.ajax({
                url: `${URL_GET}/${kelompok}/${univ1}`,
                method: 'GET',
                dataType: 'JSON'
            })
            .done(res => {
                console.log(res)
                let data = res.data
                $('#prodi-1').empty()
                data.forEach(element => {
                    $('#prodi-1').append(`<option value="${element.id}">${element.prodi}</option>`)
                })
                $('#prodi-1').removeAttr('disabled')
            })
            .fail(err => {
                console.log(err)
            })
        })
    })

    $('#univ-2').on('change', function() {
        kelompok = $('#kelompok').val()
        let univ2 = $('#univ-2').val()
        new Promise((resolve, reject) => {
            $.ajax({
                url: `${URL_GET}/${kelompok}/${univ2}`,
                method: 'GET',
                dataType: 'JSON'
            })
            .done(res => {
                console.log(res)
                let data = res.data
                $('#prodi-2').empty()
                data.forEach(element => {
                    $('#prodi-2').append(`<option value="${element.id}">${element.prodi}</option>`)
                })
                $('#prodi-2').removeAttr('disabled')
            })
            .fail(err => {
                console.log(err)
            })
        })
    })

    // Grafik Riwayat Nilai
    let ctx = document.getElementById("myRiwayatNilai")
    let data_riwayat = {
        labels: {!! json_encode($nama_paket) !!},
        datasets: [{
            label: "Presentase Nilai ({{ Str::upper($kelompok->nama) }})",
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
            data: {!!json_encode($nilai_grafik) !!},
        }],
    }
    new Chart(ctx, {
        type: 'line',
        data: data_riwayat,
        options: barOptions
    })

    // Grafik Persaingan
    let ctx2 = document.getElementById("myPersaingan");
    let data_saingan = {
        labels: {!!json_encode($nilai_saingan) !!},
        datasets: [{
            label: "Nilai",
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: {!! json_encode($nilai_saingan) !!},
        }],
    }
    new Chart(ctx2, {
        type: 'bar',
        data: data_saingan,
        options: barOption2
    })

</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
<style>
.progress {
  width: 100%;
}
.barwrapp {
  position: relative;
}
</style>
@endsection
