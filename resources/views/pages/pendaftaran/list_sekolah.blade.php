@extends('layouts.dashboard-app')
@section('title', 'List Sekolah')

@section('content')
<h1 class="h3 mb-2 text-gray-800">List Sekolah</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between mb-1">
         <h6 class="m-0 font-weight-bold text-primary">List Sekolah</h6>
      </div>
      <div class="text-center" id="loading" style="display: none">
         <div class="spinner-border text-primary spinner-border-lg" role="status">
            <span class="sr-only">Loading...</span>
         </div>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Nama Sekolah</th>
                  <th>Total Siswa</th>
                  {{-- <th width="25%">Aksi</th> --}}
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>No</th>
                  <th>Nama Sekolah</th>
                  <th>Total Siswa</th>
                  {{-- <th width="25%">Aksi</th> --}}
               </tr>
            </tfoot>
            <tbody>
               @forelse($gelombang->sekolah as $value)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $value->nama }}</td>
                  <td>{{ count($value->siswa) }}</td>
                  {{-- <td>
                     <a href="javascript:void(0)" onclick="detailTryout({{ $value->user->id }})" class="btn btn-primary"
                        data-toggle="tooltip" data-placement="top" title="Analisis hasil tryout">
                        <i class="fas fa-fw fa-desktop"></i>
                     </a>
                  </td> --}}
               </tr>
               @empty
               <tr>
                  <td colspan="5">
                     <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Sekolah</h6>
                     </div>
                  </td>
               </tr>
               @endforelse
            </tbody>
         </table>
      </div>
   </div>
</div>

@endsection

@section('js')
<script src="{{ asset('assets/vendor/moment.js') }}"></script>
@endsection