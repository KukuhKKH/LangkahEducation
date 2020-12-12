@extends('layouts.dashboard-app')
@section('title', 'Edit '.$testimoni->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Testimoni</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Testimoni - {{ $testimoni->nama }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('testimoni.update', $testimoni->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input name="nama" type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
               id="exampleFirstName" placeholder="Nama Lengkap" value="{{ $testimoni->nama }}">
            @error('nama')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="status">Status Narasumber</label>
            <input name="role" type="text" class="form-control form-control-user @error('role') is-invalid @enderror"
               id="exampleFirstName" placeholder="Masukkan Status" value="{{ $testimoni->role }}">
            @error('role')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="testimonial">Testimonial</label>
            <textarea name="testimoni" type="text"
               class="form-control form-control-user @error('testimoni') is-invalid @enderror"
               placeholder="Masukkan Status" rows="3">{{ $testimoni->testimoni }}</textarea>
            @error('testimoni')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" autocomplete="off">
               <option value="" selected disabled>-- Pilih --</option>
               <option value="1" {{ $testimoni->status == 1 ? 'selected' : '' }}>Tampil</option>
               <option value="0" {{ $testimoni->status == 0 ? 'selected' : '' }}>Tidak Tampil</option>
            </select>
            @error('status')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="testimonial">Foto <small>Opsional</small></label>
            <div class="input-group mb-3">
               <div class="custom-file">
                  <input type="file" name="file"
                     class="custom-file-input form-control form-control-user @error('foto') is-invalid @enderror"
                     id="inputGroupFile02">
                  @error('foto')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                  <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
               </div>
            </div>
         </div>
         <div class="float-right">
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
         </div>
      </form>
   </div>
</div>
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
    CKEDITOR.replace('deskripsi', option)
</script>
@endsection