@extends('layouts.dashboard-app')
@section('title', 'Siswa')

@section('content')
    <div class="row">
        <div class="col-10">
            <h1 class="h3 mb-4 text-gray-800">Siswa</h1>
        </div>
        <div class="col-2 text-right">
            <a href="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel</a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            @hasanyrole('admin|superadmin')

                <div class="row">
                    <div class="col-8">
                        <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="mr-2 d-flex align-items-center">
                                        Import Data Excel 
                                    </div>
                                    <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-4 text-right">
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus-circle"></i> Tambah Siswa</button>
                        </div>
                    </div>
                </div>
            @endhasanyrole
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
                            <td colspan="6" class="text-center">
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('role.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName" placeholder="Nama Lengkap" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Alamat Email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <input name="nisn" type="number" class="form-control form-control-user @error('nisn') is-invalid @enderror" placeholder="NSIN" value="{{ old('nisn') }}">
                                    @error('nisn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="asal_sekolah">Asal Sekolah</label>
                                    <input name="asal_sekolah" type="text" class="form-control form-control-user @error('asal_sekolah') is-invalid @enderror" placeholder="Asal Sekolah" value="{{ old('asal_sekolah') }}">
                                    @error('asal_sekolah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nomor_hp">Nomor HP</label>
                                    <input name="nomor_hp" type="number" class="form-control form-control-user @error('nomor_hp') is-invalid @enderror" placeholder="Nomer HP Aktif" value="{{ old('nomor_hp') }}">
                                    @error('nomor_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input name="tanggal_lahir" type="text" class="datepicker form-control form-control-user @error('tanggal_lahir') is-invalid @enderror" placeholder="Tanggal Lahir" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" class="form-control form-control-user" disabled value="123456">
                            <small>Password Default</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $.fn.datepicker.defaults.format = "dd/mm/yyyy"
        $('.datepicker').datepicker();
    </script>
@endsection