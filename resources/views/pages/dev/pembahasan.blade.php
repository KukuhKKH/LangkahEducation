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
                        <ul class="navbar-nav ml-auto">
                            Waktu Tersisa :
                            <span>
                                45:29
                            </span>
                        </ul>
                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav">
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Ammar Muhammad</span>
                                    <img class="img-profile rounded-circle" src="{{ (auth()->user()->foto) ? asset("upload/user/". auth()->user()->foto) : asset('assets/img/undraw_profile.svg') }}">
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
                        <div class="card p-3">
                            <div class="card-body">
                                <h4>
                                    <span class="badge badge-dark mt-2 p-2">Soal :
                                        <span id="posisi-soal">0/0</span>
                                    </span>
                                </h4>
                                <div class="row">                                
                                    <div class="col-9">
                                        <div id="question0" class="show">                                       
                                            <h3 id="pertanyaan" class="h4 mt-3 mb-2 text-gray-800 font-weight-bold">
                                                SOAL NOMOR 1 (A = BENAR)
                                            </h3>    
                                            <ol type="A">
                                                <li>
                                                    <input class="mt-4 mr-1" type="radio" name="jawaban0" value="A"><span id="option1">Jawaban</span>
                                                </li>
                                                <li>
                                                    <input class="mt-4 mr-1" type="radio" name="jawaban0" value="B"><span id="option2">Jawaban</span>
                                                </li>
                                                <li>
                                                    <input class="mt-4 mr-1" type="radio" name="jawaban0" value="C"><span id="option3">Jawaban</span>
                                                </li>
                                                <li>
                                                    <input class="mt-4 mr-1" type="radio" name="jawaban0" value="D"><span id="option4">Jawaban</span>
                                                </li>
                                                <li>
                                                    <input class="mt-4 mr-1" type="radio" name="jawaban0" value="E"><span id="option5">Jawaban</span>
                                                </li>
                                            </ol>

                                            <div class="mt-4 bg-light p-4" id="pembahasan" >
                                                <h6 class="font-weight-bold">Pembahasan :</h6>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim et quasi doloremque magni incidunt. Molestias quam, ipsam neque provident voluptas animi, quibusdam odit, consequatur exercitationem voluptates fugit illo ea dolorum.
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-3" id="menu-soal">
                                        <h5 class="h5 mt-3 mb-2 font-weight-bold">Daftar Soal</h5>
                                        <div class="row" id="daftar-soal">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button id="btn-kembali" class="btn btn-dark">Kembali</button>
                                        
                                        <button id="btn-lanjut" class="btn btn-success">Lanjut</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <button id="btn-kumpulkan" type="submit" class="btn btn-danger" disabled>Kumpulkan</button>
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