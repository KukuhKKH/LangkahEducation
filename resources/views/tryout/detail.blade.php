@extends('layouts.tryout-app')
@section('title', 'Try Out - LangkahEdukasi')

@section('content')
<!-- Page Wrapper -->
<div id="wrapper" class="full-height">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4">

                <ul class="navbar-nav mr-auto">
                    <img class="w-50" src="{{ asset('assets/img/logo-primary.svg') }}" alt="">
                </ul>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav">
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                            <img class="img-profile rounded-circle"
                                src="{{ (auth()->user()->foto) ? asset("upload/users/". auth()->user()->foto) : asset('assets/img/undraw_profile.svg') }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item text" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow p-4">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <h4 class="font-weight-bold my-4">Try Out - {{ $paket->nama }}</h4>
                                <div class="table-responsive">
                                    <table class="table w-50">
                                        <thead>
                                            <tr>
                                                <td> Jenis Kategori </td>
                                                <td> Nama Kategori </td>
                                                <td> Jumlah Soal </td>
                                                <td> Waktu Pengerjaan </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($detail as $value)
                                                <tr class="jenis-{{ strtoupper($value->tipe) }}">
                                                    <td>
                                                        {{ strtoupper($value->tipe) }}
                                                    </td>
                                                    <td>
                                                        {{ $value->nama }}
                                                    </td>
                                                    <td>
                                                        {{ $value->total }}
                                                    </td>
                                                    <td>
                                                        {{ $value->waktu }} menit
                                                    </td>
                                                </tr>
                                           @endforeach
                                                <tr class="text-center warning-kelompok">
                                                    <td colspan="4" >Silahkan Pilih Kelompok Ujian</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <form class="w-50" action="{{ route('tryout.mulai', ['gelombang_id' => $gelombang_id, 'slug' => $paket->slug, 'token' => $user_token]) }}" class="mt-4" method="get">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                <label for="kelompok">Pilihan Kelompok</label><br>
                                                <select name="kelompok" id="kelompok" class="form-control" required>
                                                    <option value="" selected disabled>== Kelompok Pilihan ==</option>
                                                    @forelse ($kelompok as $value)
                                                        <option value="{{ $value->id }}">{{ strtoupper($value->nama) }}</option>
                                                    @empty
                                                        <option value="0" disabled selected>Tidak Ada Kelompok Ujian</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="univ-1">Pilihan Universitas 1</label><br>
                                                <select name="univ-1" id="univ-1" class="form-control" required>
                                                    <option value="" selected disabled>== Universitas Pilihan 1 ==</option>
                                                    @forelse ($universitas as $value)
                                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                                    @empty
                                                        <option value="0" disabled selected>Tidak Ada Universitas</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="prodi-1">Pilihan Prodi 1</label><br>
                                                <select name="prodi-1" id="prodi-1" class="form-control" required>
                                                    <option value="" selected disabled>== Program Studi Pilihan 1 ==</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="univ-2">Pilihan Universitas 2</label><br>
                                                <select name="univ-2" id="univ-2" class="form-control"required>
                                                    <option value="" selected disabled>== Universitas Pilihan 2 ==</option>
                                                    @forelse ($universitas as $value)
                                                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                                    @empty
                                                        <option value="0" disabled selected>Tidak Ada Universitas</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label for="prodi-2">Pilihan Prodi 2</label><br>
                                                <select name="prodi-2" id="prodi-2" class="form-control" required>
                                                    <option value="" selected disabled>== Program Studi Pilihan 2 ==</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="btn-lanjut"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Langkah Education 2020</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda benar-benar ingin keluar ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih ‘Logout’ apabila Anda ingin menyudahi sesi ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Logout</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Right Sidebar -->
@endsection

@section('js')
<!-- Page level plugins -->
<script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>

