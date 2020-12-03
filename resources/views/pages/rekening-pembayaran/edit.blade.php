@extends('layouts.dashboard-app')
@section('title', 'Edit '.$bank->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Rekening</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Rekening - {{ $bank->nama }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('rekening.update', $bank->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="form-group">
            <label for="nama">Bank/Instansi Asal</label>
            <input name="nama" type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
               id="namaBank" placeholder="Nama Bank/Instansi" value="{{ $bank->nama }}" required>
            @error('nama')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="nomer_rekening">Nomor Rekening</label>
            <input name="nomer_rekening" type="text"
               class="form-control form-control-user @error('nomer_rekening') is-invalid @enderror" id="nomorRekening"
               placeholder="Nomor Rekening" value="{{ $bank->nomer_rekening }}" required>
            @error('nomer_rekening')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="alias">Nama Pemilik (a/n)</label>
            <input name="alias" type="text" class="form-control form-control-user @error('alias') is-invalid @enderror"
               id="nomorRekening" placeholder="Nama Pemilik (a/n)" value="{{ $bank->alias }}" required>
            @error('alias')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group row">
            <div class="col-md-6">
               <label for="name">Logo</label>
               <div class="input-group">
                  <div class="custom-file">
                     <input type="file" name="file" class="custom-file-input" id="inputGroupFile02">
                     <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                  </div>
               </div>
            </div>
            @if ($bank->logo)
               <div class="col-md-6">
                  <img src="{{ asset("upload/bank/$bank->logo") }}" alt="{{ $bank->nama }}" width=100>
               </div>
            @endif
         </div>
         <div class="mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
         </div>
      </form>
   </div>
</div>
@endsection