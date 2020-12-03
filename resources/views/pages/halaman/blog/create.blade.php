@extends('layouts.dashboard-app')
@section('title', 'Buat Artikel')

@section('content')
<div class="row">
    <div class="col-10">
        <h1 class="h3 mb-4 text-gray-800">Buat Artikel</h1>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="">
            <div class="row">
                <div class="col-lg-10">
                    <div class="form-group">
                        <input name="nama" type="text"
                            class="form-control form-control-user @error('nama') is-invalid @enderror" id="namaBank"
                            placeholder="Masukkan Judul Artikel" value="{{ old('nama') }}" required>
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                    <option value="" selected disabled>-- Pilih Kategori--</option>
                                    <option value="kategori">Kategori A</option>
                                </select>
                                @error('kategori')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="publikasikan">Publikasikan</option>
                                    <option value="simpanDraf">Simpan ke Draf</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 text-right">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-fw fa-paper-plane"></i>
                        Publikasikan</button>

                </div>

            </div>
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="form-group">
                        <textarea type="text" class="form-control @error('create-article') is-invalid @enderror"
                            id="create-article" name="create-article"
                            placeholder="Pembahaasan">{{ old('create-article') }}</textarea>
                        @error('create-article')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('css')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/ckeditor/contents.css') }}"> --}}
@endsection

@section('js')
<script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
{{-- <script src="{{ asset('assets/vendor/ckeditor/styles.js') }}"></script> --}}
<script>
    const option = {
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
    }
    CKEDITOR.replace('create-article', option)
    CKEDITOR.config.height = 500;

</script>
@endsection
