@extends('layouts.dashboard-app')
@section('title', 'Integrasi Tryout ke Program Khusus '. $sekolah->user->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Integrasi Tryout ke Program Khusus {{ $sekolah->user->nama }} </h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Integrasi Tryout ke Program Khusus {{ $sekolah->user->nama }}</h6>
        </div>
    </div>
    <div class="card-body container">
        <form action="{{ route('sekolah.tryout.store', $sekolah->id) }}" method="post">
            @csrf
            <div class="form-group">

                @php $no = 1; @endphp
                <ol>
                    @foreach ($tryout as $key => $row)
                    <li>
                        <input type="checkbox" name="tryout[]" value="{{ $row->id }}"
                            {{ in_array($row->nama, $hasTryout) ? 'checked':'' }} />
                            <label>{{ $row->nama }}</label>
                    </li>
                    @endforeach
                </ol>
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
