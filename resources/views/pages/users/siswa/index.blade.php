@extends('layouts.dashboard-app')
@section('title', 'Siswa')

@section('content')
<div class="row mb-4">
    <div class="col-xl-8">
        <h1 class="h3 mb-4 text-gray-800">Siswa</h1>
    </div>
    <div class="col-xl-4 text-right">
        <a href="{{ asset('template/TemplateSiswa.xlsx') }}" download="" class="btn btn-success"><i
                class="fas fa-fw fa-file-excel"></i> Template Excel</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i
                    class="fas fa-fw fa-plus"></i> Tambah Siswa</button>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header">
        @hasanyrole('admin|superadmin')
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('siswa.import') }}" method="POST" id="form-import" enctype="multipart/form-data">
                    @csrf
                    @hasanyrole('superadmin|admin')
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="">Sekolah</label>
                                <select name="sekolah" id="sekolah-select" class="form-control" required>
                                    @foreach ($sekolah as $item)
                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="">Import Data Excel</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input" id="inputGroupFile02"
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                            required>
                                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                    </div>
                                    <div class="input-group-append" id="btn-submit">
                                        <button type="submit" class="input-group-text">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endhasanyrole
                </form>
            </div>
        </div>
        @endhasanyrole
    </div>
    <div class="card-body">
        <form action="" method="get">
            <div class="row mb-4 ">
                <div class="col-xl-3">
                    <select name="q" class="form-control my-1">
                        <option value="nisn">NISN</option>
                        <option value="nama">Nama</option>
                        <option value="asal">Asal Sekolah</option>
                    </select>
                </div>
                <div class="col-xl-6">
                    <input type="text" class="form-control my-1" name="keyword" placeholder="Masukkan Kata Kunci">
                </div>
                <div class="col-xl-3">
                    <button type="submit" class="btn btn-primary my-1">Cari</button>
                    <a href="{{ route('siswa.index') }}" class="btn btn-lght text-danger my-1">Reset Filter</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th  width="50%">Nama Siswa</th>
                        <th>Asal Sekolah</th>
                        <th>Status</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th width="50%">Nama Siswa</th>
                        <th>Asal Sekolah</th>
                        <th>Status</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($siswa as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->nisn }}</td>
                        <td>{{ $value->user->name }}</td>
                        <td>{{ $value->asal_sekolah }}</td>
                        <td>{!! ($value->user->is_active == 1) ? '<div class="badge badge-success">Aktif</div>' : '<div
                                class="badge badge-danger">Tidak Aktif</div>' !!}
        </div>
        <td>
            <form action="{{ route('siswa.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                @csrf
                @method("DELETE")
                <a href="{{ route('siswa.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip"
                    data-placement="top" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" data-id="{{ $value->id }}" class="btn btn-danger my-1 hapus" data-toggle="tooltip"
                    data-placement="top" title="Hapus">
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
                    <h6>Tidak Ada Data Siswa</h6>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>
        </table>
        {{ $siswa->appends($data)->links() }}
    </div>
</div>
</div>

<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('siswa.store') }}" method="post" id="form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input name="name" type="text"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    id="exampleFirstName" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="email"
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="exampleInputEmail" placeholder="Alamat Email" value="{{ old('email') }}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group only-number">
                                <label for="nisn">NISN</label>
                                <input name="nisn" type="text" minlength="10" maxlength="11"
                                    class="form-control number form-control-user @error('nisn') is-invalid @enderror"
                                    placeholder="NISN" value="{{ old('nisn') }}" required>
                                @error('nisn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="asal_sekolah">Asal Sekolah</label>
                                <input name="asal_sekolah" type="text"
                                    class="form-control form-control-user @error('asal_sekolah') is-invalid @enderror"
                                    placeholder="Asal Sekolah" value="{{ old('asal_sekolah') }}" required>
                                @error('asal_sekolah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group only-number">
                                <label for="nomor_hp">Nomor HP</label>
                                <input name="nomor_hp" type="text" minlength="10" maxlength="13"
                                    class="form-control number form-control-user @error('nomor_hp') is-invalid @enderror"
                                    placeholder="Nomer HP Aktif" value="{{ old('nomor_hp') }}" required>
                                @error('nomor_hp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input name="tanggal_lahir" type="text"
                                    class="datepicker form-control form-control-user @error('tanggal_lahir') is-invalid @enderror"
                                    placeholder="Tanggal Lahir" value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <small class="text-danger">*Password Default sama dengan NISN</small>
                        {{-- <input name="password" class="form-control form-control-user" disabled value="123456">
                            <small>Password Default</small> --}}
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
<script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>
<script>
    $.fn.datepicker.defaults.format = "dd/mm/yyyy"
    $('.datepicker').datepicker()

    $('#sekolah-select').select2({
        tags: true
    })

    $(".hapus").on('click', function () {
        Swal.fire({
            title: 'Yakin?',
            text: "Ingin menghapus siswa ini!",
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
    });

</script>
<script type="application/javascript">
    $('input[type="file"]').change(function (e) {
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endsection
