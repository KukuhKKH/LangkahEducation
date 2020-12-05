@extends('layouts.dashboard-app')
@section('title', 'Edit '.$pendftaran->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Update Gelombang</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Gelombang - {{ $pendftaran->nama }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('pendaftaran.update', $pendftaran->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="row">
            <div class="col-6">
               <div class="form-group">
                  <label for="">Nama</label>
                  <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $pendftaran->nama }}" placeholder="Nama Gelombang">
                  @error('nama')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Kode Referal</label>
                  <input type="text" name="kode_referal" class="form-control @error('kode_referal') is-invalid @enderror" value="{{ $pendftaran->kode_referal }}" placeholder="Kode Referal">
                  @error('kode_referal')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="tgl_awal">Tanggal Awal</label>
                  <input name="tgl_awal" id="tgl_awal" type="text" class="datepicker form-control form-control-user @error('tgl_awal') is-invalid @enderror" placeholder="Tanggal Awal" value="{{ date('d/m/Y', strtotime($pendftaran->tgl_awal)) }}" required>
                  @error('tgl_awal')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="tgl_akhir">Tanggal Akhir</label>
                  <input name="tgl_akhir" id="tgl_akhir" type="text" class="datepicker form-control form-control-user @error('tgl_akhir') is-invalid @enderror" placeholder="Tanggal Akhir" value="{{ date('d/m/Y', strtotime($pendftaran->tgl_akhir)) }}" required>
                  @error('tgl_akhir')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
                  <label for="">Biaya Pendaftaran</label>
                  <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Masukkan Harga Gelombang" value="{{ $pendftaran->harga }}">
                  @error('harga')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
               </div>
            </div>
         </div>
         <div class="text-right">
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
         </div>
      </form>
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