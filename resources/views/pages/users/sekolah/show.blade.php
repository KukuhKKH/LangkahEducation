@extends('layouts.dashboard-app')
@section('title', 'Edit '.$sekolah->user->name)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Sekolah</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Sekolah - {{ $sekolah->user->name }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('sekolah.integrasi', $sekolah->id) }}" id="form" method="post">
         @csrf
         <div class="row">
            <div class="col-12">
               <div class="form-group">
                  <label for="">Daftar Siswa</label>
                  <select name="siswa[]" multiple id="daftar-siswa" class="form-group">
                     @foreach ($siswa as $value)
                        <option value="{{ $value->id }}">{{ $value->user->name }}</option> 
                     @endforeach
                  </select>
                  @error('siswa')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
         </div>
         <div class="float-right">
            <button type="submit" class="btn btn-success">Integrasi</button>
            <a href="{{ url()->previous() }}" class="btn btn-warning text-dark ml-1">Kembali</a>
         </div>
      </form>
   </div>
</div>
@endsection

@section('js')
   <script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>
   <script>
      $("#daftar-siswa").select2()
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