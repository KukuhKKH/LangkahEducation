@extends('layouts.dashboard-app')

@section('content')
   <div class="row">
      @if ($status_bayar)
         @forelse ($paket as $value)
            <div class="col-md-3 col-xs-6">
               <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ $value->image }}" alt="Card image cap">
                  <div class="card-body">
                     <h4 class="card-text">{{ $value->nama }}</h4>
                     <p>{{ $value->deskripsi }}</p>
                     <?php $today = date('m/d/Y'); ?>
                     @if ($today > $value->tgl_awal && $today < $value->tgl_akhir)
                        <a href="{{ route('siswa.tryout.paket', $value->slug) }}" class="btn btn-primary">Tryout</a>
                     @elseif($today < $value->tgl_awal)
                        <a href="#" class="btn btn-primary disabled" disabled>Belum Waktunya</a>
                     @else
                        <a href="#" class="btn btn-primary disabled" disabled>Tryout Telah Selesai</a>
                     @endif
                  </div>
               </div>
            </div>
         @empty
            Tidak ada Paket Tryout
         @endforelse
      @else
         <div class="text-center">
            <h1>Bayar Dulu Boss</h1>
         </div>
      @endif
   </div>
@endsection