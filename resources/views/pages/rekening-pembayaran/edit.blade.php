@extends('layouts.dashboard-app')
@section('title', 'Edit '.$bank->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Edit - Metode Pembayaran</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">Metode Pembayaran - {{ $bank->nama }}</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="{{ route('rekening.update', $bank->id) }}" id="form" method="post" enctype="multipart/form-data">
         @csrf
         @method("PUT")
         <div class="form-group">
            <label for="nama">Bank/Instansi Asal</label>
            <input name="nama" type="text" class="form-control form-control-user @error('nama') is-invalid @enderror"
               id="namaBank" placeholder="Nama Bank/Instansi" value="{{ $bank->nama }}" required>
            @error('nama')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="nomer_rekening">Nomor Rekening <small data-toggle="tooltip" title="Beri Nilai 0 Jika Pembayaran Upload Story" data-placement="right" ><i class="fa fa-info-circle"></i></small></label>
            <input name="nomer_rekening" type="text"
               class="form-control form-control-user @error('nomer_rekening') is-invalid @enderror" id="nomorRekening"
               placeholder="Nomor Rekening" value="{{ $bank->nomer_rekening }}" required>
            @error('nomer_rekening')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="alias">Nama Pemilik (a/n) <small data-toggle="tooltip" title="Tulis Nama Akun Jika Pembayaran Upload Story" data-placement="right" ><i class="fa fa-info-circle"></i></small></label>
            <input name="alias" type="text" class="form-control form-control-user @error('alias') is-invalid @enderror"
               id="nomorRekening" placeholder="Nama Pemilik (a/n)" value="{{ $bank->alias }}" required>
            @error('alias')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
            </span>
            @enderror
         </div>
         <div class="form-group">
            <label for="bayar">Jenis Pembayaran <small data-toggle="tooltip" title="Gratis jika Upload Story" data-placement="right"><i class="fa fa-info-circle"></i></small></label>
            <select name="bayar" class="form-control form-control-user @error('bayar') is-invalid @enderror" id="exampleFormControlSelect1">
               <option value="1" {{ ($bank->bayar == 1) ? 'selected' : '' }}>Berbayar</option>
               <option value="0" {{ ($bank->bayar == 0) ? 'selected' : '' }}>Gratis</option>
              </select>
              @error('bayar')
              <span class="invalid-feedback" role="alert">
                 <strong>{{ $message }}</strong>
              </span>
              @enderror
        </div>
         <div class="form-group">
            <label for="name">Logo <small>Ukuran Maksimal 500Kb</small> <small data-toggle="tooltip" title="Ukuran Bank : 1600x80 Ukuran Poster : 1080x1080" data-placement="right" ><i class="fa fa-info-circle"></i></small></label>
               <div class="input-group">
                  <div class="custom-file">
                     <input type="file" name="file" class="custom-file-input" id="inputFile" accept="image/*">
                     <label class="custom-file-label" id="labelFile" for="inputGroupFile02">Choose file</label>
                  </div>
               </div>
         </div>
         <div class="mt-3 text-right">
            <button type="button" class="btn btn-dark" data-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-success">Simpan</button>
         </div>
      </form>
   </div>
</div>
@endsection

@section('js')
<script type="application/javascript">
   $('input[type="file"]').change(function(e){
       var fileName = e.target.files[0].name;
       $('.custom-file-label').html(fileName);
   });
   $("#inputFile").change(function() {
        if(this.files[0].size > 524000){
            alert("Maaf Foto Kamu Terlalu Besar");
            $("#inputFile").val('');
            $("#labelFile").text('Choose file');
        }
    });
</script>
@endsection