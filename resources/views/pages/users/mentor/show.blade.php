@extends('layouts.dashboard-app')
@section('title', 'Integrasi '.$mentor->user->name)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Mentor</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Mentor - {{ $mentor->user->name }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('mentor.integrasi', $mentor->id) }}" id="form" method="post">
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
            <button type="submit" class="btn btn-primary">Integrasi</button>
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
         </div>
      </form>
   </div>
</div>

<div class="card shadow mb-4">
   <div class="card-header">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa yang dimentori oleh : {{ $mentor->user->name }}</h6>
      </div>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-12">
            <form id="form-hapus" action="{{ route('mentor.integrasi.hapus', $mentor->id) }}" method="post">
               @csrf
               <ol>
                  @forelse ($mentor->siswa as $value)
                  @php
                     $hapus = true;
                  @endphp
                  <li>
                     <input type="checkbox" name="siswa[]" value="{{ $value->id }}">
                     <label>{{ $value->user->name }}</label>
                  </li>
                  @empty
                  <p>Belum Memiliki Siswa</p>
                  @endforelse
               </ol>
               @if ($hapus)
               <button type="button" class="btn btn-danger hapus">Hapus Siswa</button>
               @endif
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@section('js')
   <script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>
   <script>
      $("#daftar-siswa").select2()
      $(".hapus").on('click', function() {
         Swal.fire({
            title: 'Yakin?',
            text: "Ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
         }).then((result) => {
            if (result.isConfirmed) {
               $(`#form-hapus`).submit()
            }
         })
      })
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