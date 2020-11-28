@extends('layouts.dashboard-app')
@section('title', 'Gambar ')

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Gambar Soal</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
         <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Gambar Soal</h6>
            <div class="btn-group btn-group-md">
               <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i> Tambah Gambar</button>
            </div>
         </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Gambar</th>
                        <th>Gambar</th>
                        <th>Tag Html</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Gambar</th>
                        <th>Gambar</th>
                        <th>Tag Html</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($gambar as $value)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $value->nama }}</td>
                           <td><img src="{{ asset("upload/soal/$value->gambar") }}" alt="{{ $value->gambar }}" width=100></td>
                           <td>
                              {{ '<img src="'.asset("upload/soal/$value->gambar").'" alt="'.$value->gambar.'" width=100>' }}
                           </td>
                           <td>
                              <form action="{{ route('gambar.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                 @csrf
                                 @method("DELETE")
                                 <a href="{{ route('gambar.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
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
                {{ $gambar->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ route('gambar.store') }}" id="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Nama Gambar</label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Gambar">
                  @error('nama')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="form-group">
                  <label for="">Foto</label>
                  <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" accept="image/*">
                  @error('foto')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>

@endsection

@section('css')
   <link rel="stylesheet" href="{{ asset('assets/vendor/fluidbox/fluidbox.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('assets/vendor/fluidbox/jquery.fluidbox.min.js') }}"></script>
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
</script>
@endsection