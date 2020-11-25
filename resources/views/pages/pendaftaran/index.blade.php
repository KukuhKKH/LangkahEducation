@extends('layouts.dashboard-app')
@section('title', 'Pendaftaran / Gelombang')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Pendaftaran / Gelombang</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Pendaftaran / Gelombang</h6>
                <div class="btn-group btn-group-md mb-3">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i> Tambah Gelombang</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Gelombang</th>
                        <th>Tgl Awal</th>
                        <th>Tgl Akhir</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Gelombang</th>
                        <th>Tgl Awal</th>
                        <th>Tgl Akhir</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($gelombang as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->gelombang }}</td>
                            <td>{{ Carbon\Carbon::parse($value->tgl_awal)->format('d F Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($value->tgl_akhir)->format('d F Y') }}</td>
                            <td>
                                <form action="{{ route('pendaftaran.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('pendaftaran.edit', $value->id) }}" class="btn btn-success">Edit</a>
                                    <a href="#" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Integrasi tryout ke gelombang ini">
                                    <i class="fas fa-fw fa-desktop"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger hapus" data-id="{{ $value->id }}">Hapus</button>
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
                {{ $gelombang->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pendaftaran.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Gelombang</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Gelombang" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Kode Gelombang</label>
                            <input type="text" class="form-control @error('kode_referal') is-invalid @enderror" name="kode_referal" placeholder="Masukkan Kode Gelombang" value="{{ old('kode_referal') }}">
                        </div>
                        <div class="form-group">
                            <label for="tgl_awal">Tanggal Awal</label>
                            <input name="tgl_awal" id="tgl_awal" type="text" class="datepicker form-control form-control-user @error('tgl_awal') is-invalid @enderror" placeholder="Tanggal Awal" value="{{ old('tgl_awal') }}" value="{{ old('tgl_akhir') }}" required>
                            @error('tgl_awal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal Akhir</label>
                            <input name="tgl_akhir" id="tgl_akhir" type="text" class="datepicker form-control form-control-user @error('tgl_akhir') is-invalid @enderror" placeholder="Tanggal Akhir" value="{{ old('tgl_akhir') }}" required>
                            @error('tgl_akhir')
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
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $.fn.datepicker.defaults.format = "dd/mm/yyyy"
        $('#tgl_awal').datepicker()
        $('#tgl_akhir').datepicker()

        $("#tgl_awal").change(function() {
            var dateAwal = $("#dateAwal").val();
        }).on('changeDate', function(e) {
            var tanggal = new Date(e.date.valueOf());
            $("#tgl_akhir").datepicker('setStartDate', tanggal);
        })

        $(".hapus").on('click', function() {
            Swal.fire({
                title: 'Yakin?',
                text: "Ingin menghapus Gelombang ini!",
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