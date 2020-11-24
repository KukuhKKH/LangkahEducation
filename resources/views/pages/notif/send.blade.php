@extends('layouts.dashboard-app')
@section('title', 'Pemberitahuan')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Kirim Pemberitahuan</h1>

<div class="card shadow mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Kirim Pemberitahuan</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form action="">
                    <div class="form-group">
                        <label for="">Kirim Kepada</label>
                        <select name="siswa[]" multiple id="daftar-user" class="form-group">
                            <option value="0">== Semua Pengguna ==</option>
                            <option value="1">== Semua Siswa ==</option>
                            <option value="2">== Semua Mentor ==</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Subject">
                    </div>
                    <div class="form-group">
                        <label for="">Isi Pesan</label>
                        <textarea type="text" class="form-control @error('soal') is-invalid @enderror" id="soal" name="soal"
                            placeholder="Soal">{{ old('soal') }}</textarea>
                        @error('soal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i
                        class="fa fa-paper-plane"></i> Kirim Pemberitahuan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>
<script>
    $("#daftar-user").select2({
        placeholder: "Kirim Kepada"
    });

</script>

<script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
<script>
    const option = {
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
    }

    CKEDITOR.replace('soal', option)
    CKEDITOR.replace('pembahasan', option)
    CKEDITOR.replace('pilihan1', option)
    CKEDITOR.replace('pilihan2', option)
    CKEDITOR.replace('pilihan3', option)
    CKEDITOR.replace('pilihan4', option)
    CKEDITOR.replace('pilihan5', option)

</script>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
<style>
    #daftar-siswa {
        width: 500px;
    }

</style>
@endsection
