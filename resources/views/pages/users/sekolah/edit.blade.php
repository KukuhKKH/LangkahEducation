@extends('layouts.dashboard-app')
@section('title', 'Edit '.$sekolah->user->name)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Update Sekolah</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Sekolah - {{ $sekolah->user->name }}</h6>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('sekolah.update', $sekolah->id) }}" id="form" method="post"
            enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <input type="hidden" name="user_id" value="{{ $sekolah->user->id }}">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Nama Sekolah</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ $sekolah->user->name }}" placeholder="Nama / username">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ $sekolah->user->email }}" placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- Data Tabel Sekolah --}}
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Alamat Sekolah</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            value="{{ $sekolah->alamat }}" placeholder="Alamat Sekolah">
                        @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Kode Referal</label>
                        <input type="text" name="kode_referal"
                            class="form-control @error('kode_referal') is-invalid @enderror"
                            value="{{ $sekolah->kode_referal }}" placeholder="Kode Referal">
                        @error('kode_referal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- End Data Tabel Sekolah --}}
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Password Lama <small>Kosongkan jika tidak mengganti password</small></label>
                        <input type="password" name="password_old"
                            class="form-control @error('password_old') is-invalid @enderror"
                            placeholder="Password Lama">
                        @error('password_old')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Password Baru <small>Kosongkan jika tidak mengganti password</small></label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password Baru">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Ulangi Password baru <small>Kosongkan jika tidak mengganti
                                password</small></label>
                        <input type="password" name="password_confirmation" class="form-control "
                            placeholder="Ulangi Password Baru">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Foto <small>Maksimal 2 Mb</small></label>

                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file"
                                    class="custom-file-input form-control @error('foto') is-invalid @enderror"
                                    name="foto" accept="image/x-png,image/gif,image/jpeg" id="inputGroupFile02">
                                @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Status Aktif</label>
                        <select name="is_active" class="form-control @error('is_active') is-invalid @enderror"
                            autocomplete="off">
                            <option value="1" {{ ($sekolah->user->is_active == 1) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ ($sekolah->user->is_active == 0) ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                        @error('is_active')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    @if ($sekolah->user->foto)
                    <img src="{{ asset('upload/users/'.$sekolah->user->foto) }}" alt="{{ $sekolah->user->name }}"
                        class="img-fluid w-100">
                    @endif
                </div>
                <div class="col-xl-6">
                    <div class="float-right">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    $("#form").on('submit', function (e) {
        if ($("#password_confirmation").val() != $("#password").val()) {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password konfirmasi tidak sama',
            })
            return false
        }
        if ($("#password").val().length < 8) {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password minimal 8 karakter',
            })
            return false
        }
        return
        e.preventDefault()
    })

</script>
@endsection
