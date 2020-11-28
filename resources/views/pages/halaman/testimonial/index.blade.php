@extends('layouts.dashboard-app')
@section('title', 'Pengaturan Landing Page')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Pengaturan - Landing Page</h1>
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Testimonial</h6>
                <div class="btn-group btn-group-md">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTestimoni"><i
                            class="fas fa-fw fa-plus-circle"></i> Tambah Testimoni</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Testimoni</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th width="30%">Testimoni</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>
                                1
                            </td>
                            <td>
                                <img src="{{asset('assets/img/undraw_profile.svg')}}" alt="profil-mentor"
                                    style="height:40px">
                            </td>
                            <td>
                                Muhammad Fatih
                            </td>
                            <td>
                                Siswa
                            </td>
                            <td>
                                Saya sangat terbantu dengan adanya platform Langkah Education
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Tampil
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-danger" href="#">Sembunyikan</a>
                                    </div>
                                </div>
                                {{-- <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Sembunyi
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-success" href="#">Tampilkan</a>
                                    </div>
                                </div> --}}
                                <button type="button" data-id="#" class="btn btn-danger hapus" data-toggle="tooltip"
                                    data-placement="top" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTestimoni" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Testimonial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input name="name" type="text"
                            class="form-control form-control-user @error('name') is-invalid @enderror"
                            id="exampleFirstName" placeholder="Nama Lengkap" value="{{ old('name') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input name="status" type="text"
                            class="form-control form-control-user @error('status') is-invalid @enderror"
                            placeholder="Masukkan Status" value="{{ old('status') }}">
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="testimonial">Testimonial</label>
                        <textarea name="testimonial" type="text"
                            class="form-control form-control-user @error('testimonial') is-invalid @enderror"
                            placeholder="Masukkan Status" value="{{ old('testimonial') }}" rows="3"></textarea>
                        @error('testimonial')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
