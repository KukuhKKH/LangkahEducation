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
                <div class="btn-group btn-group-md mb-3">
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
                                <button class="btn btn-success">Edit</button>
                                <button class="btn btn-danger">Hapus</button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
