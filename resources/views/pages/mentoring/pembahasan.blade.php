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
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                     aria-haspopup="true" aria-expanded="false">
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
            <div class="card p-3">
               <div class="card-body">
                  <h4>
                     <span class="badge badge-dark mt-2 p-2">Soal :
                        <span id="posisi-soal">0/0</span>
                     </span>
                  </h4>
                  <div class="row">
                     <div class="col-9">
                        <?php $i = 1; ?>
                        <?php $k = 0; ?>
                        @foreach ($paket as $value)
                        <div id="question{{ $k }}" class="{{ $k == 0 ? 'show' : '' }} soal"
                           data-kategori="{{ $value->kategori_soal->nama }}"
                           data-kode="{{ $value->kategori_soal->kode }}">
                           <h3 id="pertanyaan" class="h4 mt-3 mb-2 text-gray-800 font-weight-bold">
                              {!! $value->soal !!}
                           </h3>
                           <input type="hidden" name="soal[{{ $i }}]" value="{{ $value->id }}">
                                 <ol type="A">
                                    <?php $j = 1; ?>
                                    @foreach($value->jawaban as $option)
                                       <li>
                                          <input class="mt-4 mr-1" type="radio" name="jawaban[{{ $value->id }}]" value="{{ $option->id }}" id="option{{ $i }}ke{{ $j }}" {{ $option->benar ? 'checked': '' }}>
                                          <label for="option{{ $i }}ke{{ $j }}">{!! $option->jawaban !!}</label>
                                          @if ($option->benar)
                                             <i class="fa fa-check text-success"></i>
                                          {{-- @else
                                             <i class="fa fa-times text-danger"></i> --}}
                                          @endif
                                          @if (in_array($option->id, $jawabanmu))
                                             <span class="badge badge-primary">ini jawabanmu</span>
                                          @endif
                                          {{-- {{ dd($value->hasil) }}
                                          @if ($value->hasil->tryout_hasil_jawaban->tryout_jawaban_id == $option->id)
                                          <span class="badge badge-danger">Ini jawaban kamu</span>
                                          @endif --}}
                                       </li>
                                       <?php $j++; ?>
                                    @endforeach
                                 </ol>

                           <div class="mt-4 bg-light p-4" id="pembahasan">
                              <h6 class="font-weight-bold">Pembahasan :</h6>
                              {!! $value->pembahasan !!}
                           </div>
                        </div>
                        <?php $i++; ?>
                        <?php $k++; ?>
                        @endforeach
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
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Kembali</a>
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
<script>
   const total_soal = {{ count($paket) }}
</script>
@endsection