@extends('layouts.dashboard-app')
@section('title', 'Daftar Universitas')

@section('content')
<div class="row mb-4">
    <div class="col-xl-6">
        <h1 class="h3 text-gray-800">Daftar Universitas</h1>
    </div>
    <div class="col-xl-6 text-right">
         <a href="{{ asset('template/TemplateUniversitasKedua.xlsx') }}" download="" class="btn btn-success my-1"><i class="fas fa-fw fa-file-excel"></i> Template Passing Grade</a>
         <button data-toggle="modal" data-target="#modalKelompok" class="btn btn-info my-1"><i class="fa fa-eye"></i> Cek ID Kelompok Prodi</button>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('universitas.import_batch') }}" method="POST" id="form-import"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Import Data Excel</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="inputGroupFile02"
                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                    required>
                                <label class="custom-file-label" for="inputGroupFile02">Pilih FIle</label>
                            </div>
                            <div class="input-group-append" id="btn-submit">
                                <button type="submit" class="input-group-text">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="GET">
            <div class="row mb-4 justify-content-end">
                <div class="col-xl-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Masukkan Nama Universitas" aria-label="Masukkan Nama Universitas" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button">Cari</button>
                        </div>
                      </div>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Total Prodi</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Total Prodi</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($universitas as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>{{ count($value->passing_grade) }}</td>
                        <td>
                            <form action="{{ route('universitas.destroy', $value->id) }}" method="POST"
                                id="form-{{ $value->id }}">
                                @csrf
                                @method('DELETE')
                                {{-- <a href="#" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a> --}}
                                <a href="{{ route('passing-grade.show', $value->id) }}" class="btn btn-primary my-1">Lihat Prodi
                                    </a>
                                <button type="button" class="btn btn-danger my-1 hapus" data-id="{{ $value->id }}"
                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Data Universitas</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $universitas->appends($data)->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Universitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('universitas.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Universitas</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            placeholder="Masukkan Universitas">
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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

<div class="modal fade" id="modalKelompok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kelompok Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kelompok</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kelompok</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($kelompok as $value)
                            <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ Str::upper($value->nama) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    $(".hapus").on('click', function () {
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
