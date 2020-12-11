@extends('layouts.dashboard-app')
@section('title', 'Try Out')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Try Out</h1>

<div class="row mb-4">

{{-- Produk dari sekolah --}}
@forelse ($produk_sekolah as $value)
    @foreach ($value->tryout as $item)
        @if ($item->status == 1)
            <div class="col-xl-4">
                <div class="card mb-2">
                    @if ($item->image)
                    <img class="card-img-top img-cover" src="{{ $item->image }}" alt="Try Out">
                    @else
                    <img class="card-img-top img-cover" src="{{asset('assets/img/default-tryout.svg')}}" alt="Try Out">
                    @endif
                    <div class="card-body">
                        {{-- Nama paket - Nama Gelombang --}}
                        <h5 class="card-text">{{ $item->nama }} - {{ $value->nama }}</h5>
                        <div class="row">
                            <div class="col-xl-12">
                                <strong>Mulai</strong>
                                <h6>Tanggal : {{ Carbon\Carbon::parse($item->tgl_awal)->format('d F Y') }}</h6>
                                <h6>Jam : {{ Carbon\Carbon::parse($item->tgl_awal)->format('H:i') }} WIB</h6>
                            </div>
                            <div class="col-xl-12">
                                <strong>Berakhir</strong>
                                <h6>Tanggal : {{ Carbon\Carbon::parse($item->tgl_akhir)->format('d F Y') }}</h6>
                                <h6>Jam : {{ Carbon\Carbon::parse($item->tgl_akhir)->format('H:i') }} WIB</h6>
                            </div>
                        </div>
                        @php
                            $cek = $item->wherehas('hasil', function($q) use($item) {
                                        $q->where('user_id', auth()->user()->id)->where('tryout_paket_id', $item->id);
                                    })->get();
                            $today = date('Y-m-d H:i');
                        @endphp
                        @if ($today > $item->tgl_awal && $today < $item->tgl_akhir)
                            @if (count($cek) > 0)
                            @php
                                $prodi = App\Models\TempProdi::where('paket_id', $item->id)->get();
                            @endphp
                                @if (count($prodi) > 0)
                                <a class="btn btn-light btn-block mt-4" href="{{ route('tryout.hasil', ['kelompok' => $prodi[0]->kelompok_passing_grade_id, 'slug' => $item->slug, 'prodi-1' => $prodi[0]->passing_grade_id, 'prodi-2' => $prodi[1]->passing_grade_id]) }}">Hasil Analisis</a>    
                                @else
                                <a class="btn btn-light btn-block mt-4" href="{{ route('tryout.hasil', ['slug' => $item->slug]) }}">Hasil Analisis</a>
                                @endif
                            @else
                                <a href="{{ route('tryout.siswa.detail', ['slug' => $item->slug, 'token' => $user_token]) }}" class="btn btn-langkah btn-block mt-4">
                                    Kerjakan
                                </a>
                            @endif
                        @elseif($today < $item->tgl_awal)
                        <a href="#" class="btn btn-light text-dark btn-block mt-4 disabled" disabled>Belum Waktunya</a>
                        @else
                        <a href="#" class="btn btn-secondary btn-blok mt-4 disabled" disabled>Tryout Telah Selesai</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <?php $kosong = false; ?>
@empty
        
@endforelse

{{-- Produk dari gelombang --}}
@forelse ($produk_gelombang as $value)
    @foreach ($value->tryout as $item)
        @if ($item->status == 1)
            <div class="col-xl-4">
                <div class="card mb-2">
                    @if ($item->image)
                    <img class="card-img-top img-cover" src="{{ $item->image }}" alt="Try Out">
                    @else
                    <img class="card-img-top img-cover" src="{{asset('assets/img/default-tryout.svg')}}" alt="Try Out">
                    @endif
                    <div class="card-body">
                        {{-- Nama paket - Nama Gelombang --}}
                        <h5 class="card-text">{{ $item->nama }} - {{ $value->nama }}</h5>
                        <div class="row">
                            <div class="col-xl-12">
                                <strong>Mulai</strong>
                                <h6>Tanggal : {{ Carbon\Carbon::parse($item->tgl_awal)->format('d F Y') }}</h6>
                                <h6>Jam : {{ Carbon\Carbon::parse($item->tgl_awal)->format('H:i') }} WIB</h6>
                            </div>
                            <div class="col-xl-12">
                                <strong>Berakhir</strong>
                                <h6>Tanggal : {{ Carbon\Carbon::parse($item->tgl_akhir)->format('d F Y') }}</h6>
                                <h6>Jam : {{ Carbon\Carbon::parse($item->tgl_akhir)->format('H:i') }} WIB</h6>
                            </div>
                        </div>
                        @php
                            $cek = $item->wherehas('hasil', function($q) use($item) {
                                        $q->where('user_id', auth()->user()->id)->where('tryout_paket_id', $item->id);
                                    })->get();
                            $today = date('Y-m-d H:i');
                        @endphp
                        @if ($today > $item->tgl_awal && $today < $item->tgl_akhir)
                            @if (count($cek) > 0)
                            @php
                                $prodi = App\Models\TempProdi::where('paket_id', $item->id)->get();
                            @endphp
                                @if (count($prodi) > 0)
                                <a class="btn btn-light btn-block mt-4" href="{{ route('tryout.hasil', ['kelompok' => $prodi[0]->kelompok_passing_grade_id, 'slug' => $item->slug, 'prodi-1' => $prodi[0]->passing_grade_id, 'prodi-2' => $prodi[1]->passing_grade_id]) }}">Hasil Analisis</a>    
                                @else
                                <a class="btn btn-light btn-block mt-4" href="{{ route('tryout.hasil', ['slug' => $item->slug]) }}">Hasil Analisis</a>
                                @endif
                            @else
                                <a href="{{ route('tryout.siswa.detail', ['slug' => $item->slug, 'token' => $user_token]) }}" class="btn btn-langkah btn-block mt-4">
                                    Kerjakan
                                </a>
                            @endif
                        @elseif($today < $item->tgl_awal)
                        <a href="#" class="btn btn-light text-dark btn-block mt-4 disabled" disabled>Belum Waktunya</a>
                        @else
                        <a href="#" class="btn btn-secondary btn-blok mt-4 disabled" disabled>Tryout Telah Selesai</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@empty
    @if ($kosong)
        <div class="col-xl-12 text-center p-5">
            <img class="img-fluid" src="{{asset('assets/img/empty-illustration.svg')}}" alt="">
            @if (auth()->user()->siswa->batch == 1)
                <h3 class="mt-3">Belum ada paket tryout dari sekolah</h3>
            @else
                <h3 class="mt-3">Wah Kamu Belum mengikuti Try Out Apapun</h3>
                <a class="btn btn-langkah mt-3" href="{{ route('gelombang.siswa') }}">Daftar Try Out</a>
            @endif
        </div>
    @endif
@endforelse
</div>
@endsection