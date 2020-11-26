@extends('layouts.dashboard-app')

@section('content')
   <div class="row">
      @forelse ($paket as $value)
         <div class="col-md-3 col-xs-6">
            <div class="card" style="width: 18rem;">
               <img class="card-img-top" src="{{ $value->image }}" alt="Card image cap">
               <div class="card-body">
                  <h4 class="card-text">{{ $value->nama }}</h4>
                  <p>{{ $value->deskripsi }}</p>
                  <a href="{{ route('siswa.tryout.paket', $value->slug) }}" class="btn btn-primary">Pilih</a>
               </div>
            </div>
         </div>
      @empty
         Tidak ada Kategori Tryout
      @endforelse
   </div>
@endsection