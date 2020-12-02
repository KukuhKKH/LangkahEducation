@extends('layouts.dashboard-app')
@section('title', "Paket Try out")

@section('content')
<h1 class="h3 mb-2 text-gray-800">Paket Try out</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information
    about DataTables, please visit the</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Paket Try out</h6>
            <div class="btn-group btn-group-md mb-3">
                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                    data-target="#modalData"><i class="fa fa-plus"></i> Tambah Paket</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Status</th>
                        <th>Total Soal Tryout</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Status</th>
                        <th>Total Soal Tryout</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse($paket as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>
                            @if ($value->status)
                            <span class="badge badge-success p-2">Aktif</span>
                            @else
                            <span class="badge badge-danger p-2">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ count($value->soal) }}</td>
                        <td>
                            <form action="{{ route('paket.destroy', $value->id) }}" method="POST"
                                id="form-{{ $value->id }}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('paket.edit', $value->id) }}" class="btn btn-success"
                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('soal.show', $value->slug) }}" class="btn btn-warning text-dark">
                                    <i class="fas fa-plus"></i> Soal Tryout
                                </a>
                                <button type="button" class="btn btn-danger hapus" data-id="{{ $value->id }}"
                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $paket->appends($data)->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Paket Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('paket.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Paket Soal</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            placeholder="Masukkan Nama Paket Soal">
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_awal">Tanggal Awal</label>
                                <input name="tgl_awal" id="tgl_awal" type="text"
                                    class="datepicker form-control form-control-user @error('tgl_awal') is-invalid @enderror"
                                    placeholder="Tanggal Awal" value="{{ old('tgl_akhir') }}" required>
                                @error('tgl_awal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_akhir">Tanggal Akhir</label>
                                <input name="tgl_akhir" id="tgl_akhir" type="text"
                                    class="datepicker form-control form-control-user @error('tgl_akhir') is-invalid @enderror"
                                    placeholder="Tanggal Akhir" value="{{ old('tgl_akhir') }}" required>
                                @error('tgl_akhir')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_awal">Jam Awal</label>
                                <input name="jam_awal" id="jam-awal" type="text"
                                    class="datepicker form-control form-control-user @error('jam_awal') is-invalid @enderror"
                                    placeholder="Jam Awal" value="{{ old('jam_awal') }}" required>
                                @error('jam_awal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_akhir">Jam Akhir</label>
                                <input name="jam_akhir" id="jam-akhir" type="text"
                                    class="datepicker form-control form-control-user @error('jam_akhir') is-invalid @enderror"
                                    placeholder="Jam Akhir" value="{{ old('jam_akhir') }}" required>
                                @error('jam_akhir')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/clockpicker/clockpicker.css') }}">
@endsection

@section('js')
<script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/clockpicker/clockpicker.js') }}"></script>
<script>
    $.fn.datepicker.defaults.format = "dd/mm/yyyy"
    $('#tgl_awal').datepicker()
    $('#tgl_akhir').datepicker()

    $("#tgl_awal").change(function () {
        var dateAwal = $("#dateAwal").val();
    }).on('changeDate', function (e) {
        var tanggal = new Date(e.date.valueOf());
        $("#tgl_akhir").datepicker('setStartDate', tanggal);
    })

    $(".hapus").on('click', function () {
        Swal.fire({
            title: 'Yakin?',
            text: "Ingin menghapus paket ini!",
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
<script>
    $('#jam-awal').clockpicker({
        autoclose: true,
    });
    $('#jam-akhir').clockpicker({
        autoclose: true,
    });

</script>
@endsection
