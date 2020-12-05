@extends('layouts.dashboard-app')
@section('title', 'Edit '.$role->name)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Role</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Role - {{ $role->name }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('role.update', $role->id) }}" id="form" method="post">
         @csrf
         @method("PUT")
         <div class="row">
            <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Nama </label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $role->name }}" placeholder="Nama">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
         </div>
         <div class="float-right">
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
         </div>
      </form>
   </div>
</div>
@endsection