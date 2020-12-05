@extends('layouts.dashboard-app')
@section('title', 'Integrasi Tryout ke Sekolah '. $sekolah->user->nama)

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Integrasi Tryout ke Sekolah {{ $sekolah->user->nama }} </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Integrasi Tryout ke Sekolah {{ $sekolah->user->nama }}</h6>
            </div>
        </div>
        <div class="card-body container">
            <form action="{{ route('sekolah.tryout.store', $sekolah->id) }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="row">
                        @php $no = 1; @endphp
                        @foreach ($tryout as $key => $row)
                           <div class="pretty p-icon p-smooth col-xl-3 my-2" style="font-size: 16px;">
                              <input type="checkbox" name="tryout[]" value="{{ $row->id }}" {{ in_array($row->nama, $hasTryout) ? 'checked':'' }}/>
                              <div class="state p-primary">
                                 <i class="icon fa fa-check"></i>
                                 <label>{{ $row->nama }}</label>
                              </div>
                           </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="float-right">
                    <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
                    <button class="btn btn-primary">
                        <i class="fas fa-check mr-1"></i> Set Tryout
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
   <link rel="stylesheet" href="{{ asset('assets/vendor/pretty-checkbox.min.css') }}">
@endsection