@extends('layouts.dashboard-app')
@section('title', 'Edit '.$gambar->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Update Gambar Soal</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Siswa - {{ $gambar->namae }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('gambar.update', $gambar->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="row">
            <div class="col-xl-12 text-center">
               @if ($gambar->gambar)
                  <img src="{{ asset('upload/soal/'.$gambar->gambar) }}" alt="{{ $gambar->nama }}" class="img-fluid mb-4" style="width:250px">
               @endif
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Nama Gambar</label>
                  <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $gambar->nama }}" placeholder="Nama Gambar">
                  @error('nama')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Gambar</label>
                  <div class="custom-file">
                     <input type="file" class="custom-file-input form-control @error('gambar') is-invalid @enderror" name="foto" accept="image/*">
                     <label class="custom-file-label" for="customFile">Choose file</label>
                   </div>
                  @error('foto')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xl-12">
               <div class="float-right">
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection

@section('js')
    <script>
       $('input[type="file"]').change(function(e){
       var fileName = e.target.files[0].name;
       $('.custom-file-label').html(fileName);
   });
    </script>
@endsection
