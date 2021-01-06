@extends('layouts.dashboard-app')
{{-- @section('title', 'Pembayaran '.strtoupper(request()->segment(3))) --}}
@section('title', 'Pembayaran - '.ucwords(str_replace('-', ' ', request()->segment(3))))

@section('content')
<div class="card shadow mb-4">
   <div class="card-header ">
      <div class="row align-items-center">
         <div class="col-6">
            <h6 class="m-0 font-weight-bold text-primary">Pembayaran - {{ ucwords(str_replace('-', ' ', request()->segment(3))) }}</h6>
         </div>
         <div class="col-6 text-right">
               <a href="{{ route('pembayaran.show', request()->segment(3)) }}"
                  class="btn btn-lght text-danger">Refresh</a>
         </div>
      </div>
   </div>
   <div class="card-body">
      @if (strtoupper(request()->segment(3)) == "SUDAH-DIVERIFIKASI")
      <form action="{{ route('pembayaran.export') }}" method="POST" class="mb-4">
         @csrf
         <div class="row">
            <div class="col-md-5">
               <input type="text" placeholder="Tanggal Awal" class="form-control datepicker" id="tgl_awal" name="tgl_awal" autocomplete="off">
            </div>
            <div class="col-md-5">
               <input type="text" placeholder="Tanggal Akhir" class="form-control datepicker" id="tgl_akhir" name="tgl_akhir" autocomplete="off">
            </div>
            <div class="col-md-2">
               <button class="btn btn-success">Export</button>
            </div>
         </div>
      </form>
      @endif
      
      <form action="" method="GET">
         <div class="row mb-4 justify-content-end align-items-center">
            <div class="col-xl-3">
               <select name="gelombang" id="gelombang" class="form-control">
                  <option value="0" disabled selected>== Semua Gelombang ==</option>
                  @foreach ($gelombang as $value)
                      <option value="{{ $value->id }}">{{ $value->nama }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-xl-3">
               <select name="bank_id" id="bank_id" class="form-control">
                  <option value="0" disabled selected>== Semua Bank ==</option>
                  @foreach ($bank as $value)
                      <option value="{{ $value->id }}">{{ $value->nama }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-xl-3">
               <select name="time" id="time" class="form-control">
                  <option value="0" selected>Terbaru</option>
                  <option value="1">Terlama</option>
               </select>
            </div>
            <div class="col-xl-3">
               <div class="input-group">
                  <input type="text" name="keyword" class="form-control" placeholder="Masukkan Nama Siswa"
                     aria-label="Masukkan Nama Siswa" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                     <button class="btn btn-primary" type="submit">Cari</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Tgl</th>
                  <th>Nama Siswa</th>
                  <th>Gelombang</th>
                  <th>Biaya</th>
                  <th>Bank</th>
                  <th>Status</th>
                  <th width="25%">Aksi</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>No</th>
                  <th>Tgl</th>
                  <th>Nama Siswa</th>
                  <th>Gelombang</th>
                  <th>Biaya</th>
                  <th>Bank</th>
                  <th>Status</th>
                  <th width="25%">Aksi</th>
               </tr>
            </tfoot>
            <tbody>
               @forelse($pembayaran as $value)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>Ini Diisi Tanggal</td>
                  <td>{{ $value->user->name }}</td>
                  <td>{{ $value->gelombang->nama }}</td>
                  <td>Ini Diisi Biaya</td>
                  <td>Ini Diisi Nama Bank</td>
                  
                  <td>
                     @if (count($value->pembayaran_bukti) > 0)
                     @if ($value->status == 1)
                     <span class="badge badge-success p-2">Sudah Upload</span>
                     @elseif($value->status == 2)
                     <span class="badge badge-success p-2">Telah Diverifikasi</span>
                     @elseif($value->status == 3)
                     <span class="badge badge-danger p-2">Ditolak</span>
                     @endif
                     @else
                     <span class="badge badge-danger p-2">Belum Upload</span>
                     @endif
                  </td>
                  <td>
                     @if (count($value->pembayaran_bukti) > 0)
                     @if ($value->status == 1)
                     {{-- @php $bukti = $value->pembayaran_bukti->first()->bukti; @endphp --}}
                     {{-- <a href="{{ asset("upload/bukti/$bukti") }}" target="_blank" class="btn btn-primary"
                     data-toggle="tooltip" data-placement="top" title="Detail Bukti Pembayaran">
                     <i class="fas fa-eye"></i>
                     </a> --}}
                     <a href="{{ route('pembayaran-admin-detail', $value->id) }}" class="btn btn-primary"
                        data-toggle="tooltip" data-placement="top" title="Detail Bukti Pembayaran">
                        <i class="fas fa-eye"></i>
                     </a>
                     @endif
                     @if ($value->status == 2)
                     <a href="{{ route('pembayaran-admin-detail', $value->id) }}" class="btn btn-primary"
                        data-toggle="tooltip" data-placement="top" title="Detail Bukti Pembayaran">
                        <i class="fas fa-eye"></i>
                     </a>
                     <a class="btn btn-danger my-1 tolak" data-id="{{ $value->id }}" data-toggle="tooltip"
                        data-placement="top" title="Tolak Pembayaran">
                        <i class="fas fa-times"></i>
                     </a>
                     @endif
                     @if ($value->status == 3)
                     <a href="{{ route('pembayaran-admin-detail', $value->id) }}" class="btn btn-primary"
                        data-toggle="tooltip" data-placement="top" title="Detail Bukti Pembayaran">
                        <i class="fas fa-eye"></i>
                     </a>
                     @endif
                     @endif
                     <?php $disable = $value->status == 0 ? true : false ?>
                     @if ($value->status == 1)
                     <a class="btn btn-success my-1 terima {{ ($disable) ? 'disabled' : '' }}"
                        data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top"
                        title="Verifikasi Pembayaran" {{ ($disable) ? 'disabled' : '' }}>
                        <i class="fas fa-check"></i>
                     </a>
                     <a class="btn btn-danger my-1 tolak {{ ($disable) ? 'disabled' : '' }}" data-id="{{ $value->id }}"
                        data-toggle="tooltip" data-placement="top" title="Tolak Pembayaran"
                        {{ ($disable) ? 'disabled' : '' }}>
                        <i class="fas fa-times"></i>
                     </a>
                     @elseif($value->status == 3)
                     <a class="btn btn-success my-1 terima {{ ($disable) ? 'disabled' : '' }}"
                        data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top"
                        title="Verifikasi Pembayaran" {{ ($disable) ? 'disabled' : '' }}>
                        <i class="fas fa-check"></i>
                     </a>
                     @elseif($value->status == 0)
                     <a class="btn btn-danger my-1 tolak" data-id="{{ $value->id }}" data-toggle="tooltip"
                        data-placement="top" title="Tolak Pembayaran">
                        <i class="fas fa-times"></i>
                     </a>
                     @endif
                  </td>
               </tr>
               @empty
               <tr>
                  <td colspan="5">
                     <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Pembayaran</h6>
                     </div>
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
<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('assets/vendor/fluidbox/jquery.fluidbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>
   $('#tgl_awal').datepicker({
      format: "yyyy-mm-dd",
   })
   $('#tgl_akhir').datepicker({
      format: "yyyy-mm-dd",
   })
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