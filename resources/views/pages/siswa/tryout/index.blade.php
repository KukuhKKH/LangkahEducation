@extends('layouts.dashboard-app')
@section('title', 'Try Out')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Try Out</h1>

<div class="row">
    {{-- @forelse ($paket as $value) --}}
    <div class="col-md-3 col-xs-6">
        <div class="card" style="width: 18rem;">
            {{-- <img class="card-img-top" src="{{ $value->image }}" alt="Try Out"> --}}
            <img class="card-img-top" src="{{asset('assets/img/email-verification.png')}}" alt="Try Out">
            <div class="card-body">
                {{-- <h5 class="card-text">{{ $value->nama }}</h5> --}}
                <h5 class="card-text font-wight-bold">Try Out Batch 1</h5>
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
                <button data-toggle="modal" data-target="#exampleModal"
                    class="btn btn-langkah btn-block mt-4">Kerjakan</button>
                <a class="btn btn-light btn-block" href="#">Hasil Analisis</a>
            </div>
        </div>
    </div>
    {{-- @empty
      <div class="col-xl-12 text-center p-5">
         <img class="img-fluid" src="{{asset('assets/img/empty-illustration.svg')}}" alt="">
    <h3 class="mt-3">Wah Kamu Belum mengikuti Try Out Apapun</h3>
    <a class="btn btn-langkah mt-3" href="#">Daftar Try Out</a>
</div>
@endforelse --}}
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