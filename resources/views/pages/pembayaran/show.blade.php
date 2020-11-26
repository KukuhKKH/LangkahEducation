@extends('layouts.dashboard-app')
@section('title', 'Pembayaran '.strtoupper(request()->segment(3)))

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Pembayaran {{ strtoupper(request()->segment(3)) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
         <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Pembayaran {{ strtoupper(request()->segment(3)) }}</h6>
         </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Gelombang</th>
                        <td>status</td>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Gelombang</th>
                        <td>status</td>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($pembayaran as $value)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $value->user->name }}</td>
                           <td>{{ $value->gelombang->gelombang }}</td>
                           <td>
                              @if (count($value->pembayaran_bukti) > 0)
                                 <span class="badge badge-success p-2">Sudah Upload Bukti Pembayaran</span>
                              @else
                                 <span class="badge badge-danger p-2">Balum Upload Bukti Pembayaran</span>
                              @endif
                           </td>
                           <td>
                              @if (count($value->pembayaran_bukti) > 0)
                                 @if ($value->status == 1)
                                    <?php $bukti = $value->pembayaran_bukti->first()->bukti; ?>
                                    <a href="{{ asset("upload/bukti/$bukti") }}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Detail Bukti Pembayaran">
                                       <i class="fas fa-eye"></i>
                                    </a>
                                 @endif
                              @endif
                              <?php $disable = $value->status == 0 ? true : false ?>
                              <a class="btn btn-success terima {{ ($disable) ? 'disabled' : '' }}" data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top" title="Verifikasi Pembayaran" {{ ($disable) ? 'disabled' : '' }}>
                                 <i class="fas fa-check"></i>
                              </a>
                              <a class="btn btn-danger tolak {{ ($disable) ? 'disabled' : '' }}" data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top" title="Tolak Pembayaran" {{ ($disable) ? 'disabled' : '' }}>
                                 <i class="fas fa-times"></i>
                              </a>
                           </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $pembayaran->appends($data)->links() }}
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