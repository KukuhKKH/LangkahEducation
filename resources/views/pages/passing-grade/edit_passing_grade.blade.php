@extends('layouts.dashboard-app')
@section('title', 'Edit '.$passing_grade->prodi)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Passing Grade</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Passing Grade - {{ $passing_grade->prodi }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('passing-grade.update', $passing_grade->id) }}" id="form" method="post">
         @csrf
         @method("PUT")
         <div class="form-group">
            <label for="">Nama Prodi</label>
            <input type="text" class="form-control @error('prodi') is-invalid @enderror" name="prodi" placeholder="Masukkan Nama Prodi" value="{{ $passing_grade->prodi }}">
            @error('prodi')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="">Passing Grade</label>
            <input type="number" class="form-control @error('passing_grade') is-invalid @enderror" name="passing_grade" step="0.01"  placeholder="Masukkan Passing grade" value="{{ $passing_grade->passing_grade }}">
            @error('passing_grade')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
            @enderror
         </div>
         <div class="form-group">
         <label for="">Kelompok Prodi</label>
         <select name="kelompok_id" class="form-control @error('kelompok_id') is-invalid @enderror">
            <option value="" selected disabled>-- Pilih --</option>
            @foreach ($kelompok as $value)
            @if ($value->id == $passing_grade->kelompok_id)
            <option value="{{ $value->id }}" selected>{{$value->nama}}</option>
            @else
            <option value="{{ $value->id }}">{{$value->nama}}</option>
            @endif
            @endforeach
         </select>
         @error('kelompok_id')
               <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
               </span>
         @enderror
         <div class="mt-3 text-right">
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
         </div>
      </form>
   </div>
</div>
@endsection
