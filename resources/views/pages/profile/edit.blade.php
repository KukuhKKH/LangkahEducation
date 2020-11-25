@extends('layouts.dashboard-app')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Profile</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">{{ $user->name }}</h6>
         <div class="float-right">
            <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
         </div>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('profile.update', $user->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label for="">Nama / Username</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" placeholder="Nama / username">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" placeholder="Email">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            {{-- Data Tabel Siswa --}}
            <div class="col-6">
               <div class="form-group">
                  <label for="">NISN</label>
                  <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ $user->siswa->nisn }}" placeholder="NISN">
                  @error('nisn')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Asal Sekolah</label>
                  <input type="text" name="asal_sekolah" class="form-control @error('asal_sekolah') is-invalid @enderror" value="{{ $user->siswa->asal_sekolah }}" placeholder="Asal Sekolah">
                  @error('asal_sekolah')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Tanggal Lahir</label>
                  <input type="text" name="tanggal_lahir" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" value="{{ $user->siswa->tanggal_lahir }}" placeholder="Tanggal Lahir">
                  @error('nisn')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Nomer HP</label>
                  <input type="number" name="nomor_hp" class="form-control @error('nomor_hp') is-invalid @enderror" value="{{ $user->siswa->nomor_hp }}" placeholder="Nomer HP">
                  @error('nomor_hp')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            {{-- End Data Tabel Siswa --}}
            <div class="col-12">
               <div class="form-group">
                  <label for="">Password Lama <small>Kosongkan jika tidak mengganti password</small></label>
                  <input type="password" name="password_old" class="form-control @error('password_old') is-invalid @enderror" placeholder="Password Lama">
                  @error('password_old')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Password Baru <small>Kosongkan jika tidak mengganti password</small></label>
                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Baru">
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Ulangi Password baru <small>Kosongkan jika tidak mengganti password</small></label>
                  <input type="password" name="password_confirmation" class="form-control " placeholder="Ulangi Password Baru">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Foto <small>Maksimal 2 Mb</small></label>
                  <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" accept="image/x-png,image/gif,image/jpeg">
                  @error('foto')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
               @if ($user->foto)
                  <img src="{{ asset('upload/users/'.$user->foto) }}" alt="{{ $user->name }}" class="img-fluid w-100">
               @endif
            </div>
            <div class="col-6">
               <div class="float-right">
                  <button type="submit" class="btn btn-success">Edit</button>
                  <a href="{{ url()->previous() }}" class="btn btn-warning text-dark ml-1">Kembali</a>
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
@endsection

@section('css')
   <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection