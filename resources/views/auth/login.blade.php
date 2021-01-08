@extends('layouts.auth-app')
@section('title', 'Masuk - Langkah Education')

@section('content')
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div id="auth"  class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                        </div>
                        <div class="col-lg-6 ">
                            <div class="p-4">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mt-2 mb-4">Selamat Datang!</h1>
                                    @if(Session::has('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <small>{{ Session::get('error') }}</small>
                                    </div>
                                    @endif
                                    @if(Session::has('info'))
                                    <div class="alert alert-warning" role="alert">
                                        <small>{{ Session::get('info') }}</small>
                                    </div>
                                    @endif
                                </div>
                                <form class="user" action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" onchange="try{setCustomValidity('')}catch(e){}"  oninvalid="setCustomValidity('Email Tidak Valid')" aria-describedby="emailHelp" placeholder="Masukkan Email" value="{{ old('email') }}" name="email" autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Email yang kamu masukkan salah</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group rounded-circle">
                                        <label for="password">Kata Sandi</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputPassword" placeholder="Kata Sandi" name="password">
                                            <div class="input-group-addon d-flex align-items-center">
                                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                              </div>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Password yang kamu masukkan salah</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customCheck">Ingatkan Saya</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-langkah btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                                </div>
                                @if (Route::has('register'))
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Saya Belum Punya Akun, Daftar!</a>
                                </div>
                                @endif
                                <div class="text-center mt-2">
                                    <a class="small text-langkah" href="{{ url('/') }}">Kembali Ke Beranda</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
@section('js')

<script>
    $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
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
