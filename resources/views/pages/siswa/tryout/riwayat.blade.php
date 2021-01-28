@extends('layouts.dashboard-app')
@section('title', 'Riwayat Tryout')

@section('content')
   <h1 class="h3 mb-4 text-gray-800">Riwayat Tryout</h1>

   <div class="row mb-4">
   @forelse ($riwayat as $value)
      <div class="col-lg-4 col-md-6">
         <div class="card mb-4">
            @if ($value->paket->image)
            <?php $foto = $value->paket->image ?>
               <img class="card-img-top img-cover" src="{{ asset("upload/paket-tryout/$foto") }}" alt="Tryout" style="height:225px">
            @else
               <img class="card-img-top img-cover" src="{{asset('assets/img/default-tryout.svg')}}" alt="Tryout">
            @endif
            @php
            $prodi = App\Models\TempProdi::where('paket_id', $value->paket->id)
                                       ->where('user_id', auth()->user()->id)
                                       ->where('gelombang_id', $value->gelombang_id)->get();
            @endphp
            <div class="card-body">
               <h5 class="card-text">{{ $value->paket->nama }}</h5>
               <div class="row">
                  @php
                     $valKelompok ="";
                     if ($prodi[0]->kelompok_passing_grade_id == 1) {
                        $valKelompok = "Saintek";
                     }else if($prodi[0]->kelompok_passing_grade_id == 2){
                        $valKelompok = "Soshum";
                     }
                  @endphp
                  <div class="col-xl-12">
                     <strong>Kelompok</strong>
                     <h6>{{ $valKelompok }}</h6>
                  </div>
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
                  $koreksi = $value->paket->koreksi;
               @endphp
                 
                  @if (count($prodi) > 0)
                  @if ($koreksi)
                     <a class="btn btn-light btn-block mt-4 {{ ($koreksi) ? '' : 'disabled not-allowed' }}"
                     href="{{ route('tryout.hasil', [
                        'gelombang_id' => $value->gelombang->id,
                        'kelompok' => $prodi[0]->kelompok_passing_grade_id,
                        'slug' => $value->paket->slug,
                        'prodi-1' => $prodi[0]->passing_grade_id,
                        'prodi-2' => $prodi[1]->passing_grade_id
                     ]) }}" {{ ($koreksi) ? '' : 'disabled' }}>
                        Hasil Analisis
                     </a>
                  @else
                     <a class="btn btn-light btn-block mt-4 {{ ($koreksi) ? '' : 'disabled not-allowed' }}"
                     href="javascript:void(0)" {{ ($koreksi) ? '' : 'disabled' }}>
                        Tryout Belum dikoreksi
                     </a>
                  @endif
                  @else
                     <a class="btn btn-light btn-block mt-4"
                        href="{{ route('tryout.hasil', ['gelombang_id' => $value->gelombang->id, 'slug' => $value->paket->slug]) }}" {{ ($disable) ? '' : 'disabled not-allowed' }}>Hasil
                        Analisis</a>
                  @endif
            </div>
         </div>
         {{ $riwayat->links() }}
      </div>
      @empty
      <div class="col-xl-12 text-center p-5">
         <img class="img-fluid" src="{{asset('assets/img/empty-illustration.svg')}}" alt="">
         <h3 class="mt-3">Wah Kamu Belum mengikuti Tryout Apapun</h3>
         <a class="btn btn-langkah mt-3" href="{{ route('gelombang.siswa') }}">Daftar Tryout</a>
      </div>
      @endforelse
@endsection

@section('css')
   <style>
      .not-allowed {
         pointer-events: auto! important;
         cursor: not-allowed! important;
      }
   </style>
@endsection