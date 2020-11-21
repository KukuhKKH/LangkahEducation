@extends('layouts.dashboard-app')
@section('title', "Paket Try out - ".$paket->nama)

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Edit Paket Try out - {{ $paket->nama }}</h1>
   <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

   <div class="card shadow mb-4">
      <div class="card-header py-3">
          <div class="d-flex justify-content-between mb-1">
          <h6 class="m-0 font-weight-bold text-primary">Edit Soal Try out - {{ $paket->nama }}</h6>
          </div>
      </div>
      <div class="card-body">
         <form action="{{ route('paket.update', $paket->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
               <label for="">Nama Paket</label>
               <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Pembahaasan" value="{{ $paket->nama }}" required>
               @error('nama')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
            <div class="form-group">
               <label for="">Status</label>
               <select name="status" class="form-control @error('status') is-invalid @enderror">
                  <option value="1" {{ $paket->status == 1 ? 'selected': '' }}>Aktif</option>
                  <option value="0" {{ $paket->status == 0 ? 'selected': '' }}>Tidak Aktif</option>
               </select>
               @error('status')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
            <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary" >Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
   </div>
@endsection