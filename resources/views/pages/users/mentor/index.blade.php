@extends('layouts.dashboard-app')
@section('title', 'Mentor')

@section('content')
    <div class="row mb-2">
        <div class="col-xl-10">
            <h1 class="h3 mb-4 text-gray-800">Mentor</h1>
        </div>
        <div class="col-xl-2 text-right">
            <a href="{{ asset('template/TemplateMentor.xlsx') }}" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel</a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            @hasanyrole('admin|superadmin')
                <div class="row align-items-center">
                    <div class="col-xl-8">
                        <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="">Import Data Excel</label>
                                <div class="input-group">
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
                    <div class="col-xl-4 text-right">
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus"></i> Tambah Mentor</button>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Total Siswa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Total Siswa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        @forelse ($mentor as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->user->name }}</td>
                                <td>{{ $value->user->email }}</td>
                                <td>{{ count($value->siswa) }}</td>
                                <td>{!! ($value->user->is_active == 1) ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak Aktif</div>'  !!}</div>
                                <td>
                                    <form action="{{ route('mentor.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                        @csrf
                                        @method("DELETE")
                                        <a href="{{ route('mentor.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('mentor.show', $value->id) }}" class="btn btn-secondary my-1" data-toggle="tooltip" data-placement="top" title="Integrasi siswa ke mentor ini">
                                            <i class="fa fa-user-friends"></i>
                                        </a>
                                        <button type="button" data-id="{{ $value->id }}" class="btn btn-danger my-1 hapus" data-toggle="tooltip" data-placement="top" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="text-center mb-3 p-5 bg-light">
                                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                        <h6>Tidak Ada Data Mentor</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $mentor->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Mentor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('mentor.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Mentor</label>
                            <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleFirstName" placeholder="Nama Mentor" value="{{ old('name') }}">
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
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                    <input name="pendidikan_terakhir" type="text" class="form-control form-control-user @error('pendidikan_terakhir') is-invalid @enderror" placeholder="Pendidikan Terakhir" value="{{ old('pendidikan_terakhir') }}">
                                    @error('pendidikan_terakhir')
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
    <script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>
    <script>
        $(".hapus").on('click', function() {
            Swal.fire({
                title: 'Yakin?',
                text: "Ingin menghapus mentor ini!",
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
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endsection