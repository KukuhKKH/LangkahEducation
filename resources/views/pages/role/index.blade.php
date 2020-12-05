@extends('layouts.dashboard-app')
@section('title', 'Role')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Role & Attach Permission</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-xl-6">
                    <h6 class="m-0 font-weight-bold text-primary">Role</h6>
                </div>
                <div class="col-xl-6 text-right">
                    <div class="btn-group btn-group-md mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRole"><i class="fa fa-plus"></i> Tambah Role</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        <th>Total Permission</th>
                        <th>Jumlah user</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        <th>Total Permission</th>
                        <th>Jumlah user</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($role as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ count($value->permissions()->get()) }}</td>
                            <td>{{ count($value->users) }}</td>
                            <td>
                                <form action="{{ route('role.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('role.edit', $value->id) }}" class="btn btn-success my-1"><i class="fas fa-fw fa-edit"></i></a>
                                    <a href="{{ route('permission.attach', $value->id) }}" class="btn btn-info my-1"><i class="fas fa-fw fa-eye"></i></a>
                                    <button type="button" class="btn btn-danger hapus my-1" data-id="{{ $value->id }}"><i class="fas fa-fw fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="text-center mb-3 p-5 bg-light">
                                    <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                    <h6>Tidak Ada Role</h6>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $role->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('role.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Role</label>
                            <input type="text" class="form-control" name="role" placeholder="Masukkan Role">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
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
         text: "Ingin menghapus role ini!",
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