@extends('layouts.dashboard-app')
@section('title', 'Try Out')

@section('content')
   {{-- <div class="row">
      @if ($status_bayar)
         @forelse ($paket as $value)
            <div class="col-md-3 col-xs-6">
               <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ $value->image }}" alt="Card image cap">
                  <div class="card-body">
                     <h4 class="card-text">{{ $value->nama }}</h4>
                     <p>{{ $value->deskripsi }}</p>
                     @php $today = date('m/d/Y'); @endphp
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
            <h1>Silahkan Melakukan Pembayaran Terlebih Dahulu</h1>
         </div>
      @endif
   </div> --}}

<h1 class="h3 mb-4 text-gray-800">Try Out</h1>

<div class="row mb-4">
    @forelse ($paket as $value)
    @if ($value->status == 1)
        <div class="col-xl-4">
            <div class="card mb-2">
                @if ($value->image)
                <img class="card-img-top img-cover" src="{{ $value->image }}" alt="Try Out">
                @else
                <img class="card-img-top img-cover" src="{{asset('assets/img/default-tryout.svg')}}" alt="Try Out">
                @endif
                <div class="card-body">
                    <h5 class="card-text">{{ $value->nama }}</h5>
                    <div class="row">
                        <div class="col-xl-12">
                            <strong>Mulai</strong>
                            <h6>Tanggal : {{ Carbon\Carbon::parse($value->tgl_awal)->format('d F Y') }}</h6>
                            <h6>Jam : {{ Carbon\Carbon::parse($value->tgl_awal)->format('H:i') }}</h6>
                        </div>
                        <div class="col-xl-12">
                            <strong>Sampai</strong>
                            <h6>Tanggal : {{ Carbon\Carbon::parse($value->tgl_akhir)->format('d F Y') }}</h6>
                            <h6>Jam : {{ Carbon\Carbon::parse($value->tgl_akhir)->format('H:i') }}</h6>
                        </div>
                    </div>
                    @php
                        $cek = $value->wherehas('hasil', function($q) use($value) {
                                    $q->where('user_id', auth()->user()->id)->where('tryout_paket_id', $value->id);
                                })->get();
                        $today = date('Y-m-d H:i');
                    @endphp
                    @if ($today > $value->tgl_awal && $today < $value->tgl_akhir)
                        @if (count($cek) > 0)
                        @php
                            $prodi = App\Models\TempProdi::where('paket_id', $value->id)->get();
                        @endphp
                            @if (count($prodi) > 0)
                            <a class="btn btn-light btn-block" href="{{ route('tryout.hasil', ['kelompok' => $prodi[0]->kelompok_passing_grade_id, 'slug' => $value->slug, 'prodi-1' => $prodi[0]->passing_grade_id, 'prodi-2' => $prodi[1]->passing_grade_id]) }}">Hasil Analisis</a>    
                            @else
                            <a class="btn btn-light btn-block" href="{{ route('tryout.hasil', ['slug' => $value->slug]) }}">Hasil Analisis</a>
                            @endif
                        @else
                            <a href="{{ route('tryout.siswa.detail', ['slug' => $value->slug, 'token' => $user_token]) }}" class="btn btn-langkah btn-block mt-4">
                                Kerjakan
                            </a>
                        @endif
                    @elseif($today < $value->tgl_awal)
                    <a href="#" class="btn btn-light text-dark btn-block mt-4 disabled" disabled>Belum Waktunya</a>
                    @else
                    <a href="#" class="btn btn-secondary btn-blok mt-4 disabled" disabled>Tryout Telah Selesai</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @empty
    <div class="col-xl-12 text-center p-5">
        <img class="img-fluid" src="{{asset('assets/img/empty-illustration.svg')}}" alt="">
        @if (auth()->user()->siswa->batch == 1)
            <h3 class="mt-3">Belum ada paket tryout dari sekolah</h3>
        @else
            <h3 class="mt-3">Wah Kamu Belum mengikuti Try Out Apapun</h3>
            <a class="btn btn-langkah mt-3" href="{{ route('gelombang.siswa') }}">Daftar Try Out</a>
        @endif
    </div>
    @endforelse
    {{-- @else
    <div class="text-center">
        <h1>Silahkan Daftar Try Out terlebih dahulu</h1>
     </div>
    @endif --}}
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-text font-wight-bold">Try Out Batch 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <img class="card-img-top" src="{{ $value->image }}" alt="Try Out"> --}}
                <img class="card-img-top" src="{{asset('assets/img/email-verification.png')}}" alt="Try Out">
                {{-- <p>{{ $value->deskripsi }}</p> --}}
                <p class="mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro et corporis ex est nisi
                    ad veniam,
                    libero necessitatibus tenetur quia voluptatem magnam odit recusandae culpa quasi. Magni inventore
                    error deserunt!</p>
                <table>
                    <tr>
                        <td>
                            Tanggal
                        </td>
                        <td>:</td>
                        <td>
                            DD/MM/YYYY
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Jam
                        </td>
                        <td>:</td>
                        <td>
                            HH:MM WIB
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-langkah btn-block" disabled>Kerjakan Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection