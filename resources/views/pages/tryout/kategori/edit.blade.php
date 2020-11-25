@extends('layouts.dashboard-app')
@section('title', "Edit Kategori Try out - ".$kategori->nama)

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Edit Kategori Try out - {{ $kategori->nama }}</h1>

   <div class="card shadow mb-4">
      <div class="card-header py-3">
          <div class="d-flex justify-content-between mb-1">
          <h6 class="m-0 font-weight-bold text-primary">Edit Kategori Try out - {{ $kategori->nama }}</h6>
          </div>
      </div>
      <div class="card-body">
         <form action="{{ route('kategori.update', $kategori->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                   <label for="">Nama Kategori</label>
                   <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Role" value="{{ $kategori->nama }}">
                   @error('nama')
                      <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                </div>
                <div class="form-group">
                   <label for="">Deskripsi</label>
                   <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Masukkan Deskripsi" value="{{ $kategori->deskripsi }}">
                   @error('deskripsi')
                      <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                      </span>
                   @enderror
                </div>
                <div class="form-group row">
                   <div class="col-6">
                      <label for="">Gambar <small>Opsional</small></label>
                      <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">
                      @error('foto')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                         </span>
                      @enderror
                   </div>
                   <div class="col-6">
                      <img src="{{ asset("upload/>tryout/kategori/$kategori->image") }}" alt="Image" class="img-fluid" width="300">
                   </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kategori.index') }}" type="button" class="btn btn-light">Batal</a>
            </div>
        </form>
      </div>
   </div>
@endsection

@section('js')
@endsection