<!-- Page level custom scripts -->
{{-- <script src="{{ asset('assets/js/hasil-riwayat-nilai.js') }}"></script> 
<script src="{{ asset('assets/js/hasil-persaingan-nilai.js') }}"></script>
<script src="{{ asset('assets/js/hasil-pg-prodi1.js') }}"></script> 
<script src="{{ asset('assets/js/hasil-pg-prodi2.js') }}"></script> --}}
<script>
    const URL_GET = `{{ url('api/v1/get-prodi') }}`
    let lanjut_1 = false
    let lanjut_2 = false
    $("#univ-1").select2();
    $("#univ-2").select2();
    $("#prodi-1").select2();
    $("#prodi-2").select2();

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
        if($("#univ-1").val() != null){
            $("#prodi-1").prop("disabled", false);
       }else{
            $("#prodi-1").prop("disabled", true);
       }
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
                $('#prodi-1').append(`<option value="" selected disabled>== Program Studi Pilihan 1 ==</option>`)
                data.forEach(element => {
                    $('#prodi-1').append(`<option value="${element.id}">${element.prodi}</option>`)
                })
            })
            .fail(err => {
                console.log(err)
            })
        })
        $('#prodi-1').removeAttr('disabled')
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
                $('#prodi-2').append(`<option value="" selected disabled>== Program Studi Pilihan 2 ==</option>`)
                data.forEach(element => {
                    $('#prodi-2').append(`<option value="${element.id}">${element.prodi}</option>`)
                })
            })
            .fail(err => {
                console.log(err)
            })
        })
        $('#prodi-2').removeAttr('disabled')
    })

    $(document).ready(function() {
        if(typeof Storage !== "undefined") {
            lanjut_1 = true
        } else {
            swal.fire({
                title: 'Maaf',
                text: "Browser anda tidak mendukung Localstorage!",
                icon: 'warning',
            })
            lanjut_1 = false
        }

        if (navigator.cookieEnabled) {
            lanjut_2 = true
        } else {
            swal.fire({
                title: 'Maaf',
                text: "Nyalakan Cookie dibrowser anda!",
                icon: 'warning',
            })
            lanjut_2 = false
        }

        if(lanjut_1 || lanjut_2) {
            $('#btn-lanjut').html(`<button type="submit" class="btn btn-langkah btn-block mt-4">Kerjakan Sekarang</button>`)
        } else {
            $('#btn-lanjut').html(`<h4>Browser anda tidak mendukung untuk mengerjakan Tryout</h4>`)
        }
    })
</script>
<script>
    disableUniv()
    disableProdi()
    $("#kelompok").on('change', function() {
        $("#univ-1").val('')
        $("#univ-2").val('')
        $("#prodi-1").val('')
        $("#prodi-2").val('')
       if($("#kelompok").val() != null){
            $("#univ-1").prop("disabled", false);
            $("#univ-2").prop("disabled", false);
       }
       
       if($("#kelompok option:selected").text() == "SAINTEK"){
           $(".jenis-SOSHUM").hide()
           $(".warning-kelompok").hide()
           $(".jenis-SAINTEK").show()
       }else if($("#kelompok option:selected").text() == "SOSHUM"){
            $(".jenis-SAINTEK").hide()
           $(".warning-kelompok").hide()
            $(".jenis-SOSHUM").show()

       }else if($("#kelompok option:selected").text() == "CAMPURAN"){
            $(".jenis-SOSHUM").show()
            $(".jenis-SAINTEK").show()
            $(".jenis-SOSHUM").show()
       }
       resetSelect()
    });
    function resetSelect(){
        $("#univ-1").select2({
            placeholder: "== Universitas Pilihan 1 =="
        });
        $("#univ-2").select2({
            placeholder: "== Universitas Pilihan 2 =="
        });
        $("#prodi-1").select2({
            placeholder: "== Program Studi Pilihan 1 =="
        });
        $("#prodi-2").select2({
            placeholder: "== Program Studi Pilihan 2 =="
        });

        disableProdi()
    }
    function disableUniv(){
        $("#univ-1").prop("disabled", true);
        $("#univ-2").prop("disabled", true);
    }

    function disableProdi(){
        $("#prodi-1").prop("disabled", true);
        $("#prodi-2").prop("disabled", true);
    }

    // function checkProdi(){
    //     let prodi1Val =  $("#prodi-1").val()
    //     let prodi2Val =  $("#prodi-2").val()
    //     console.log("HELLO WORLD ". prodi1Val)
    //     if(prodi2Val == prodi1Val){
    //         $('#prodi-2 option[value="'.prodi1Val.'"]').prop("disabled", true)
    //     }
    // }
</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #4c4c4c !important;
    }
    .jenis-SAINTEK{
        display: none
    }
    .jenis-SOSHUM{
        display: none
    }
</style>
@endsection

