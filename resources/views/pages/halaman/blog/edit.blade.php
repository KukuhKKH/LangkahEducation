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
        <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
            @csrf
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
                            <input name="foto" type="file"
                            class="form-control form-control-user @error('foto') is-invalid @enderror" id="foto" required>
                            @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="">Kategori</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" autocomplete="off">
                                        <option value="" selected disabled>-- Pilih Kategori--</option>
                                        <option value="UTBK" {{ $artikel->kategori == "UTBK" ? 'selected' : '' }}>UTBK</option>
                                        <option value="SBMPTN" {{ $artikel->kategori == "SBMPTN" ? 'selected' : '' }}>SBMPTN</option>
                                        <option value="SAINTEK" {{ $artikel->kategori == "SAINTEK" ? 'selected' : '' }}>SAINTEK</option>
                                        <option value="SOSHUM" {{ $artikel->kategori == "SOSHUM" ? 'selected' : '' }}>SOSHUM</option>
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
    CKEDITOR.replace('isi', option)
    CKEDITOR.config.height = 500;

</script>
@endsection
