@extends('layouts.dashboard-app')
@section('title', 'Integrasi Tryout ke Gelombang '. $gelombang->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Integrasi Tryout ke Gelombang {{ $gelombang->nama }} </h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Integrasi Tryout ke Gelombang {{ $gelombang->nama }}</h6>
        </div>
    </div>
    <div class="card-body container">
        <form action="{{ route('pendaftaran.tryout.store', $gelombang->id) }}" method="post">
            @csrf
            <div class="form-group">
                <div class="row">
                    @php $no = 1; @endphp
                    <ol>

                        @foreach ($tryout as $key => $row)
                        <li>
                            <input type="checkbox" name="tryout[]" value="{{ $row->id }}"
                                {{ in_array($row->nama, $hasTryout) ? 'checked':'' }} />
                            <label>{{ $row->nama }}</label>
                            @if (in_array($row->nama, $hasTryout))
                                @if (in_array($row->id, $to_lewat))
                                    {{-- @if (in_array($row->id, $sudah_koreksi))
                                        <button type="button" class="btn btn-sm btn-langkah">Sudah di Koreksi</button>
                                    @else --}}
                                        <button type="button" class="btn btn-sm btn-success koreksi" data-to="{{ $row->id }}" data-gel="{{ $gelombang->id }}">Koreksi</button>
                                    {{-- @endif --}}
                                @else
                                    <button type="button" class="btn btn-sm btn-warning" disabled style="color: black">Tryout Belum selesai</button>
                                @endif
                            @endif
                        </li>
                        @endforeach
                    </ol>

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
    @endsection

    @section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/pretty-checkbox.min.css') }}">
    @endsection

    @section('js')
        <script>
            const URL_KOREKSI = `{{ url('dashboard/koreksi/tryout') }}`
            $(".koreksi").on('click', function() {
                Swal.fire({
                    title: 'Yakin?',
                    text: "Ingin Mengoreksi Tryout ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let to = $(this).data('to')
                        let gel = $(this).data('gel')
                        window.location.replace(`${URL_KOREKSI}/${gel}/${to}`)
                    }
                })
            })
        </script>
    @endsection
