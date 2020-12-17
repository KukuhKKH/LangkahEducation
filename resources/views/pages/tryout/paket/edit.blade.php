@extends('layouts.dashboard-app')
@section('title', "Paket Try out - ".$paket->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Edit Paket Try out - {{ $paket->nama }}</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit Soal Try out - {{ $paket->nama }}</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12 text-center mb-3">
               @if ($paket->image)
                  <img src="{{ asset('upload/paket-tryout/'.$paket->image) }}" alt="{{ $paket->nama }}" class="img-fluid" width="200px" >
               @else
                <img class="img-fluid" width="200px" src="{{ asset("assets/img/default-tryout.svg") }}"
                    alt="foto-{{ $paket->nama }}">
                @endif
            </div>
        </div>
        <form action="{{ route('paket.update', $paket->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="">Nama Paket</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                    placeholder="Pembahaasan" value="{{ $paket->nama }}" required>
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
                            placeholder="Tanggal Awal" value="{{ date('d/m/Y', strtotime($tgl_awal[0])) }}" required>
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
                            placeholder="Tanggal Akhir" value="{{ date('d/m/Y', strtotime($tgl_akhir[0])) }}" required>
                        @error('tgl_akhir')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jam_awal">Jam Awal</label>
                        <input name="jam_awal" id="jam-awal" type="text"
                            class="datepicker form-control form-control-user @error('jam_awal') is-invalid @enderror"
                            placeholder="Jam Awal" value="{{ $tgl_awal[1] }}" required>
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
                            placeholder="Jam Akhir" value="{{ $tgl_akhir[1] }}" required>
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
                        <select name="status" class="form-control @error('status') is-invalid @enderror"
                            autocomplete="off">
                            <option value="1" {{ $paket->status == 1 ? 'selected': '' }}>Aktif</option>
                            <option value="0" {{ $paket->status == 0 ? 'selected': '' }}>Tidak Aktif</option>
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
            <div class="text-right">
                <a href="{{ url()->previous() }}" type="button" class="btn btn-dark">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
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

    $('#jam-awal').clockpicker({
        autoclose: true,
    });
    $('#jam-akhir').clockpicker({
        autoclose: true,
    });

    $("#thumbPaket").change(function() {
        if(this.files[0].size > 2097152){
            alert("Maaf Gambar Kamu Terlalu Besar");
            $("#thumbPaket").val('');
        }
    });
</script>
@endsection
