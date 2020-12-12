@extends('layouts.dashboard-app')
@section('title', 'Author')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Author</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="row">
          <div class="col-xl-12 text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i> Tambah Author</button>
          </div>
      </div>
   </div>
   <div class="card-body">
      <form action="" method="GET">
         <div class="row mb-4 justify-content-end align-items-center">
             <div class="col-xl-5">
                 <div class="input-group">
                     <input type="text" name="keyword" class="form-control" placeholder="Masukkan Nama Author" aria-label="Masukkan Nama Author" aria-describedby="basic-addon2">
                     <div class="input-group-append">
                       <button class="btn btn-primary" type="submit">Cari</button>
                     </div>
                  </div>
             </div>
             <div class="col-xl-auto">
               <a href="{{ route('author.index') }}" class="btn btn-lght text-danger my-1">Refresh</a>
             </div>
         </div>
     </form>
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Aksi</th>
               </tr>
            </tfoot>
            <tbody>
               @forelse ($author as $value)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $value->user->name }}</td>
                  <td>{{ $value->user->email }}</td>
                  <td>{!! ($value->user->is_active == 1) ? '<div class="badge badge-success">Aktif</div>' : '<div class="badge badge-danger">Tidak Aktif</div>'  !!}</div>
                  <td>
                     <form action="{{ route('author.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                           @csrf
                           @method("DELETE")
                           <a href="{{ route('author.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Edit">
                              <i class="fas fa-edit"></i>
                           </a>
                           <button type="button" data-id="{{ $value->id }}" class="btn btn-danger my-1 hapus" data-toggle="tooltip" data-placement="top" title="Hapus">
                              <i class="fas fa-trash"></i>
                           </button>
                     </form>
                  </td>
               </tr>
               @empty
               <tr>
                  <td colspan="5">
                     <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Data Author</h6>
                    </div>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Author</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="#" id="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Nama Lengkap</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Masukkan Nama Lengkap" required>
                  @error('name')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email" required>
                  @error('email')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               {{-- <div class="row">
                  <div class="col-xl-6">
                     <div class="form-group">
                        <label for="">Password</label>
                     <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" id="password" required>
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
                     </div>
                  </div>
                  <div class="col-xl-6">
                     <div class="form-group">
                        <label for="">Konfirmasi Password</label>
                     <input type="password" class="form-control" placeholder="Konfirmasi Password"
                        name="password_confirmation" id="password_confirmation" required>
                     </div>
                  </div>
               </div> --}}
               <div class="form-group">
                  <label for="password">Password</label>
                  <input name="password" name="password" id="password" class="form-control form-control-user" disabled value="123456" required>
                  <small>Password Default</small>
              </div>
               <div class="form-group">
                  <label for="">Foto <small>Opsional</small></label>
                  <div class="input-group mb-3">
                     <div class="custom-file">
                       <input type="file" class="custom-file-input" id="inputGroupFile02" name="foto" accept="image/*">
                       <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                     </div>
                   </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary">Simpan</button>
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
         text: "Ingin menghapus admin ini!",
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
</script>
@endsection