@extends('layouts.dashboard-app')
@section('title', 'Pengaturan Landing Page')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Pengaturan - Landing Page</h1>
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Hero</h6>
            </div>
            <div class="card-body">
                <form action="#">
                    <div class="form-group">
                        <label for="">Headline</label>
                        <input type="text" name="headline" class="form-control @error('headline') is-invalid @enderror"
                            placeholder="Masukkan Headline">
                        @error('headline')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Tagline</label>
                        <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror"
                            placeholder="Masukkkan Tagline">
                        @error('tagline')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button class="btn btn-langkah btn-block" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Footer</h6>
            </div>
            <div class="card-body">
                <form action="#">
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Masukkan Alamat">
                        @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">No. HP/WA</label>
                        <input type="text" name="noHP" class="form-control @error('noHP') is-invalid @enderror"
                            placeholder="Masukkkan No.HP/WA">
                        @error('noHP')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="akunIG">Akun Instagram</label>
                                <input type="text" name="akunIG" class="form-control @error('akunIG') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Instagram">
                                @error('akunIG')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="">URL Instagram</label>
                                <input type="text" name="urlIG" class="form-control @error('urlIG') is-invalid @enderror"
                                    placeholder="Masukkkan URL Instagram">
                                @error('urlIG')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="akunIG">Akun Facebook</label>
                                <input type="text" name="akunFB" class="form-control @error('akunFB') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Facebook">
                                @error('akunFB')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="">URL Facebook</label>
                                <input type="text" name="urlFB" class="form-control @error('urlFB') is-invalid @enderror"
                                    placeholder="Masukkkan URL Facebook">
                                @error('urlFB')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="akunIG">Akun Twitter</label>
                                <input type="text" name="akunTwitter" class="form-control @error('akunTwitter') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Twitter">
                                @error('akunTwitter')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="">URL Twitter</label>
                                <input type="text" name="urlTwitter" class="form-control @error('urlTwitter') is-invalid @enderror"
                                    placeholder="Masukkkan URL Twitter">
                                @error('urlTwitter')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="akunIG">Akun LINE</label>
                                <input type="text" name="akunLINE" class="form-control @error('akunLINE') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun LINE">
                                @error('akunLINE')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="">URL LINE</label>
                                <input type="text" name="urlLINE" class="form-control @error('urlLINE') is-invalid @enderror"
                                    placeholder="Masukkkan URL LINE">
                                @error('urlLINE')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="akunIG">Akun Youtube</label>
                                <input type="text" name="akunYoutube" class="form-control @error('akunYoutube') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Youtube">
                                @error('akunYoutube')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="">URL Youtube</label>
                                <input type="text" name="urlYoutube" class="form-control @error('urlYoutube') is-invalid @enderror"
                                    placeholder="Masukkkan URL Youtube">
                                @error('urlYoutube')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-langkah btn-block" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
