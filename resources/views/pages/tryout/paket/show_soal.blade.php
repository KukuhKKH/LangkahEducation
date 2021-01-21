@extends('layouts.dashboard-app')
@section('title', "Paket Try out - ".$paket->nama)

@section('content')
<h1 class="h3 mb-4 text-gray-800">List Soal Paket Try out - {{ $paket->nama }}</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">List Soal Try out - {{ $paket->nama }}</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <?php $i = 1; ?>
            <?php $k = 0; ?>
            @forelse ($paket->soal as $value)
            <div class="col-6">
                <div id="question{{ $k }}">
                     <h3 class="badge badge-primary p-2">Kategori {{ $value->kategori_soal->nama }}</h3>
                    <h6>{{ 'Soal nomer '.$i }}</h6>
                    <h3 id="pertanyaan" class="h5 mt-2 mb-2 text-gray-80">
                        {!! $value->soal !!}
                    </h3>
                    <input type="hidden" name="soal[{{ $i }}]" value="{{ $value->id }}">
                    <ol type="A">
                        <?php $j = 1; ?>
                        @foreach($value->jawaban()->inRandomOrder()->get() as $option)
                        <li>
                            <input class="mb-2 mr-1" type="radio" name="jawaban[{{ $value->id }}]"
                                value="{{ $option->id }}" id="option{{ $i }}ke{{ $j }}">
                            <label for="option{{ $i }}ke{{ $j }}">{!! $option->jawaban !!}</label>
                        </li>
                        <?php $j++; ?>
                        @endforeach
                    </ol>
                </div>
                <?php $i++; ?>
                <?php $k++; ?>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center mb-3 p-5 bg-light">
                    <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                    <h6>Belum ada soal</h6>
                </div>
            </div>
            @endforelse
        </div>
        <div class="text-right">
            <a href="{{ route('paket.index') }}" class="btn btn-dark">Kembali</a>

        </div>
    </div>
</div>
@endsection
