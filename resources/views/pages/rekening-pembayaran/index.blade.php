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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus"></i> Tambah Rekening</button>
                        </div>
                    </div>
                </div>
            @endhasanyrole
        </div>
        <div class="card-body">
            <form action="" method="GET">
                <div class="row mb-4 justify-content-end">
                    <div class="col-xl-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Masukkan Nama Bank" aria-label="Masukkan Nama Bank" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="button">Cari</button>
                            </div>
                          </div>
                    </div>
                </div>
            </form>
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
                        @forelse ($bank as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->nama }}</td>
                                <td>{{ $value->nomer_rekening }}</td>
                                <td>{{ $value->alias }}</td>
                                <td>
                                    <form action="{{ route('rekening.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                        @csrf
                                        @method("DELETE")
                                        <a href="{{ route('rekening.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
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
                                <td colspan="5" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
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
                <form action="{{ route('rekening.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Bank/Instansi Asal</label>
                            <input name="nama" type="text" class="form-control form-control-user @error('nama') is-invalid @enderror" id="namaBank" placeholder="Nama Bank/Instansi" value="{{ old('nama') }}" required>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nomer_rekening">Nomor Rekening</label>
                            <input name="nomer_rekening" type="text" class="form-control form-control-user @error('nomer_rekening') is-invalid @enderror" id="nomorRekening" placeholder="Nomor Rekening" value="{{ old('nomer_rekening') }}" required>
                            @error('nomer_rekening')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alias">Nama Pemilik (a/n)</label>
                            <input name="alias" type="text" class="form-control form-control-user @error('alias') is-invalid @enderror" id="nomorRekening" placeholder="Nama Pemilik (a/n)" value="{{ old('alias') }}" required>
                            @error('alias')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Logo</label>

                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="inputFile" accept="image/*">
                                    <label class="custom-file-label" id="labelFile" for="inputFile">Choose file</label>
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

@section('js')
<script>
   $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus gambar ini!",
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

   $('#inputFile').on('change', function (e) {
        var fileName = e.target.files[0].name;
        $(this).next('#labelFile').html(fileName);
    })
</script>
@endsection