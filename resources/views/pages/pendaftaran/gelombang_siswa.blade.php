@extends('layouts.dashboard-app')
@section('title', 'List Gelombang')

@section('content')
@forelse($gelombang as $value)
<div class="card shadow mb-4">
    <div class="card-body text-center">
        <div class="alert alert-primary font-weight-bold" role="alert">
            Dibuka Pendaftaran Try Out!
        </div>
        <h4 class="font-weight-bold">{{ $value->nama }}</h4>
        <img class="img-fluid w-25 my-4" src="{{asset('assets/img/welcome-illustration.svg')}}" alt="">

        <h6 class="font-weight-bold">Daftarkan dirimu segera di <span>{{ $value->nama }}</span> dengan fasilitas
            <span>{{ count($value->tryout) }}</span>x Try Out
        </h6>
        <h6 class="font-weight-bold">Tanggal Pendaftaran
            : <span class="font-weight-normal">{{ Carbon\Carbon::parse($value->tgl_awal)->format('d F Y') }} -
                {{ Carbon\Carbon::parse($value->tgl_akhir)->format('d F Y') }}</span></h6>
        <h6 class="font-weight-bold">Biaya Pendaftaran : <span class="font-weight-normal">Rp. {{ $value->harga }}</span></h6>

        <div class="d-flex justify-content-center">
        <a href="javascript:void(0)" data-id="{{ $value->id }}" class="my-4 btn btn-langkah btn-block w-50 daftar"
            data-toggle="tooltip" data-placement="top" title="Daftar">
            Daftar Sekarang
        </a>
        </div>
    </div>
</div>
@empty
<div class="text-center">
    <img class="img-fluid w-25 my-4" src="{{asset('assets/img/empty-illustration.svg')}}" alt="">
    <h3>Yahh.. Saat ini belum ada dibuka Pendaftaran</h3>
</div>
@endforelse
<!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">List Gelombang</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Nama Gelombang</th>
                        <th>Harga</th>
                        <th>Total Tryout</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Nama Gelombang</th>
                        <th>Harga</th>
                        <th>Total Tryout</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($gelombang as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Carbon\Carbon::parse($value->tgl_awal)->format('d F Y') }} - {{ Carbon\Carbon::parse($value->tgl_akhir)->format('d F Y') }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->harga }}</td>
                            <td>{{ count($value->tryout) }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $value->id }}" class="btn btn-primary daftar" data-toggle="tooltip" data-placement="top" title="Daftar">
                                    Daftar Sekarang
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->

@endsection

@section('js')
<script>
    const URL = `{{ url('dashboard/daftar-gelombang') }}`
    $(".daftar").on('click', function () {
        Swal.fire({
            title: 'Daftar Sekarang',
            text: "Apakah Kamu mau mendaftar sekarang?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).data('id')
                window.location.replace(`${URL}/${id}`)
            }
        })
    })

</script>
@endsection