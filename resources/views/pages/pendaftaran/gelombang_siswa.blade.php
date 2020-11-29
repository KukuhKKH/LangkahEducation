@extends('layouts.dashboard-app')
@section('title', 'List Gelombang')

@section('content')
   <h1 class="h3 mb-2 text-gray-800">List Gelombang</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">List Gelombang</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Nama Gelombang</th>
                        <th>Harga</th>
                        <th>Total Tryout</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Nama Gelombang</th>
                        <th>Harga</th>
                        <th>Total Tryout</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($gelombang as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Carbon\Carbon::parse($value->tgl_awal)->format('d F Y') }} - {{ Carbon\Carbon::parse($value->tgl_akhir)->format('d F Y') }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->harga }}</td>
                            <td>{{ count($value->tryout) }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $value->id }}" class="btn btn-primary daftar" data-toggle="tooltip" data-placement="top" title="Daftar">
                                    Daftar Sekarang
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Tidak ada data
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
   <script>
      const URL = `{{ url('dashboard/daftar-gelombang') }}`
      $(".daftar").on('click', function() {
         Swal.fire({
            title: 'Yakin?',
            text: "Mendaftar di gelombang ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
         }).then((result) => {
            if (result.isConfirmed) {
               let id = $(this).data('id')
               window.location.replace(`${URL}/${id}`)
            }
         })
      })
   </script>
@endsection