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
                        @forelse ($testimoni as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($value->foto)
                                <img src="{{asset("upload/testimoni/$value->foto")}}" alt="profil-mentor"
                                    style="height:40px">
                                @else
                                <img src="{{asset('assets/img/undraw_profile.svg')}}" alt="profil-mentor"
                                    style="height:40px">
                                @endif
                            </td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->role }}</td>
                            <td>{{ $value->testimoni }}</td>
                            <td>
                                <form action="{{ route('testimoni.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    @if ($value->status)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Tampil
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-danger" href="{{ route('testimoni.status', ['id' => $value->id, 'status' => 0]) }}">Sembunyikan</a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Sembunyi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-success" href="{{ route('testimoni.status', ['id' => $value->id, 'status' => 1]) }}">Tampilkan</a>
                                        </div>
                                    </div>
                                    @endif
                                    <button type="button" data-id="{{ $value->id }}" class="btn btn-danger hapus"
                                        data-toggle="tooltip" data-placement="top" title="Hapus"> <i
                                            class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
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
            <form action="{{ route('testimoni.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input name="nama" type="text"
                            class="form-control form-control-user @error('nama') is-invalid @enderror"
                            id="exampleFirstName" placeholder="Nama Lengkap" value="{{ old('nama') }}">
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Role</label>
                        <input name="role" type="text"
                            class="form-control form-control-user @error('role') is-invalid @enderror"
                            id="exampleFirstName" placeholder="Masukkan Role" value="{{ old('role') }}">
                        @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="testimonial">Testimonial</label>
                        <textarea name="testimoni" type="text"
                            class="form-control form-control-user @error('testimoni') is-invalid @enderror"
                            placeholder="Masukkan Status" value="{{ old('testimoni') }}" rows="3"></textarea>
                        @error('testimoni')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" autocomplete="off">
                            <option value="" selected disabled>-- Pilih --</option>
                            <option value="1">Tampil</option>
                            <option value="0">Tidak Tampil</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="testimonial">Foto</label>
                        <input name="foto" type="file"
                            class="form-control form-control-user @error('foto') is-invalid @enderror">
                        @error('foto')
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

@section('js')
<script>
    $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus testimoni ini!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         cancelButtonText: 'Tidak',
         confirmButtonText: 'Ya!'
      }).then((result) => {
         if (result.isConfirmed) {
            let id = $(this).data('id')
            $(`#form-${id}`).submit()
         }
      })
   })
</script>
@endsection