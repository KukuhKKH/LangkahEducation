@extends('layouts.auth-app')
@section('title', 'Daftar Akun Baru')

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru</h1>
                        </div>
                        <form class="user" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName" placeholder="Nama Lengkap" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input name="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Alamat Email" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row only-number">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input name="nisn" type="text" minlength="10" maxlength="11" class="form-control number form-control-user @error('nisn') is-invalid @enderror" placeholder="NISN" oninvalid="setCustomValidity('NISN Tidak Valid')"  onchange="try{setCustomValidity('')}catch(e){}" value="{{ old('nisn') }}">
                                    @error('nisn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-sm-0">
                                    <input name="asal_sekolah" type="text" class="form-control form-control-user @error('asal_sekolah') is-invalid @enderror" placeholder="Asal Sekolah/Instansi" value="{{ old('asal_sekolah') }}">
                                    @error('asal_sekolah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row only-number">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input name="nomor_hp" type="text" minlength="10" maxlength="13" class="form-control form-control-user number @error('nomor_hp') is-invalid @enderror" onchange="try{setCustomValidity('')}catch(e){}"  oninvalid="setCustomValidity('No HP Tidak Valid')" placeholder="Nomer HP Aktif" value="{{ old('nomor_hp') }}" >
                                    @error('nomor_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-sm-0">
                                    <input name="tanggal_lahir" type="text" class="datepicker form-control form-control-user @error('tanggal_lahir') is-invalid @enderror" placeholder="Tanggal Lahir" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-2 mb-sm-0">
                                    <div class="input-group" id="show_hide_password">
                                        <input name="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Kata Sandi">
                                        <div class="input-group-addon d-flex align-items-center">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                          </div>
                                        <small class="ml-3 mt-2 text-secondary">Kata sandi minimal 8 karakter</small>

                                          @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group" id="show_hide_password2">
                                        <input name="password_confirmation" type="password" class="form-control form-control-user"
                                           id="exampleRepeatPassword" placeholder="Ulangi Kata Sandi">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-langkah btn-user btn-block">
                                Daftar Sekarang
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('password.request') }}">Lupa Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Sudah punya akun? Masuk!</a>
                        </div>

                        <div class="text-center mt-4">
                            <a class="small text-langkah" href="{{ url('/') }}">Kembali Ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.datepicker.defaults.format = "dd/mm/yyyy"
        $('.datepicker').datepicker();
    </script>
    <script>
        $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password2 input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password2 input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });
    });
    </script>
@endsection

@section('css')
    <style>
        @media (max-width: 1000px) {
            .input-group-addon a{
                padding : 5px;
            }
        }
    </style>
@endsection
