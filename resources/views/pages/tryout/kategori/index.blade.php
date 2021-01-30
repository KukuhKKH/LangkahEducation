@extends('layouts.dashboard-app')
@section('title', 'Kategori Tryout')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Kategori Ujian</h1>
    <p class="mb-4">Kategori Tryout</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-xl-12 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus-circle"></i> Tambah Kategori</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th width="25%">Total Paket Tryout</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Total Paket Tryout</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($kategori as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ count($value->paket) }}</td>
                            <td>
                                <form action="{{ route('kategori.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('kategori.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('paket.show', $value->slug) }}" class="btn btn-info ">
                                        <i class="fas fa-eye"></i> Paket Tryout
                                    </a>
                                    <button type="button" class="btn btn-danger hapus" data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top" title="Hapus">
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
                {{ $kategori->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Tryout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kategori.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                           <label for="">Nama Kategori</label>
                           <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Role">
                           @error('nama')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label for="">Deskripsi</label>
                           <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" placeholder="Masukkan Deskripsi">
                           @error('deskripsi')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                        <div class="form-group">
                           <label for="">Gambar <small>Opsional</small></label>
                           <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">
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
         text: "Ingin menghapus kategori ini!",
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