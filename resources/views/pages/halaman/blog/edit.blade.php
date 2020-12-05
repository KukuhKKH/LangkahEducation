@extends('layouts.dashboard-app')
@section('title', 'Edit Artikel')

@section('content')
<div class="row">
    <div class="col-10">
        <h1 class="h3 mb-4 text-gray-800">Edit Artikel</h1>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('blog.update', $artikel->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-10">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="">Judul Artikel</label>
                        </div>
                        <div class="col-md-10">
                            <input name="judul" type="text"
                            class="form-control form-control-user @error('judul') is-invalid @enderror" id="judul"
                            placeholder="Masukkan Judul Artikel" value="{{ $artikel->judul }}" required>
                            @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="">Gambar Utama Artikel</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input form-control form-control-user @error('foto') is-invalid @enderror"
                                        id="foto" name="foto">
                                        @error('foto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="">Kategori</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="kategori[]" class="select2 form-control @error('kategori') is-invalid @enderror" id="kategori" multiple="multiple">
                                        @foreach ($kategori as $value)
                                            <option value="{{ $value->id }}" {{ in_array($value->id, $kategori_id) ? 'selected' : '' }}>{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="">Status</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" autocomplete="off">
                                        <option value="1" {{ $artikel->status == 1 ? 'selected' : "" }}>Publikasikan</option>
                                        <option value="0" {{ $artikel->status == 0 ? 'selected' : "" }}>Simpan ke Draf</option>
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
                </div>
                <div class="col-lg-2 text-right">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-fw fa-paper-plane"></i>
                        Publikasikan</button>

                </div>

            </div>
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="form-group">
                        <textarea type="text" class="form-control @error('isi') is-invalid @enderror"
                            id="isi" name="isi"
                            placeholder="Pembahaasan">{{ $artikel->isi }}</textarea>
                        @error('isi')
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
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
{{-- <script src="{{ asset('assets/vendor/ckeditor/styles.js') }}"></script> --}}<script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>
<script>
    const option = {
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
    }
    CKEDITOR.replace('isi', option)
    CKEDITOR.config.height = 500;
    $(document).ready(function() {
        $("#kategori").select2({
            placeholder: "Pilih Kategori",
            allowClear: true
        })
    })
</script>
@endsection
