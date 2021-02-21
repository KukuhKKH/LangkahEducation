@extends('layouts.auth-app')
@section('title', 'Verifikasi Email - Langkah Education')

@section('content')
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div id="auth"  class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image">
                    </div>
                    <div class="col-lg-6 align-items-center d-flex">
                        <div class="p-4">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mt-2 mb-4">Email Verifikasi</h1>
                                {{-- Email verifikasi telah dikirim ke alamat email mu, Silahkan cek inbox atau spam--}}
                                @if(Session::has('info'))
                                <div class="alert alert-warning" role="alert">
                                    <small>{{ Session::get('info') }}</small>
                                </div>
                                @endif
                            </div>

                            {{-- {{ route('verification.resend') }} --}}
                            <form class="user" method="POST" action="{{ route('email.new_token') }}">
                                @csrf
                                <p class="mb-5">Silahkan cek email kamu untuk mendapatkan link verifikasi. Jika kamu tidak menerima email, silahkan klik tombol dibawah ini</p>
                                <button type="submit" class="btn btn-langkah btn-user btn-block mt-5">
                                    Kirim Email Verifikasi
                                </button>
                            </form>
                            <div class="text-center mt-4">
                                <a class="small text-langkah" href="{{ url('/') }}">Kembali Ke Beranda</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
