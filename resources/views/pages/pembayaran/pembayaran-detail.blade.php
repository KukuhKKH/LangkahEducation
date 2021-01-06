@extends('layouts.dashboard-app')
@section('title', 'Pembayaran ')

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Pembayaran Detail</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
         <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Pembayaran Detail</h6>
         </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Bank Transfer</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Tanggal Upload</th>
                        <th>Tanggal Diubah</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Bank Transfer</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Tanggal Upload</th>
                        <th>Tanggal Diubah</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                     <tr>
                        <td>1</td>
                        <td>{{ $pembayaran->bank->nama }}</td>
                        @php $bukti = $pembayaran->bukti; @endphp
                        <td>
                           <img src="{{ asset("upload/bukti/$bukti") }}" alt="{{ $bukti }}" width="200">
                        </td>
                        <td>
                           @if (count($pembayaran->pembayaran->pembayaran_bukti) > 0)
                              @if ($pembayaran->pembayaran->status == 1)
                              <span class="badge badge-success p-2">Sudah Upload Bukti Pembayaran</span>
                              @elseif($pembayaran->pembayaran->status == 2)
                              <span class="badge badge-success p-2">Pembayaran Telah Diverifikasi</span>
                              @elseif($pembayaran->pembayaran->status == 3)
                              <span class="badge badge-danger p-2">Pembayaran Ditolak</span>
                              @endif
                           @else
                              <span class="badge badge-danger p-2">Balum Upload Bukti Pembayaran</span>
                           @endif
                        </td>
                        <td>{{ date('d F Y', strtotime($pembayaran->created_at)) }}</td>
                        <td>{{ date('d F Y', strtotime($pembayaran->updated_at)) }}</td>
                        <td>
                           <a class="btn btn-success my-1 terima" data-id="{{ $pembayaran->pembayaran->id }}" data-toggle="tooltip" data-placement="top" title="Verifikasi Pembayaran">
                              <i class="fas fa-check"></i>
                           </a>
                           <a class="btn btn-danger my-1 tolak" data-id="{{ $pembayaran->pembayaran->id }}" data-toggle="tooltip" data-placement="top" title="Tolak Pembayaran">
                              <i class="fas fa-times"></i>
                           </a>
                        </td>
                     </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('css')
   <link rel="stylesheet" href="{{ asset('assets/vendor/fluidbox/fluidbox.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('assets/vendor/fluidbox/jquery.fluidbox.min.js') }}"></script>
<script>
   const URL = `{{ url('dashboard/pembayaran-siswa/status/') }}/`
   if ($.isFunction($.fn.fluidbox)) {
		$('a').fluidbox()
	}
   $(".terima").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menerima pembayaran ini!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Tidak',
         confirmButtonText: 'Ya!'
      }).then((result) => {
         if (result.isConfirmed) {
            let id = $(this).data('id')
            window.location.replace(`${URL}${id}/terima`)
         }
      })
   })

   $(".tolak").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menolak pembayaran ini!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Tidak',
         confirmButtonText: 'Ya!'
      }).then((result) => {
         if (result.isConfirmed) {
            let id = $(this).data('id')
            window.location.replace(`${URL}${id}/tolak`)
         }
      })
   })
</script>
@endsection