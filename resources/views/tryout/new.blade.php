@extends('layouts.tryout-app')

@section('content')
<!-- Page Wrapper -->
<div id="wrapper" class="full-height">

   <!-- Content Wrapper -->
   <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

         <!-- Topbar -->
         <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <ul class="navbar-nav mr-auto">
               <img class="w-50" src="{{ asset('assets/img/logo-primary.svg') }}" alt="">
            </ul>
            <ul class="navbar-nav ml-auto my-auto">
               <h6>
                  Waktu Tersisa :
                  <button class="btn btn-primary">
                     <span class="sisawaktu">
                     
                     </span>
                  </button>
               </h6>
            </ul>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav">
               <div class="topbar-divider d-none d-sm-block"></div>
               <!-- Nav Item - User Information -->
               <li class="nav-item dropdown no-arrow">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                     aria-haspopup="true" aria-expanded="false">
                     <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                     <img class="img-profile rounded-circle" src="{{ (auth()->user()->foto) ? asset("upload/users/". auth()->user()->foto) : asset('assets/img/default_avatar.svg') }}">
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
               <form action="{{ route('tryout.soal.store', ['gelombang_id' => $gelombang_id, 'paket' => $paket->slug]) }}" method="post" id="form-data">
               @csrf
                  <div class="card-body">
                     <h4 class="mb-2 font-weight-bold">
                        Soal :
                           <span id="posisi-soal">0/0</span>
                     </h4>
                     <div class="row">
                        <div class="col-9">

                           <?php $i = 1; ?>
                           <?php $k = 0; ?>
                           @foreach ($soal as $value)
                              <div id="question{{ $k }}" class="{{ $k == 0 ? 'show' : '' }} soal" data-jawaban="{{ $value->id }}" data-kategori="{{ $value->kategori_soal->nama }}" data-kode="{{ $value->kategori_soal->kode }}">
                                 <div class="badge badge-success"><h6 class="font-weight-bold">Kategori {{ $value->kategori_soal->nama }}</h6></div>
                                 <h3 id="pertanyaan" class="h4 mt-3 mb-2 text-gray-800 font-weight-bold">
                                    {{-- {{ $i }}.  --}}
                                    {!! $value->soal !!}
                                 </h3>
                                 <input type="hidden" name="soal[{{ $i }}]" value="{{ $value->id }}">
                                 <ol type="A">
                                    <?php $j = 1; ?>
                                    {{-- @foreach($value->jawaban()->inRandomOrder()->get() as $option) --}}
                                    @foreach($value->jawaban()->get() as $option)
                                       <li>
                                          <input class="mt-4 mr-1" type="radio" name="jawaban[{{ $value->id }}]" value="{{ $option->id }}" id="option{{ $i }}ke{{ $j }}">
                                          <label for="option{{ $i }}ke{{ $j }}">{!! $option->jawaban !!}</label>
                                       </li>
                                       <?php $j++; ?>
                                    @endforeach
                                 </ol>
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
                        <div class="col-6">
                           <button id="btn-kembali" type="button" class="btn btn-dark">Kembali</button>

                           <button id="btn-lanjut" type="button" class="btn btn-success">Lanjut</button>
                           <button id="btn-reset" type="button" class="btn btn-light text-danger">Reset</button>
                        </div>
                        <div class="col-6 text-right">
                           <button id="btn-kumpulkan" type="button" class="btn btn-danger" disabled>Kumpulkan</button>
                        </div>
                     </div>
                  </div>
               </form>
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
                    <button type="submit" class="btn btn-danger">Logout</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/vendor/moment.js') }}"></script>
<script>
   // window.onbeforeunload = function () {return false;}
   const total_soal = {{ count($soal) }}
   const paket_slug = `{{ $paket->slug }}`
   const user = `{{ auth()->user()->name }}`
   $(document).ready(function() {
      let waktu = localStorage.getItem(`waktu-${user}-${paket_slug}`)
      let compSiswaWaktu = document.querySelector('.sisawaktu')
      if(waktu != null) {
         compSiswaWaktu.setAttribute('data-time', waktu)
      } else {
         const waktu_sekarang = moment().add('{{ $waktu }}', 'minutes').format('YYYY-MM-D H:mm:ss')
         localStorage.setItem(`waktu-${user}-${paket_slug}`, waktu_sekarang)
         compSiswaWaktu.setAttribute('data-time', waktu_sekarang)
      }

      let t = $('.sisawaktu');
      if (t.length) {
         sisawaktu(t.data('time'))
      }

      $('#btn-reset').on('click', function() {
         let soal = $('.show')[0]
         let jwb = soal.dataset.jawaban
         let com_option = document.getElementsByName(`jawaban[${jwb}]`)
         for (let index = 0; index < com_option.length; index++) {
            com_option[index].checked = false;
         }
      })
   })

   function waktuHabis() {
      // selesai();
      swal.fire({
         icon: 'error',
         text: 'Waktu Ujian telah habis',
         type: 'warning'
      }).then(function (val) {
         if(val) {
            // window.location.reload()
            localStorage.removeItem(`waktu-${user}-${paket_slug}`)
            $('#form-data').submit()
         }
      })
   }

   $('#btn-kumpulkan').on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Sudah yakin ingin mengumpulkan jawaban!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Tidak',
         confirmButtonText: 'Ya!'
      }).then((result) => {
         if (result.isConfirmed) {
            localStorage.removeItem(`waktu-${user}-${paket_slug}`)
            $('#form-data').submit()
         }
      })
   })
   history.pushState(null, null, document.URL);
   window.addEventListener('popstate', function () {
      swal.fire({
         title: 'Maaf',
         text: "Kamu tidak bisa kembali ke kategori sebelumnya!",
         icon: 'warning',
      })
      history.pushState(null, null, document.URL);
   })
   (function (global) { 
      if(typeof (global) === "undefined") {
         throw new Error("window is undefined");
      }

      var _hash = "!";
      var noBackPlease = function () {
         global.location.href += "#";

         // making sure we have the fruit available for juice (^__^)
         global.setTimeout(function () {
            global.location.href += "!";
         }, 50);
      };

      global.onhashchange = function () {
         if (global.location.hash !== _hash) {
            global.location.hash = _hash;
         }
      };

      global.onload = function () {        
         swal.fire({
            title: 'Maaf',
            text: "Kamu tidak bisa kembali ke kategori sebelumnya!",
            icon: 'warning',
         })    
         noBackPlease();

         // disables backspace on page except on input fields and textarea..
         document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                  e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
         };          
      }

      })(window);
</script>
@endsection