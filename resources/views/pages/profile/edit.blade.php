@extends('layouts.dashboard-app')

@section('content')
{{-- <h1 class="h3 mb-2 text-gray-800">Profil</h1> --}}

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Edit Profil
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12 text-center mb-3">
                @if ($user->foto)
                <img  id="img-profile" class="img-fluid img-cover"  src="{{ asset('upload/users/'.$user->foto) }}" alt="{{ $user->name }}" class="img-fluid w-100">
                @endif
            </div>
        </div>
        <form action="{{ route('profile.update', $user->id) }}" id="form" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Nama / Username</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ $user->name }}" placeholder="Nama / username">
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
                            value="{{ $user->email }}" placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- Data Tabel Siswa --}}
                @role('siswa')
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">NISN</label>
                        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                            value="{{ $user->siswa->nisn }}" placeholder="NISN">
                        @error('nisn')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah"
                            class="form-control @error('asal_sekolah') is-invalid @enderror"
                            value="{{ $user->siswa->asal_sekolah }}" placeholder="Asal Sekolah">
                        @error('asal_sekolah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Tanggal Lahir</label>
                        <input type="text" name="tanggal_lahir"
                            class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ date('d/m/Y', strtotime($user->siswa->tanggal_lahir)) }}"
                            placeholder="Tanggal Lahir">
                        @error('nisn')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Nomer HP</label>
                        <input type="number" name="nomor_hp"
                            class="form-control @error('nomor_hp') is-invalid @enderror"
                            value="{{ $user->siswa->nomor_hp }}" placeholder="Nomer HP">
                        @error('nomor_hp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endrole
                @role('sekolah')
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            value="{{ $user->sekolah->alamat }}" placeholder="Alamat Sekolah">
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
                            value="{{ $user->sekolah->kode_referal }}" placeholder="Kode Referal Sekolah">
                        @error('kode_referal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endrole
                @role('mentor')
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir"
                            class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                            value="{{ $user->mentor->pendidikan_terakhir }}" placeholder="Pendidikan Terakhir">
                        @error('pendidikan_terakhir')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @endrole
                @role('author')
                {{-- <div class="col-xl-6">
               <div class="form-group">
                  <label for="">Deskripsi</label>
                  <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ $user->author->deskripsi }}</textarea>
                @error('deskripsi')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
    </div> --}}
    @endrole
    {{-- End Data Tabel Siswa --}}
    <div class="col-xl-6">
        <div class="form-group">
            <label for="">Password Lama <small>Kosongkan jika tidak mengganti password</small></label>
            <input type="password" name="password_old" class="form-control @error('password_old') is-invalid @enderror"
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
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Password Baru">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-xl-6">
        <div class="form-group">
            <label for="">Ulangi Password baru <small>Kosongkan jika tidak mengganti password</small></label>
            <input type="password" name="password_confirmation" class="form-control "
                placeholder="Ulangi Password Baru">
        </div>
    </div>
    <div class="col-xl-6">
        <div class="form-group">
            <label for="">Foto <small>Maksimal 2 Mb</small></label>
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input orm-control @error('foto') is-invalid @enderror"
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
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="float-right">
            <a href="{{ url()->previous() }}" class="btn btn-dark ml-1">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </div>
</div>
</form>
</div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $.fn.datepicker.defaults.format = "dd/mm/yyyy"
    $('.datepicker').datepicker();
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
<script type="application/javascript">
    $('input[type="file"]').change(function (e) {
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

</script>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection
