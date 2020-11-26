@extends('layouts.dashboard-app')
@section('title', 'Author')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Author</h1>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="row">
          <div class="col-xl-12 text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus-circle"></i> Tambah Author</button>
          </div>
      </div>
   </div>
   <div class="card-body">
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
                  <th>Nama / Username</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Aksi</th>
               </tr>
            </tfoot>
            <tbody>
               <tr>
                  <td colspan="5" class="text-center">
                     Tidak ada data
                  </td>
               </tr>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="#" id="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Nama / Username</label>
                  <input type="text" class="form-control" name="name" placeholder="Masukkan Nama / Username">
               </div>
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Masukkan Email">
               </div>
               <div class="form-group row">
                  <div class="col-6">
                     <label for="">Password</label>
                     <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                  </div>
                  <div class="col-6">
                     <label for="">Konfirmasi Password</label>
                     <input type="password" class="form-control" placeholder="Konfirmasi Password"
                        name="password_confirmation" id="password_confirmation">
                  </div>
               </div>
               <div class="form-group">
                  <label for="">Foto <small>Opsional</small></label>
                  <input type="file" class="form-control" name="foto" accept="image/*">
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
   $("#form").on('submit', function(e) {
      if($("#password_confirmation").val() != $("#password").val()) {
         swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Password konfirmasi tidak sama',
         })
         return false
      }
      if($("#password").val().length < 8) {
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
@endsection