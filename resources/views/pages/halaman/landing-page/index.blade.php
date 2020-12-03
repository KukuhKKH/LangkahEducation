@extends('layouts.dashboard-app')
@section('title', 'Pengaturan Landing Page')

@section('content')
<form action="{{ route('landing_page.update', 1) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-10">
            <h1 class="h3 mb-4 text-gray-800">Pengaturan Landing Page</h1>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Hero</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="">Headline</label>
                                <input type="text" name="headline"
                                    class="form-control @error('headline') is-invalid @enderror"
                                    placeholder="Masukkan Headline" value="{{ $data->headline ?? old('headline') }}">
                                @error('headline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tagline</label>
                                <input type="text" name="tagline"
                                    class="form-control @error('tagline') is-invalid @enderror"
                                    placeholder="Masukkkan Tagline" value="{{ $data->tagline ?? old('tagline') }}">
                                @error('tagline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Foto Hero <small style="color: red">Ukuran 1024 X 955</small></label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="raw_foto_hero"
                                            class="form-control custom-file-input @error('raw_foto_hero') is-invalid @enderror"
                                            id="inputFileHero" accept="image/*">
                                        @error('raw_foto_hero')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label class="custom-file-label" id="labelFileHero">Choose file</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 d-flex align-items-center text-center">
                            @if ($data->foto_hero)
                            <img src="{{ asset("landing-page/foto/$data->foto_hero") }}" alt="{{ $data->foto_hero }}"
                                width="100%">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Tentang Kami</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="">Headline</label>
                                <textarea name="tentang_kami" id="tentang_kami"
                                    class="form-control @error('tentang_kami') is-invalid @enderror"
                                    placeholder="Masukkan Headline">{{ $data->tentang_kami ?? old('tentang_kami') }}</textarea>
                                @error('tentang_kami')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Foto Tentang Kami <small style="color: red">Ukuran 1024 X
                                        955</small></label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="raw_foto_tentang_kami"
                                            class="form-control custom-file-input @error('raw_foto_tentang_kami') is-invalid @enderror"
                                            id="inputFileAbout" accept="image/*">
                                        @error('raw_foto_tentang_kami')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label class="custom-file-label" id="labelFileAbout">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-flex align-items-center text-center">
                            @if ($data->foto_tentang_kami)
                            <img src="{{ asset("landing-page/foto/$data->foto_tentang_kami") }}"
                                alt="{{ $data->foto_tentang_kami }}" width="100%">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Headline - Produk</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea name="headline_produk" id="headline_produk"
                            class="form-control @error('headline_produk') is-invalid @enderror"
                            placeholder="Masukkan Headline">{{ $data->headline_produk ?? old('headline_produk') }}</textarea>
                        @error('headline_produk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Headline - Blog</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea name="headline_blog" id="headline_blog"
                            class="form-control @error('headline_blog') is-invalid @enderror"
                            placeholder="Masukkan Headline">{{ $data->headline_blog ?? old('headline_blog') }}</textarea>
                        @error('headline_blog')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Headline - Testimoni</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Headline Testimoni</label>
                        <textarea name="headline_testimoni" id="headline_testimoni"
                            class="form-control @error('headline_testimoni') is-invalid @enderror"
                            placeholder="Masukkan Headline">{{ $data->headline_testimoni ?? old('headline_testimoni') }}</textarea>
                        @error('headline_testimoni')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Biaya</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Headline Biaya</label>
                        <textarea name="headline_biaya" id="headline_biaya"
                            class="form-control @error('headline_biaya') is-invalid @enderror"
                            placeholder="Masukkan Headline">{{ $data->headline_biaya ?? old('headline_biaya') }}</textarea>
                        @error('headline_biaya')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Biaya Individu</label>
                                <textarea name="biaya_individu" id="biaya_individu"
                                    class="form-control @error('biaya_individu') is-invalid @enderror"
                                    placeholder="Masukkan Headline">{{ $data->biaya_individu ?? old('biaya_individu') }}</textarea>
                                @error('biaya_individu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Biaya Sekolah</label>
                                <textarea name="biaya_sekolah" id="biaya_sekolah"
                                    class="form-control @error('biaya_sekolah') is-invalid @enderror"
                                    placeholder="Masukkan Headline">{{ $data->biaya_sekolah ?? old('biaya_sekolah') }}</textarea>
                                @error('biaya_sekolah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Footer</h6>
                </div>
                <div class="card-body">

                <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Masukkan deskripsi">{{ $data->deskripsi ?? old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email" value="{{ $data->email ?? old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Masukkan Alamat" value="{{ $data->alamat ?? old('alamat') }}">
                        @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">No. HP/WA</label>
                        <input type="text" name="noHP" class="form-control @error('noHP') is-invalid @enderror"
                            placeholder="Masukkkan No.HP/WA" value="{{ $data->noHP ?? old('noHP') }}">
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
                                <input type="text" name="akunIG"
                                    class="form-control @error('akunIG') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Instagram"
                                    value="{{ $data->akunIG ?? old('akunIG') }}">
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
                                <input type="text" name="urlIG"
                                    class="form-control @error('urlIG') is-invalid @enderror"
                                    placeholder="Masukkkan URL Instagram" value="{{ $data->urlIG ?? old('urlIG') }}">
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
                                <input type="text" name="akunFB"
                                    class="form-control @error('akunFB') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Facebook"
                                    value="{{ $data->akunFB ?? old('akunFB') }}">
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
                                <input type="text" name="urlFB"
                                    class="form-control @error('urlFB') is-invalid @enderror"
                                    placeholder="Masukkkan URL Facebook" value="{{ $data->urlFB ?? old('urlFB') }}">
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
                                <input type="text" name="akunTwitter"
                                    class="form-control @error('akunTwitter') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Twitter"
                                    value="{{ $data->akunTwitter ?? old('akunTwitter') }}">
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
                                <input type="text" name="urlTwitter"
                                    class="form-control @error('urlTwitter') is-invalid @enderror"
                                    placeholder="Masukkkan URL Twitter"
                                    value="{{ $data->urlTwitter ?? old('urlTwitter') }}">
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
                                <input type="text" name="akunLine"
                                    class="form-control @error('akunLine') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun LINE"
                                    value="{{ $data->akunLine ?? old('akunLine') }}">
                                @error('akunLine')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="">URL LINE</label>
                                <input type="text" name="urlLine"
                                    class="form-control @error('urlLine') is-invalid @enderror"
                                    placeholder="Masukkkan URL LINE" value="{{ $data->urlLine ?? old('urlLine') }}">
                                @error('urlLine')
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
                                <input type="text" name="akunYoutube"
                                    class="form-control @error('akunYoutube') is-invalid @enderror"
                                    placeholder="Masukkkan Nama Akun Youtube"
                                    value="{{ $data->akunYoutube ?? old('akunYoutube') }}">
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
                                <input type="text" name="urlYoutube"
                                    class="form-control @error('urlYoutube') is-invalid @enderror"
                                    placeholder="Masukkkan URL Youtube"
                                    value="{{ $data->urlYoutube ?? old('urlYoutube') }}">
                                @error('urlYoutube')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
@section('js')
<script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
<script>
    const option = {
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
    }

    CKEDITOR.replace('tentang_kami', option)
    CKEDITOR.replace('headline_produk', option)
    CKEDITOR.replace('headline_blog', option)
    CKEDITOR.replace('headline_testimoni', option)
    CKEDITOR.replace('headline_biaya', option)
    CKEDITOR.replace('biaya_individu', option)
    CKEDITOR.replace('biaya_sekolah', option)

    $('#inputFileHero').on('change', function (e) {
        var fileName = e.target.files[0].name;
        $(this).next('#labelFileHero').html(fileName);
    })

    $('#inputFileAbout').on('change', function (e) {
        var fileName = e.target.files[0].name;
        $(this).next('#labelFileAbout').html(fileName);
    })

</script>
@endsection
