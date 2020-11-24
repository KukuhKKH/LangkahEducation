@extends('layouts.dashboard-app')
@section('title', 'Rekening Pembayaran')

@section('content')
    <div class="row">
        <div class="col-10">
            <h1 class="h3 mb-4 text-gray-800">Rekening Pemabayaran</h1>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            @hasanyrole('admin|superadmin')
                <div class="row">
                    <div class="col-xl-12 text-right">
                        <div class="btn-group btn-group-md">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus-circle"></i> Tambah Rekening</button>
                        </div>
                    </div>
                </div>
            @endhasanyrole
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Instansi Asal</th>
                        <th>No. Rekening</th>
                        <th>Alias</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Instansi Asal</th>
                        <th>No. Rekening</th>
                        <th>Alias</th>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
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

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Rekening Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Bank/Instansi Asal</label>
                            <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="namaBank" placeholder="Nama Bank/Instansi" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nomor Rekening</label>
                            <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="nomorRekening" placeholder="Nomor Rekening" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Pemilik (a/n)</label>
                            <input name="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="nomorRekening" placeholder="Nama Pemilik (a/n)" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Logo</label>

                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection