@extends('layouts.dashboard-app')
@section('title', 'Edit '.$mentor->user->name)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Update Mentor</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Mentor - {{ $mentor->user->name }}</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12 text-center mb-3">
               @if ($mentor->user->foto)
                  <img id="img-profile" class="img-fluid img-cover" src="{{ asset('upload/users/'.$mentor->user->foto) }}" alt="{{ $mentor->user->name }}" class="img-fluid w-100">
               @else
                <img class="img-fluid" width="100px" src="{{ asset("assets/img/undraw_profile.svg") }}"
                    alt="foto-{{ $mentor->user->namee }}">
                @endif
            </div>
        </div>
        <form action="{{ route('mentor.update', $mentor->id) }}" id="form" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <input type="hidden" name="user_id" value="{{ $mentor->user->id }}">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ $mentor->user->name }}" placeholder="Nama / username">
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
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ $mentor->user->email }}" placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- Data Tabel Sekolah --}}
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir"
                            class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                            value="{{ $mentor->pendidikan_terakhir }}" placeholder="Pendidikan Terakhir">
                        @error('pendidikan_terakhir')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- End Data Tabel Sekolah --}}
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Password Lama <small>Kosongkan jika tidak mengganti password</small></label>

                            <div class="input-group" id="show_old_password">
                                <input type="password" name="password_old"
                                class="form-control @error('password_old') is-invalid @enderror"
                                placeholder="Password Lama">
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
                            <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password Baru">  
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
                        <label for="">Ulangi Password baru
                            <small>Kosongkan jika tidak mengganti password</small>
                        </label>
                        <div class="input-group" id="show_new_password">
                            <input type="password" name="password_confirmation" class="form-control "
                            placeholder="Ulangi Password Baru">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Foto <small>Maksimal 2 Mb</small></label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file"
                                    class="custom-file-input form-control @error('foto') is-invalid @enderror"
                                    name="foto" accept="image/x-png,image/gif,image/jpeg" id="fotoUser">
                                <label id="labelFoto" class="custom-file-label" for="inputGroupFile02">Choose file</label>
                            </div>
                            @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Status Aktif</label>
                        <select name="is_active" class="form-control @error('is_active') is-invalid @enderror"
                            autocomplete="off">
                            <option value="1" {{ ($mentor->user->is_active == 1) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ ($mentor->user->is_active == 0) ? 'selected' : '' }}>Tidak Aktif
                            </option>
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
<script>
    $("#form").on('submit', function (e) {
        if ($("#password_confirmation").val() != $("#password").val()) {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password konfirmasi tidak sama',
            })
            return false
        }
        if ($("#password").val().length < 8) {
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
