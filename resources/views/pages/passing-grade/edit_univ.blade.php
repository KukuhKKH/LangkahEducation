@extends('layouts.dashboard-app')
@section('title', 'Edit '.$universitas->prodi)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Universitas</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Universitas - {{ $universitas->nama }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('universitas.update', $universitas->id) }}" id="form" method="post">
         @csrf
         @method("PUT")
         <div class="form-group">
            <label for="">Nama Universitas</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Universitas" value="{{ $universitas->nama }}">
            @error('nama')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
         </div>
         <div class="mt-3 text-right">
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
            <button type="submit" class="btn btn-success">Edit</button>
         </div>
      </form>
   </div>
</div>
@endsection
