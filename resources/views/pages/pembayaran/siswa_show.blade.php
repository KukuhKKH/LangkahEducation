@extends('layouts.dashboard-app')
@section('title', 'Upload Pembayaran')

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Upload Pembayaran</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Upload Pembayaran - Gelombang {{ $pembayaran->gelombang->nama }}</h6>
             </div>
        </div>
        <div class="card-body">
           <div class="row">
              <div class="col-md-6">
                 <form action="{{ route('pembayaran.siswa.bayar', $pembayaran->id) }}" method="post" enctype="multipart/form-data">
                  @csrf
                     <div class="form-group">
                        <label for="">Bukti Transfer</label>
                        <input class="form-control" type="file" name="file" placeholder="Bukti Transfer" accept="image/*">
                     </div>
                     <a href="{{ route('pembayaran.siswa') }}" class="btn btn-outline-primary">Kembali</a>
                     <button class="btn btn-primary">Kirim</button>
                 </form>
              </div>
           </div>
        </div>
    </div>

@endsection