@extends('layouts.dashboard-app')
@section('title', 'Pemberitahuan')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Pemberitahuan</h1>

<div class="card shadow mb-4">
    @hasanyrole('superadmin|admin')
    <div class="card-header py-3">
       @hasanyrole('superadmin|admin')
        <div class="row">
            <div class="col-xl-12 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i
                        class="fa fa-paper-plane"></i> Kirim Pemberitahuan</button>
            </div>
        </div>
        @endhasanyrole
    </div>
    @endhasanyrole
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tujuan</th>
                        <th>Isi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">
                            Tidak ada data
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
