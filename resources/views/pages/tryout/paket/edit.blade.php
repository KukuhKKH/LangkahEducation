@extends('layouts.dashboard-app')
@section('title', "Paket Try out - ".$paket->nama)

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Edit Paket Try out - {{ $paket->nama }}</h1>
   <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

   <div class="card shadow mb-4">
      <div class="card-header py-3">
          <div class="d-flex justify-content-between mb-1">
          <h6 class="m-0 font-weight-bold text-primary">Edit Soal Try out - {{ $paket->nama }}</h6>
          </div>
      </div>
      <div class="card-body">
         <form action="{{ route('paket.update', $paket->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
               <label for="">Nama Paket</label>
               <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Pembahaasan" value="{{ $paket->nama }}" required>
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
                       <input name="tgl_awal" id="tgl_awal" type="text" class="datepicker form-control form-control-user @error('tgl_awal') is-invalid @enderror" placeholder="Tanggal Awal" value="{{ date('d/m/Y', strtotime($paket->tgl_awal)) }}" required>
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
                       <input name="tgl_akhir" id="tgl_akhir" type="text" class="datepicker form-control form-control-user @error('tgl_akhir') is-invalid @enderror" placeholder="Tanggal Akhir" value="{{ date('d/m/Y', strtotime($paket->tgl_akhir)) }}" required>
                       @error('tgl_akhir')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                   </div>
               </div>
           </div>
            <div class="form-group">
               <label for="">Status</label>
               <select name="status" class="form-control @error('status') is-invalid @enderror" autocomplete="off">
                  <option value="1" {{ $paket->status == 1 ? 'selected': '' }}>Aktif</option>
                  <option value="0" {{ $paket->status == 0 ? 'selected': '' }}>Tidak Aktif</option>
               </select>
               @error('status')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
            <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary" >Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
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
</script>
@endsection