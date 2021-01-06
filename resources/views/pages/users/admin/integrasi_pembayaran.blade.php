@extends('layouts.dashboard-app')
@section('title', 'Admin - Pembayaran')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Admin - Pembayaran</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between mb-1">
         <h6 class="m-0 font-weight-bold text-primary">Admin - Pembayaran ke User {{ $user->name }}</h6>
      </div>
   </div>
   <div class="card-body">
      <button class="btn btn-success mb-4" id="ceklist-semua">Ceklist Semua</button>
      <button class="btn btn-danger mb-4" id="unceklist-semua">Unceklist Semua</button>
      <form action="{{ route('store.admin.pembayaran', $user->id) }}" method="post">
         @csrf
         @forelse ($pembayaran as $value)
         <div class="col-xl-12">
            <input type="checkbox" name="pembayaran_id[]" class="minimal-red" value="{{ $value->id }}" >
            <label for="">{{ $value->user->name }} - {{ $value->gelombang->nama }} - {{ date('d F Y', strtotime($value->created_at)) }}</label>
         </div>
         @empty
            Belum ada Pembayaran / Pembayaran sudah diintegrasikan semua
         @endforelse
         {{ $pembayaran->links() }}
         <div class="float-right">
            <button class="btn btn-primary btn-sm">
               <i class="fas fa-check mr-1"></i> Set Pembayaran
            </button>
         </div>
      </form>
   </div>
</div>
@endsection

@section('js')
   <script>
      $("#ceklist-semua").on('click', () => {
         $("input[type=checkbox]").prop('checked', true)
      })
      $("#unceklist-semua").on('click', () => {
         $("input[type=checkbox]").prop('checked', false)
      })
   </script>
@endsection