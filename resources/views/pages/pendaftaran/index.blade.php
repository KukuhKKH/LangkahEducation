@extends('layouts.dashboard-app')
@section('title', 'Produk / Gelombang')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Produk / Gelombang</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-xl-12 text-right">
                    <div class="btn-group btn-group-md">
                        <button type="button" class="btn btn-primary my-1" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i> Tambah Produk / Gelombang</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Nama</th>
                        <th>Gelombang</th>
                        <th>Harga</th>
                        <th>Tgl Awal</th>
                        <th>Tgl Akhir</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Nama</th>
                        <th>Gelombang</th>
                        <th>Harga</th>
                        <th>Tgl Awal</th>
                        <th>Tgl Akhir</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($gelombang as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ($value->jenis == 1) ? 'UMUM' : "SEKOLAH" }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->gelombang }}</td>
                            <td>Rp. {{ number_format($value->harga) }}</td>
                            <td>{{ Carbon\Carbon::parse($value->tgl_awal)->format('d F Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($value->tgl_akhir)->format('d F Y') }}</td>
                            <td>
                                <form action="{{ route('pendaftaran.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('pendaftaran.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Edit Gelombang">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
                                    <a href="{{ route('pendaftaran.list', $value->id) }}" class="btn btn-warning my-1" data-toggle="tooltip" data-placement="top" title="List siswa yang tergabung">
                                        <i class="fas fa-fw fa-users"></i>
                                    </a>
                                    <a href="{{ route('pendaftaran.tryout', $value->id) }}" class="btn btn-primary my-1" data-toggle="tooltip" data-placement="top" title="Integrasi tryout ke gelombang ini">
                                    <i class="fas fa-fw fa-desktop"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger my-1 hapus" data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top" title="Hapus Gelombang">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="text-center mb-3 p-5 bg-light">
                                    <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                    <h6>Tidak Ada Gelombang/Batch</h6>
                                </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Nama Batch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pendaftaran.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Jenis Gelombang</label>
                            <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" autocomplete="off">
                                <option value="1" {{ (old('jenis') == 1) ? 'selected' : '' }}>Umum</option>
                                <option value="2" {{ (old('jenis') == 2) ? 'selected' : '' }}>Sekolah</option>
                            </select>
                            @error('jenis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Nama Gelombang</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Gelombang" value="{{ old('nama') }}">
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Harga</label>
                            <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Masukkan Harga Gelombang" value="{{ old('harga') }}">
                            @error('harga')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
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
    <script src="{{ asset('assets/vendor/autoNumeric.js') }}"></script>
    <script>
        $.fn.datepicker.defaults.format = "dd/mm/yyyy"
        $('#tgl_awal').datepicker()
        $('#tgl_akhir').datepicker()

        $('#harga').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            aSign: 'Rp. '
        })

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