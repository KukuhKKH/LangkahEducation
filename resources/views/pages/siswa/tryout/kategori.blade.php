@extends('layouts.dashboard-app')

@section('content')
<div class="row">
   @forelse ($paket as $value)
      <div class="col-4">
         <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{ $value->image }}" alt="Card image cap">
            <div class="card-body">
               <h4 class="card-text">{{ $value->nama }}</h4>
               <p>{{ $value->deskripsi }}</p>
               <a href="{{ route('siswa.tryout.kategori', $value->slug) }}" class="btn btn-primary">Pilih</a>
            </div>
         </div>
      </div>
   @empty
      Tidak ada Paket Tryout
   @endforelse
</div>
@endsection