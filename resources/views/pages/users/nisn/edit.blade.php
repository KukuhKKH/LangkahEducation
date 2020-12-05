@extends('layouts.dashboard-app')
@section('title', 'Edit '.$nisn->sekolah->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Update NISN</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">NISN - {{ $nisn->sekolah->nama }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('nisn.update', $nisn->id) }}" id="form" method="post">
         @csrf
         @method("PUT")
         <div class="modal-body">
            <div class="form-group">
               <label for="">NISN</label>
               <input type="text" class="form-control" name="nisn" placeholder="Masukkan NISN" value="{{ $nisn->nisn }}">
            </div>
         </div>
         <div class="row">
            <div class="col-xl-12">
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