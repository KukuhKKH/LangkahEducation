@extends('layouts.dashboard-app')
@section('title', 'Superadmin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Superadmin</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-xl-6">
                <h6 class="m-0 font-weight-bold text-primary">Superadmin</h6>
            </div>
            <div class="col-xl-6 text-right">
                <div class="btn-group btn-group-md">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i
                            class="fa fa-plus"></i> Tambah Superadmin</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="GET">
            <div class="row mb-4 justify-content-end align-items-center">
                <div class="col-xl-5">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Masukkan Nama Superadmin" aria-label="Masukkan Nama Superadmin" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                     </div>
                </div>
                <div class="col-xl-auto">
                  <a href="{{ route('superadmin.index') }}" class="btn btn-lght text-danger my-1">Refresh</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($superadmin as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{!! ($value->is_active == 1) ? '<div class="badge badge-success">Aktif</div>' : '<div
                                class="badge badge-danger">Tidak Aktif</div>' !!}
                        <td>
                            @if (auth()->user()->id != $value->id)
                            <form action="{{ route('superadmin.destroy', $value->id) }}" method="POST"
                                id="form-{{ $value->id }}">
                                @csrf
                                @method("DELETE")
                                <a href="{{ route('superadmin.edit', $value->id) }}" class="btn btn-success"
                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" data-id="{{ $value->id }}" class="btn btn-danger hapus"
                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
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
            {{ $superadmin->appends($data)->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Superadmin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superadmin.store') }}" id="form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <div class="input-group" id="show_password">
                            <input type="password" class="form-control" placeholder="Password" name="password"
                            id="password">
                            <div class="input-group-addon d-flex align-items-center">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                              </div>    
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi Password</label>
                        <div class="input-group" id="show_password2">
                            <input type="password" class="form-control" placeholder="Konfirmasi Password"
                            name="password_confirmation" id="password_confirmation">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="">Foto <small>Opsional</small></label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile02">
                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                            </div>
                        </div>
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
    $("#form").on('submit', function (e) {
        if ($("#password_confirmation").val() != $("#password").val()) {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password konfirmasi tidak sama',
            })
            return false
        }
        if ($("#password").val().length < 8) {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password minimal 8 karakter',
            })
            return false
        }
        return
        e.preventDefault()
    })

    $(".hapus").on('click', function () {
        Swal.fire({
            title: 'Yakin?',
            text: "Ingin menghapus superadmin ini!",
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

<script type="application/javascript">
    $('input[type="file"]').change(function (e) {
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

</script>
<script>
    $(document).ready(function() {
    $("#show_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_password input').attr("type") == "text"){
            $('#show_password input').attr('type', 'password');
            $('#show_password2 input').attr('type', 'password');
            $('#show_password i').addClass( "fa-eye-slash" );
            $('#show_password i').removeClass( "fa-eye" );
        }else if($('#show_password input').attr("type") == "password"){
            $('#show_password input').attr('type', 'text');
            $('#show_password2 input').attr('type', 'text');
            $('#show_password i').removeClass( "fa-eye-slash" );
            $('#show_password i').addClass( "fa-eye" );
        }
    });
 });
 </script>
@endsection
