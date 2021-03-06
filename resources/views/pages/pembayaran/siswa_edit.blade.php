@extends('layouts.dashboard-app')
@section('title', 'Upload Pembayaran')

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Edit Pembayaran</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit Pembayaran - Gelombang {{ $pembayaran->gelombang->nama }}</h6>
             </div>
        </div>
        <div class="card-body">
           <div class="row">
              <div class="col-xl-12">
                 <form action="{{ route('pembayaran.siswa.update', $pembayaran->id) }}" method="post" enctype="multipart/form-data">
                     @csrf
                     @method('PUt')
                        <div class="form-group">
                           <label for="">Ubah Bank Tujuan</label>
                           <select name="bank_id" id="bank_id" class="form-control">
                              <option value="" disabled selected>== Ubah Bank Tujuan ==</option>
                              @foreach ($bank as $value)
                                  <option value="{{ $value->id }}">{{ $value->nama }}</option>
                              @endforeach
                           </select>
                        </div>
                           <div class="form-group">
                              <label for="">Bukti Transfer</label>
                              <div class="custom-file">
                                 <input id="buktiTransfer" type="file" class="custom-file-input form-control @error('foto') is-invalid @enderror" name="file" accept="image/x-png,image/gif,image/jpeg" id="inputGroupFile02" required>
                                 @error('foto')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                                 <label id="labelBukti" class="custom-file-label " for="inputGroupFile02">Choose file</label>
                               </div>
                           </div>
                     <a href="{{ route('pembayaran.siswa') }}" class="btn btn-dark">Kembali</a>
                     <button class="btn btn-primary">Kirim</button>
                 </form>
              </div>
              {{-- <div class="col-md-6">
                 <div class="card shadow">
                    <div class="card-header py-3">
                        <h4>List Bank</h4>
                    </div>
                    <div class="card-body">
                       <p>Iki isi e bank</p>
                    </div>
                 </div>
              </div> --}}
           </div>
        </div>
    </div>

@endsection

@section('js')
<script type="application/javascript">
   $('input[type="file"]').change(function(e){
       var fileName = e.target.files[0].name;
       $('.custom-file-label').html(fileName);
   });
   $("#buktiTransfer").change(function() {
        if(this.files[0].size > 2097152){
            alert("Maaf Foto Kamu Terlalu Besar");
            $("#buktiTransfer").val('');
            $("#labelBukti").text('Choose file');
        }
    });
</script>
@endsection