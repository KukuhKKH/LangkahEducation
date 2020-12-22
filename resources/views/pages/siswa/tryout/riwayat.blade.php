@extends('layouts.dashboard-app')
@section('title', 'Riwayat Try Out')

@section('content')
   <h1 class="h3 mb-4 text-gray-800">Riwayat Try Out</h1>

   <div class="row mb-4">
   @forelse ($riwayat as $value)
      <div class="col-xl-4">
         <div class="card mb-4">
            @if ($value->paket->image)
            <?php $foto = $value->paket->image ?>
               <img class="card-img-top img-cover" src="{{ asset("upload/paket-tryout/$foto") }}" alt="Try Out" style="height:225px">
            @else
               <img class="card-img-top img-cover" src="{{asset('assets/img/default-tryout.svg')}}" alt="Try Out">
            @endif
            <div class="card-body">
               <h5 class="card-text">{{ $value->paket->nama }}</h5>
               <div class="row">
                  <div class="col-xl-12">
                     <strong>Produk</strong>
                     <h6>{{ $value->paket->nama }}</h6>
                  </div>
                  <div class="col-xl-12">
                     <strong>Mulai</strong>
                     <h6>Tanggal : {{ Carbon\Carbon::parse($value->paket->tgl_awal)->format('d F Y') }}</h6>
                     <h6>Jam : {{ Carbon\Carbon::parse($value->paket->tgl_awal)->format('H:i') }} WIB</h6>
                  </div>
                  <div class="col-xl-12">
                     <strong>Berakhir</strong>
                     <h6>Tanggal : {{ Carbon\Carbon::parse($value->paket->tgl_akhir)->format('d F Y') }}</h6>
                     <h6>Jam : {{ Carbon\Carbon::parse($value->paket->tgl_akhir)->format('H:i') }} WIB</h6>
                  </div>
               </div>
                  @php
                     $prodi = App\Models\TempProdi::where('paket_id', $value->paket->id)->get();
                  @endphp
                  @if (count($prodi) > 0)
                     <a class="btn btn-light btn-block mt-4"
                        href="{{ route('tryout.hasil', [
                           'gelombang_id' => $value->gelombang->id,
                           'kelompok' => $prodi[0]->kelompok_passing_grade_id,
                           'slug' => $value->paket->slug,
                           'prodi-1' => $prodi[0]->passing_grade_id,
                           'prodi-2' => $prodi[1]->passing_grade_id
                        ]) }}">
                           Hasil Analisis
                        </a>
                  @else
                     <a class="btn btn-light btn-block mt-4"
                        href="{{ route('tryout.hasil', ['gelombang_id' => $value->gelombang->id, 'slug' => $value->paket->slug]) }}">Hasil
                        Analisis</a>
                  @endif
            </div>
         </div>
      </div>
      @empty
      <div class="col-xl-12 text-center p-5">
         <img class="img-fluid" src="{{asset('assets/img/empty-illustration.svg')}}" alt="">
         <h3 class="mt-3">Wah Kamu Belum mengikuti Try Out Apapun</h3>
         <a class="btn btn-langkah mt-3" href="{{ route('gelombang.siswa') }}">Daftar Try Out</a>
      </div>
      @endforelse
@endsection