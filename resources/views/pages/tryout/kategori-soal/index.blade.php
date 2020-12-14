@extends('layouts.dashboard-app')
@section('title', 'Kategori Soal')

@section('css')
<link href="{{asset('assets/vendor/clockpicker/clockpicker.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-10">
        <h1 class="h3 mb-4 text-gray-800">Kategori Soal</h1>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kategori Soal</h6>
                <div class="btn-group btn-group-md">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i
                        class="fas fa-fw fa-plus"></i> Tambah Kategori</button>
                </div>
            </div>
    </div>
    <div class="card-body">
        <form action="" method="GET">
            <div class="row mb-4 justify-content-end align-items-center">
                <div class="col-xl-5">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Masukkan Kategori Soal" aria-label="Masukkan Kategori Soal" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                     </div>
                </div>
                <div class="col-xl-auto">
                  <a href="{{ route('kategori-soal.index') }}" class="btn btn-lght text-danger my-1">Refresh</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Tipe</th>
                        <th>Nama Kategori</th>
                        <th>Kode Kategori</th>
                        <th>Waktu Pengerjaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Tipe</th>
                        <th>Nama Kategori</th>
                        <th>Kode Kategori</th>
                        <th>Waktu Pengerjaan</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($kategori as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ strtoupper($value->jenis) }}</td>
                            <td>{{ strtoupper($value->tipe) }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->kode }}</td>
                            <td>{{ $value->waktu }} Menit</td>
                            <td>
                                <form action="{{ route('kategori-soal.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method("DELETE")
                                    <a href="{{ route('kategori-soal.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                       <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" data-id="{{ $value->id }}" class="btn btn-danger hapus" data-toggle="tooltip" data-placement="top" title="Hapus">
                                       <i class="fas fa-trash"></i>
                                    </button>
                                 </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kategori-soal.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis">Jenis Kategori</label>
                        <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" autocomplete="off">
                            <option value="tps" {{ old('jenis') == 'tps' ? 'selected' : '' }}>TPS</option>
                            <option value="tka" {{ old('jenis') == 'tka' ? 'selected' : '' }}>TKA</option>
                        </select>
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tipe">Tipe Kategori</label>
                        <select name="tipe" class="form-control @error('tipe') is-invalid @enderror" autocomplete="off">
                            <option value="umum" {{ old('tipe') == 'umum' ? 'selected' : '' }}>UMUM</option>
                            <option value="saintek" {{ old('tipe') == 'saintek' ? 'selected' : '' }}>SAINTEK</option>
                            <option value="soshum" {{ old('tipe') == 'soshum' ? 'selected' : '' }}>SOSHUM</option>
                        </select>
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Kategori</label>
                        <input name="nama" type="text" class="form-control form-control-user @error('nama') is-invalid @enderror" id="namaKategori" placeholder="Nama Kategori" value="{{ old('nama') }}" required>
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode Kategori </label><small class="text-danger ml-2">*Huruf Kapital</small>
                        <input name="kode" type="text" class="form-control form-control-user @error('kode') is-invalid @enderror" id="kodeKategori" placeholder="Nama Kategori" value="{{ old('kode') }}" required>
                        @error('kode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="waktu">Waktu Pengerjaan <small class="text-danger">*Dalam menit</small></label>
                        <div class="input-group">
                            <input name="waktu" type="number" class="form-control form-control-user clockpicker @error('waktu') is-invalid @enderror" id="waktuSoal" placeholder="Waktu Pengerjaan" value="{{ old('waktu') }}" required>
                        </div>
                        @error('waktu')
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
<script src="{{ asset('assets/vendor/clockpicker/clockpicker.js') }}"></script>
<script>
    $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus kategori soal ini!",
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
