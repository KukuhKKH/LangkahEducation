@extends('layouts.dashboard-app')
@section('title', 'Pembayaran')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Pembayaran</h1>

<div class="card shadow mb-4">
   <div class="card-header">
      <div class="row align-items-center">
         <div class="col-xl-6">
            <h6 class="m-0 font-weight-bold text-primary">Pembayaran</h6>
         </div>
         <div class="col-xl-6 text-right">
            <a href="{{ route('admin.pembayaran', $user->id) }}" class="btn btn-primary my-1"><i class="fa fa-plus"></i> Tambah Pembayaran</a>
         </div>
      </div>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>Nama Siswa</th>
                  <th>Gelombang</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>Nama Siswa</th>
                  <th>Gelombang</th>
                  <th>Aksi</th>
               </tr>
            </tfoot>
            <tbody>
               @forelse($pembayaran as $value)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $value->id }}</td>
                  <td>{{ $value->user->name }}</td>
                  <td>{{ $value->gelombang->nama }}</td>
                  <td>
                     <button type="button" data-id="{{ $value->id }}" class="btn btn-danger my-1 hapus" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <i class="fas fa-trash"></i>
                     </button>
                  </td>
               </tr>
               @empty
               <tr>
                  <td colspan="5" class="text-center">
                     <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Data Pembayarn</h6>
                    </div>
                  </td>
               </tr>
               @endforelse
            </tbody>
         </table>
         {{ $pembayaran->links() }}
      </div>
   </div>
</div>
@endsection

@section('js')
    <script>
       $(".hapus").on('click', function() {
         Swal.fire({
            title: 'Yakin?',
            text: "Ingin menghapus inttegrasi ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
         }).then((result) => {
            if (result.isConfirmed) {
               let id = $(this).data('id')
               window.location.replace(`{{ route('admin.pembayaran.hapus') }}/${id}`)
            }
         })
      })
    </script>
@endsection