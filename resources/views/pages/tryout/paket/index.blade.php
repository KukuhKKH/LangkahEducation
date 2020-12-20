@extends('layouts.dashboard-app')
@section('title', "Paket Try out")

@section('content')
<h1 class="h3 mb-4 text-gray-800">Paket Try out</h1>


<div class="card shadow mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bold text-primary">Paket Try out</h6>
            <div class="btn-group btn-group-md">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i
                        class="fa fa-plus"></i> Tambah Paket</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="GET">
            <div class="row mb-4 justify-content-end align-items-center">
                <div class="col-xl-5">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Masukkan Paket Soal" aria-label="Masukkan Paket Soal" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                     </div>
                </div>
                <div class="col-xl-auto">
                  <a href="{{ route('paket.index') }}" class="btn btn-lght text-danger my-1">Refresh</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Status</th>
                        <th>Total Soal Tryout</th>
                        <th width="30%">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Status</th>
                        <th>Total Soal Tryout</th>
                        <th width="30%">Aksi</th>
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
                                <a href="{{ route('paket.edit', $value->id) }}" class="btn btn-success my-1"
                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('paket.soal.detail', $value->id) }}" class="btn btn-primary my-1"
                                    data-toggle="tooltip" data-placement="top" title="Lihat Semua Soal">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('soal.show', $value->slug) }}" class="btn btn-warning text-dark my-1"
                                    data-toggle="tooltip" data-placement="top" title="Tambah Soal">
                                    <i class="fas fa-plus"></i>
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
                        <td colspan="5" class="text-center">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Paket Soal</h6>
                            </div>
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
            <form action="{{ route('paket.store') }}" method="post" enctype="multipart/form-data">
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

                        {{-- Iki ASU --}}

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="poin_1">Point 1</label>
                                <input name="poin_1" type="number"
                                    class="form-control form-control-user @error('poin_1') is-invalid @enderror"
                                    placeholder="Nilai Point 1" value="{{ old('poin_1') }}" required>
                                @error('poin_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="poin_2">Point 2</label>
                                <input name="poin_2" type="number"
                                    class="form-control form-control-user @error('poin_2') is-invalid @enderror"
                                    placeholder="Nilai Point 2" value="{{ old('poin_2') }}" required>
                                @error('poin_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="poin_3">Point 3</label>
                                <input name="poin_3" type="number"
                                    class="form-control form-control-user @error('poin_3') is-invalid @enderror"
                                    placeholder="Nilai Point 3" value="{{ old('poin_3') }}" required>
                                @error('poin_3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="poin_4">Point 4</label>
                                <input name="poin_4" type="number"
                                    class="form-control form-control-user @error('poin_4') is-invalid @enderror"
                                    placeholder="Nilai Point 4" value="{{ old('poin_4') }}" required>
                                @error('poin_4')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url_youtube_saintek">Url Youtube Saintek</label>
                                <input name="url_youtube_saintek" type="text"
                                    class="form-control form-control-user @error('url_youtube_saintek') is-invalid @enderror"
                                    placeholder="Url Youtube Saintek" value="{{ old('url_youtube_saintek') }}" required>
                                @error('url_youtube_saintek')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url_youtube_soshum">Url Youtube Soshum</label>
                                <input name="url_youtube_soshum" type="text"
                                    class="form-control form-control-user @error('url_youtube_soshum') is-invalid @enderror"
                                    placeholder="Url Youtube Soshum" value="{{ old('url_youtube_soshum') }}" required>
                                @error('url_youtube_soshum')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="interpretasi_1">Interpretasi 1</label>
                                <input name="interpretasi_1" type="text"
                                    class="form-control form-control-user @error('interpretasi_1') is-invalid @enderror"
                                    placeholder="Interpretasi 1" value="{{ old('interpretasi_1') }}" required>
                                @error('interpretasi_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="interpretasi_2">Interpretasi 2</label>
                                <input name="interpretasi_2" type="text"
                                    class="form-control form-control-user @error('interpretasi_2') is-invalid @enderror"
                                    placeholder="Interpretasi 2" value="{{ old('interpretasi_2') }}" required>
                                @error('interpretasi_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="interpretasi_3">Interpretasi 3</label>
                                <input name="interpretasi_3" type="text"
                                    class="form-control form-control-user @error('interpretasi_3') is-invalid @enderror"
                                    placeholder="Interpretasi 3" value="{{ old('interpretasi_3') }}" required>
                                @error('interpretasi_3')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Iki ASU --}}
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="testimonial">Foto <small>Maksimal 2 Mb</small></label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                      <input id="thumbPaket" type="file"  accept="image/*" name="foto" class="custom-file-input form-control form-control-user @error('foto') is-invalid @enderror" id="inputGroupFile02" accept="image/x-png,image/gif,image/jpeg">
                                      <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                    </div>
                                    @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                  </div>
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

    $("#thumbPaket").change(function() {
        if(this.files[0].size > 2097152){
            alert("Maaf Gambar Kamu Terlalu Besar");
            $("#thumbPaket").val('');
        }
    });

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
