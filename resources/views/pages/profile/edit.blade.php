@extends('layouts.dashboard-app')

@section('content')
{{-- <h1 class="h3 mb-2 text-gray-800">Profil</h1> --}}

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Edit Profil
    </div>
    <div class="card-body">
        <form action="{{ route('profile.update', $user->id) }}" id="form" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row justify-content-center">
                <div class="col-xl-12">
                        <div class="img-hover">
                            @if ($user->foto)
                            <img id="img-profile" class="img-fluid img-cover"  src="{{ asset('upload/users/'.$user->foto) }}" alt="{{ $user->name }}" class="img-fluid w-100">
                            @else
                            <img id="img-profile" class="img-fluid" width="100px" src="{{ asset("assets/img/undraw_profile.svg") }}"
                                alt="foto-{{ $user->name }}">
                            @endif
                            <div class="profile-overlay">
                                <div class="text"><a id="btn-img-profile" href="#"><i class="fa fa-edit"></i> Edit Foto</a></div>
                            </div>
                        </div>
                </div>
                <div class="col-xl-12 text-center">
                    <small class="mt-2">Ubah Foto Profil (Max. 2MB)</small>
                    @error('foto')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ $user->name }}" placeholder="Nama Lengkap">
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
                            value="{{ $user->email }}" placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- Data Tabel Siswa --}}
                @role('siswa')
                <div class="col-xl-6">
                    <div class="form-group only-number">
                        <label for="">NISN</label>
                        <input type="text" name="nisn" minlength="10" maxlength="11" class="number form-control @error('nisn') is-invalid @enderror"
                            value="{{ $user->siswa->nisn }}" placeholder="NISN">
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
                        <input type="text" name="asal_sekolah"
                            class="form-control @error('asal_sekolah') is-invalid @enderror"
                            value="{{ $user->siswa->asal_sekolah }}" placeholder="Asal Sekolah">
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
                        <input type="text" name="tanggal_lahir"
                            class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ date('d/m/Y', strtotime($user->siswa->tanggal_lahir)) }}"
                            placeholder="Tanggal Lahir">
                        @error('nisn')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group only-number">
                        <label for="">Nomor HP</label>
                        <input type="text" name="nomor_hp" minlength="10" maxlength="13" 
                            class="form-control number @error('nomor_hp') is-invalid @enderror"
                            value="{{ $user->siswa->nomor_hp }}" placeholder="Nomor HP">
                        @error('nomor_hp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endrole
                @role('sekolah')
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            value="{{ $user->sekolah->alamat }}" placeholder="Alamat Sekolah">
                        @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Kode Referal</label>
                        <input type="text" name="kode_referal"
                            class="form-control @error('kode_referal') is-invalid @enderror"
                            value="{{ $user->sekolah->kode_referal }}" placeholder="Kode Referal Sekolah">
                        @error('kode_referal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endrole
                @role('mentor')
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir"
                            class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                            value="{{ $user->mentor->pendidikan_terakhir }}" placeholder="Pendidikan Terakhir">
                        @error('pendidikan_terakhir')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endrole
                @role('author')
                {{-- <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Deskripsi</label>
                  <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ $user->author->deskripsi }}</textarea>
                @error('deskripsi')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
    </div> --}}
    @endrole
    {{-- End Data Tabel Siswa --}}
    <div class="col-xl-6">
        <div class="form-group">
            <label for="">Password Lama <small>(Kosongkan jika tidak mengganti password)</small></label>
            <div class="input-group" id="show_old_password">
                <input name="password_old" id="password_old"  type="password" class="form-control @error('password_old') is-invalid @enderror"
                placeholder="Password Lama" autocomplete="new-password">
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
            <label for="">Password Baru <small>(Kosongkan jika tidak mengganti password)</small></label>
            <div class="input-group" id="show_new_password">
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Password Baru"> 
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
            <label for="">Ulangi Password baru <small>(Kosongkan jika tidak mengganti password)</small></label>
            <div class="input-group" id="show_new_password">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control "
                placeholder="Ulangi Password Baru"> 
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="form-group">
            <input type="file" class="form-control @error('foto') is-invalid @enderror"
            name="foto" accept="image/x-png,image/gif,image/jpeg" id="myImgProfile" style="display: none;">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="float-right">
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
            <button id="btn-submit" type="submit" class="btn btn-success">Simpan</button>
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
    $("#form").on('submit', function (e) {
        if($("#password_old").val() != '') {
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
        }
        return
        e.preventDefault()
    })

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
<script>
    $('#btn-img-profile').click(function(){
        $('#myImgProfile').click()
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
            $('#img-profile').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#myImgProfile").change(function() {
        if(this.files[0].size > 2097152){
            alert("Maaf Foto Kamu Terlalu Besar");
            $("#myImgProfile").val('');
        }else{
            readURL(this);
        }
    });
</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
<style>
    .profile-overlay{
        width: 150px;
        height: 150px;  
        border-radius: 100px;
        position: absolute;
        opacity: 0.6;
        transition: .5s ease;
        background-color: #000000a2;
        top: 0;
    }

    .img-hover:hover .profile-overlay{
        opacity: 1;
    }

    .text a{
        color: white;
        font-size: 14px;
        text-decoration: none;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .img-hover{
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endsection
