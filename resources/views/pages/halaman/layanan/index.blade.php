@extends('layouts.dashboard-app')
@section('title', 'Layanan / Produk')

@section('content')
<div class="row">
    <div class="col-10">
        <h1 class="h3 text-gray-800">Layanan / Produk</h1>
        <small class="text-secondary">*Rekomendasi Minimal 3 Layanan</small>
    </div>
</div>
<div class="card shadow mb-4 mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-xl-12 text-right">
                <div class="btn-group btn-group-md">
                    <button data-toggle="modal" data-target="#modalTestimoni" type="button" class="btn btn-primary"><i class="fas fa-fw fa-plus"></i> Buat Layanan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="GET">
            <div class="row mb-4 justify-content-end align-items-center">
                <div class="col-xl-5">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Masukkan Nama Layanan" aria-label="Masukkan Nama Layanan" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                     </div>
                </div>
                <div class="col-xl-auto">
                  <a href="{{ route('layanan.index') }}" class="btn btn-lght text-danger my-1">Refresh</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layanan as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->nama }}</td>
                        <td>
                            <form action="{{ route('layanan.destroy', $value->id) }}" method="POST"
                                id="form-{{ $value->id }}">
                                @csrf
                                @method("DELETE")
                                <a href="{{ route('layanan.edit', $value->id) }}" class="btn btn-success my-1"
                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" data-id="{{ $value->id }}" class="btn btn-danger my-1 hapus"
                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Layanan</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $layanan->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalTestimoni" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Layanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('layanan.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Layanan</label>
                        <input name="nama" type="text"
                            class="form-control form-control-user @error('nama') is-invalid @enderror"
                            id="exampleFirstName" placeholder="Nama Layanan" value="{{ old('nama') }}">
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                     <label for="name">Deskripsi Layanan <small>(85)</small></label>
                     <textarea name="deskripsi" class="form-control" id="deskripsi" maxlength="85">{{ old('layanan') }}</textarea>
                     @error('nama')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                 </div>
                    <div class="form-group">
                        <label for="testimonial">Foto <small>Maksimal 500 Kb</small></label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                              <input type="file"  accept="image/*" name="foto" class="custom-file-input form-control form-control-user @error('foto') is-invalid @enderror" id="thumbLayanan" accept="image/x-png,image/gif,image/jpeg">
                              <label class="custom-file-label" id="labelThumb" for="thumbLayanan">Choose file</label>
                            </div>
                            @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
   const option = {
        filebrowserImageBrowseUrl: '/filemanager?type=Images',
        filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/filemanager?type=Files',
        filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
    }
    $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus layanan ini!",
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
<script type="application/javascript">
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
    $("#thumbLayanan").change(function() {
         if(this.files[0].size > 524000){
             alert("Maaf Foto Kamu Terlalu Besar");
             $("#thumbLayanan").val('');
             $("#labelThumb").text('Choose file');
         }
     });
 </script>
@endsection