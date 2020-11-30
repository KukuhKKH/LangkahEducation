@extends('layouts.dashboard-app')
@section('title', 'Sekolah')

@section('content')
    <div class="row">
        <div class="col-8">
            <h1 class="h3 mb-4 text-gray-800">Sekolah</h1>
        </div>
        <div class="col-4 text-right">
            <a href="{{ asset('template/TemplateSekolah.xlsx') }}" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel</a>
            <a href="{{ asset('template/TemplateNISNSiswa.xlsx') }}" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel NISN Siswa</a>
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
                                        <button type="submit" class="input-group-text" id="">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-4 text-right">
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus-circle"></i> Tambah Sekolah</button>
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
                        <th>Nama Sekolah</th>
                        <th>Email</th>
                        <th>Total siswa yang terdaftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Sekolah</th>
                        <th>Email</th>
                        <th>Total siswa yang terdaftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($sekolah as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->user->name }}</td>
                                <td>{{ $value->user->email }}</td>
                                <td>{{ count($value->siswa) }}</td>
                                <td>{!! ($value->user->is_active == 1) ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak Aktif</div>'  !!}</td>
                                <td>
                                    <form action="{{ route('sekolah.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                        @csrf
                                        @method("DELETE")
                                        <a href="{{ route('sekolah.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- <a href="{{ route('sekolah.show', $value->id) }}" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Integrasi siswa ke sekolah ini">
                                            <i class="fa fa-user-friends"></i>
                                        </a> --}}
                                        <a href="{{ route('nisn.show', $value->id) }}" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="List NISN">
                                            <i class="fas fa-fw fa-user-friends"></i>
                                        </a>
                                        <a href="{{ route('sekolah.tryout', $value->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Integrasi tryout ke sekolah ini">
                                            <i class="fas fa-fw fa-desktop"></i>
                                        </a>
                                        <button type="button" data-id="{{ $value->id }}" class="btn btn-danger hapus" data-toggle="tooltip" data-placement="top" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
                {{ $sekolah->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Sekolah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sekolah.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Sekolah</label>
                            <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName" placeholder="Nama Sekolah" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Alamat Email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="alamat">Alamat Sekolah</label>
                                    <input name="alamat" type="text" class="form-control form-control-user @error('alamat') is-invalid @enderror" placeholder="Alamat Sekolah" value="{{ old('alamat') }}" required>
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="kode_referal">Kode Referal <small style="color: red">Kosongkan untuk generate kode referal</small></label>
                                    <input name="kode_referal" type="text" class="form-control form-control-user @error('kode_referal') is-invalid @enderror" placeholder="Kode Referal Sekolah" value="{{ old('kode_referal') }}">
                                    @error('kode_referal')
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">DAFTAR NISN Siswa <small>Opsional</small></label>
                                    <input type="file" class="form-control" name="nisn">
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Logo Sekolah <small>Opsional</small></label>
                                    <input type="file" class="form-control" name="foto">
                                 </div>
                            </div>
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
        $(".hapus").on('click', function() {
            Swal.fire({
                title: 'Yakin?',
                text: "Ingin menghapus sekolah ini!",
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