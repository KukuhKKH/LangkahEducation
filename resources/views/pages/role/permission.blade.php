@extends('layouts.dashboard-app')
@section('title', 'Permission')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-xl-6">
                    <h6 class="m-0 font-weight-bold text-primary">Permission</h6>
                </div>
                <div class="col-xl-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPermission"><i class="fa fa-plus"></i> Tambah Permission</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="GET">
                <div class="row mb-4 justify-content-end align-items-center">
                    <div class="col-xl-5">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Masukkan Nama Permission" aria-label="Masukkan Nama Permission" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                         </div>
                    </div>
                    <div class="col-xl-auto">
                      <a href="{{ route('role.permission') }}" class="btn btn-lght text-danger my-1">Refresh</a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Permission</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Permission</th>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($permission as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                                <form action="{{ route('permission.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('permission.edit', $value->id) }}" class="btn btn-success my-1"><i class="fas fa-fw fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger hapus my-1" data-id="{{ $value->id }}"><i class="fas fa-fw fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $permission->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('permission.create') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Total Permission</label>
                            <input type="number" min="0" class="form-control" name="total" placeholder="Total Permission">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
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
         text: "Ingin menghapus permission ini!",
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