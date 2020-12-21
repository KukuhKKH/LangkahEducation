@extends('layouts.dashboard-app')
@section('title', 'Edit '.$user->user->name)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Update Siswa</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Siswa - {{ $user->user->name }}</h6>
      </div>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-xl-12 text-center mb-3">
            @if ($user->user->foto)
            @else
             <img class="img-fluid" width="100px" src="{{ asset("assets/img/undraw_profile.svg") }}"
                 alt="foto-{{ $user->user->namee }}">
             @endif
         </div>
     </div>
     
      <form action="{{ route('siswa.update', $user->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <input type="hidden" name="user_id" value="{{ $user->user->id }}">
         <div class="row">
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Nama / Username</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->user->name }}" placeholder="Nama / username">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->user->email }}" placeholder="Email">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            {{-- Data Tabel Siswa --}}
            <div class="col-xl-6">
               <div class="form-group only-number">
                  <label for="">NISN</label>
                  <input type="text" minlength="10" maxlength="11" name="nisn" class="form-control number @error('nisn') is-invalid @enderror" value="{{ $user->nisn }}" placeholder="NISN">
                  @error('nisn')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Asal Sekolah</label>
                  <input type="text" name="asal_sekolah" class="form-control @error('asal_sekolah') is-invalid @enderror" value="{{ $user->asal_sekolah }}" placeholder="Asal Sekolah">
                  @error('asal_sekolah')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Tanggal Lahir</label>
                  <input type="text" name="tanggal_lahir" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" value="{{ $user->tanggal_lahir }}" placeholder="Tanggal Lahir">
                  @error('nisn')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group oly-number">
                  <label for="">Nomer HP</label>
                  <input type="text" minlength="10" maxlength="13" name="nomor_hp" class="form-control number @error('nomor_hp') is-invalid @enderror" value="{{ $user->nomor_hp }}" placeholder="Nomer HP">
                  @error('nomor_hp')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            {{-- End Data Tabel Siswa --}}
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Password Lama <small>Kosongkan jika tidak mengganti password</small></label>
                  <div class="input-group" id="show_old_password">
                     <input type="password" name="password_old" class="form-control @error('password_old') is-invalid @enderror" placeholder="Password Lama">
                     <div class="input-group-addon d-flex align-items-center">
                         <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                       </div>    
                 </div>
                  @error('password_old')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Password Baru <small>Kosongkan jika tidak mengganti password</small></label>
                  <div class="input-group" id="show_new_password">
                     <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Baru">

                 </div>
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Ulangi Password baru <small>Kosongkan jika tidak mengganti password</small></label>
                  <div class="input-group" id="show_new_password2">
                     <input type="password" name="password_confirmation" class="form-control " placeholder="Ulangi Password Baru">
                 </div>

               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Foto <small>Maksimal 2 Mb</small></label>
                  <div class="input-group mb-3">
                     <div class="custom-file">
                       <input type="file" class="form-control custom-file-input @error('foto') is-invalid @enderror" name="foto" accept="image/x-png,image/gif,image/jpeg" id="fotoUser">
                       <label class="custom-file-label" id="labelFoto" for="inputGroupFile02">Choose file</label>
                       @error('foto')
                       <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                       </span>
                       @enderror
                     </div>
                   </div>
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Status Aktif</label>
                  <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" autocomplete="off">
                     <option value="1" {{ ($user->user->is_active == 1) ? 'selected' : '' }}>Aktif</option>
                     <option value="0" {{ ($user->user->is_active == 0) ? 'selected' : '' }}>Tidak Aktif</option>
                  </select>
                  @error('is_active')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xl-6">

            </div>
            <div class="col-xl-6">
               <div class="float-right">
                  <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
                  <button type="submit" class="btn btn-success">Simpan</button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection

@section('js')
   <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
   <script>
      $.fn.datepicker.defaults.format = "dd/mm/yyyy"
      $('.datepicker').datepicker();
      $("#form").on('submit', function(e) {
      if($("#password_confirmation").val() != $("#password").val()) {
         swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Password konfirmasi tidak sama',
         })
         return false
      }
      if($("#password").val().length < 8) {
         swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Password minimal 8 karakter',
         })
         return false
      }
      return
      e.preventDefault()
   })
   </script>
   <script type="text/javascript">

      $('.custom-file input').change(function (e) {
          var files = [];
          for (var i = 0; i < $(this)[0].files.length; i++) {
              files.push($(this)[0].files[i].name);
          }
          $(this).next('.custom-file-label').html(files.join(', '));
      });
  
      $("#fotoUser").change(function() {
             if(this.files[0].size > 2097152){
                 alert("Maaf Foto Kamu Terlalu Besar");
                 $("#fotoUser").val('');
                 $("#labelFoto").text('Choose file');
             }
         });
  </script>
    <script>
      $(document).ready(function() {
      $("#show_old_password a").on('click', function(event) {
          event.preventDefault();
          if($('#show_old_password input').attr("type") == "text"){
              $('#show_old_password input').attr('type', 'password');
              $('#show_new_password input').attr('type', 'password');
              $('#show_new_password2 input').attr('type', 'password');
              $('#show_old_password i').addClass( "fa-eye-slash" );
              $('#show_old_password i').removeClass( "fa-eye" );
          }else if($('#show_old_password input').attr("type") == "password"){
              $('#show_old_password input').attr('type', 'text');
              $('#show_new_password input').attr('type', 'text');
              $('#show_new_password2 input').attr('type', 'text');
              $('#show_old_password i').removeClass( "fa-eye-slash" );
              $('#show_old_password i').addClass( "fa-eye" );
          }
      });
   });
   </script>
@endsection

@section('css')
   <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection