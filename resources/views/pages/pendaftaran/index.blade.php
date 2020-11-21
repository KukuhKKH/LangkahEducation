@extends('layouts.dashboard-app')
@section('title', 'Pendaftaran / Gelombang')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Pendaftaran / Gelombang</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Pendaftaran / Gelombang</h6>
                <div class="btn-group btn-group-md mb-3">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i> Tambah Gelombang</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Gelombang</th>
                        <th>Status</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Gelombang</th>
                        <th>Status</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($gelombang as $value)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $value->nama }}</td>
                           <td>{{ $value->gelombang }}</td>
                           <td>
                              @if ($value->status)
                                 <span class="badge badge-success p-2">Aktif</span>
                              @else
                                 <span class="badge badge-danger p-2">Tidak Aktif</span>
                              @endif
                           </td>
                           <td>
                              <form action="{{ route('pendaftaran.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                 @csrf
                                 @method('DELETE')
                                 <a href="#" class="btn btn-success">Edit</a>
                                 <button type="button" class="btn btn-danger hapus" data-id="{{ $value->id }}">Hapus</button>
                              </form>
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
                {{ $gelombang->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pendaftaran.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Role</label>
                            <input type="text" class="form-control" name="role" placeholder="Masukkan Role">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script>
   $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus pendaftaran ini!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Tidak',
         confirmButtonText: 'Ya!'
      }).then((result) => {
         if (result.isConfirmed) {
            let id = $(this).data('id')
            $(`#form-${id}`).submit()
         }
      })
   })
</script>
@endsection