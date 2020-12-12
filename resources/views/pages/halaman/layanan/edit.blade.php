@extends('layouts.dashboard-app')
@section('title', 'Edit '.$layanan->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">layanan</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Layanan - {{ $layanan->nama }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('layanan.update', $layanan->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="row">
            <div class="col-xl-12">
               <div class="form-group">
                  <label for="">Nama layanan</label>
                  <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                     value="{{ $layanan->nama }}" placeholder="Nama layanan">
                  @error('nama')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-12">
               <div class="form-group">
                  <label for="name">Deskripsi Layanan</label>
                  <textarea name="deskripsi" class="form-control" maxlength="15" id="deskripsi">{{ $layanan->deskripsi }}</textarea>
                  @error('nama')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-12">
               <div class="form-group">
                  <label for="">Foto <small>Maksimal 2 Mb</small></label>
                  <div class="input-group mb-3">
                     <div class="custom-file">
                        <input type="file" class="custom-file-input form-control @error('foto') is-invalid @enderror"
                           name="foto" accept="image/x-png,image/gif,image/jpeg" id="inputGroupFile02">
                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <label class="custom-file-label " for="inputGroupFile02">Choose file</label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xl-6">
               @if ($layanan->foto)
               <img src="{{ asset('upload/users/'.$layanan->foto) }}" alt="{{ $layanan->name }}"
                  class="img-fluid w-100">
               @endif
            </div>
            <div class="col-xl-6">
               <div class="float-right">
                  <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
                  <button type="submit" class="btn btn-success">Simpan</button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection

@section('js')
<script>
   const option = {
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
    }
</script>
<script type="application/javascript">
   $('input[type="file"]').change(function(e){
       var fileName = e.target.files[0].name;
       $('.custom-file-label').html(fileName);
   });
</script>
@endsection