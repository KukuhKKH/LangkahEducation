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
              <div class="col-md-6">
                 <form action="{{ route('pembayaran.siswa.update', $pembayaran->id) }}" method="post" enctype="multipart/form-data">
                     @csrf
                     @method('PUt')
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="">Bukti Transfer</label>
                              <input class="form-control" type="file" name="file" placeholder="Bukti Transfer" accept="image/*">
                           </div>
                        </div>
                        <div class="col-md-6">
                           <?php $bukti = $pembayaran->pembayaran_bukti->first()->bukti; ?>
                           <a href="{{ asset("upload/bukti/$bukti") }}" target="_blank">
                              <img src="{{ asset("upload/bukti/$bukti") }}" alt="{{ $pembayaran->bukti }}" width="100">
                           </a>
                        </div>
                     </div>
                     <a href="{{ route('pembayaran.siswa') }}" class="btn btn-outline-primary">Kembali</a>
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