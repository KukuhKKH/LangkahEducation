@extends('layouts.dashboard-app')
@section('title', 'Edit '.$superadmin->name)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Superadmin</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Superadmin - {{ $superadmin->name }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('admin.update', $superadmin->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label for="">Nama / Username</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $superadmin->name }}" placeholder="Nama / username">
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
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $superadmin->email }}" placeholder="Email">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
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
            <div class="col-6">
               <div class="form-group">
                  <label for="">Status Aktif</label>
                  <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" autocomplete="off">
                     <option value="1" {{ ($superadmin->is_active == 1) ? 'selected' : '' }}>Aktif</option>
                     <option value="0" {{ ($superadmin->is_active == 0) ? 'selected' : '' }}>Tidak Aktif</option>
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
            <div class="col-6">
               @if ($superadmin->foto)
                  <img src="{{ asset('upload/users/'.$superadmin->foto) }}" alt="{{ $superadmin->name }}" class="img-fluid w-100">
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
   <script>
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