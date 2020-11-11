@extends('layouts.dashboard-app')
@section('title', 'Siswa')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Siswa</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @hasanyrole('sekolah')
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="file" class="form-control" placeholder="File Excel">
                        </div>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-success">Import</button>
                        <a href="" class="btn btn-warning">Template Excel</a>
                    </div>
                </div>
            </form>
            @endhasanyrole
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Siswa</h6>
                <div class="btn-group btn-group-md">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i> Tambah Siswa</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Asal Sekolah</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Asal Sekolah</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($siswa as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->nisn }}</td>
                            <td>{{ $value->asal_sekolah }}</td>
                            <td>{{ $value->user->name }}</td>
                            <td>{!! ($value->user->is_active == 1) ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak Aktif</div>'  !!}</div>
                            <td>
                                <form action="{{ route('siswa.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method("DELETE")
                                    <a href="{{ route('siswa.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" data-id="{{ $value->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
                {{ $siswa->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('siswa.store') }}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nama Siswa</label>
                                    <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Siswa">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="name" placeholder="Masukkan Email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">NISN</label>
                                    <input type="text" class="form-control" name="nisn" placeholder="Masukkan NISN">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Asal Sekolah</label>
                                    <input type="text" class="form-control" name="asal_sekolah" placeholder="Masukkan Asal Sekolah">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tanggal Lahir</label>
                                    <input name="tanggal_lahir" type="text" class="datepicker form-control" placeholder="Tanggal Lahir"></div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nomer HP</label>
                                    <input type="text" class="form-control" name="nomor_hp" placeholder="Masukkan Nomer HP">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="">Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                             </div>
                             <div class="col-6">
                                <label for="">Konfirmasi Password</label>
                                <input type="password" class="form-control" placeholder="Konfirmasi Password" name="password_confirmation" id="password_confirmation">
                             </div>
                             <div class="col-12">
                                <div class="form-group">
                                    <label for="">Foto <small>Opsional</small></label>
                                    <input type="file" class="form-control" name="foto">
                                 </div>
                             </div>
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
    <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $.fn.datepicker.defaults.format = "dd/mm/yyyy"
        $('.datepicker').datepicker()

        $("#form").on('submit', function(e) {
            if($("#password_confirmation").val() != $("#password").val()) {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password konfirmasi tidak sama',
                })
                return false
            }
            if($("#password").val().length < 8) {
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

        $(".hapus").on('click', function() {
            Swal.fire({
                title: 'Yakin?',
                text: "Ingin menghapus admin ini!",
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

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection