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
      <div class="row">
         <div class="col-12">
            <p>Daftar Siswa yang ada di sekolah {{ $sekolah->nama }}</p>
            <form id="form-hapus" action="{{ route('sekolah.integrasi.hapus', $sekolah->id) }}" method="post">
               @csrf
               <ol>
                  @forelse ($sekolah->siswa as $value)
                  @php
                     $hapus= true;
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