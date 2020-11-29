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
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow sticky-topbar">

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
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Ammar Muhammad</span>
                            <img class="img-profile rounded-circle"
                                src="{{ (auth()->user()->foto) ? asset("upload/user/". auth()->user()->foto) : asset('assets/img/undraw_profile.svg') }}">
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
                                <h4 class="font-weight-bold my-4">Try Out - Batch 1</h4>
                                <table class="table w-50">
                                    <thead>
                                        <tr>
                                            <td>
                                                Nama Kategori
                                            </td>
                                            <td>
                                                Jumlah Soal
                                            </td>
                                            <td>
                                                Waktu Pengerjaan
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Pemahaman Umum
                                            </td>
                                            <td>
                                                15
                                            </td>
                                            <td>
                                                20 menit
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Pengetahuan Membaca
                                            </td>
                                            <td>
                                                10
                                            </td>
                                            <td>
                                                20 menit
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Bahasa Inggris
                                            </td>
                                            <td>
                                                10
                                            </td>
                                            <td>
                                                20 menit
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <form action="#" class="mt-4">
                                    <div class="form-group">
                                        <label for="prodi-1">Pilihan Prodi 1</label><br>
                                        <select name="prodi-1" id="prodi-1" class="form-control" required>
                                            <option value="" selected disabled>== Program Studi Pilihan 1 ==</option>
                                             
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="prodi-2">Pilihan Prodi 2</label><br>
                                        <select name="prodi-2" id="prodi-2" class="form-control" required>
                                            <option value="" selected disabled>== Program Studi Pilihan 1 ==</option>
                                            
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-langkah btn-block mt-4">Kerjakan
                                        Sekarang</button>
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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
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
<script src="{{ asset('assets/js/hasil-persaingan-nilai.js') }}"></script> --}}
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

