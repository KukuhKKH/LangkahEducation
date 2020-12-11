@extends('layouts.dashboard-app')
@section('title', 'Admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Admin</h1>

<div class="card shadow mb-4">
   <div class="card-header">
      <div class="row align-items-center">
         <div class="col-xl-6">
            <h6 class="m-0 font-weight-bold text-primary">Admin</h6>
         </div>
         <div class="col-xl-6 text-right">
            <button type="button" class="btn btn-primary my-1" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i> Tambah Admin</button>
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
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Aksi</th>
               </tr>
            </tfoot>
            <tbody>
               @forelse($admin as $value)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $value->name }}</td>
                  <td>{{ $value->email }}</td>
                  <td>{!! ($value->is_active == 1) ? '<div class="badge badge-success">Aktif</div>' : '<div
                        class="badge badge-danger">Tidak Aktif</div>' !!}
                  <td>
                     @if (auth()->user()->id != $value->id)
                        <form action="{{ route('admin.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                           @csrf
                           @method("DELETE")
                           <a href="{{ route('admin.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Edit">
                              <i class="fas fa-edit"></i>
                           </a>
                           <button type="button" data-id="{{ $value->id }}" class="btn btn-danger my-1 hapus" data-toggle="tooltip" data-placement="top" title="Hapus">
                              <i class="fas fa-trash"></i>
                           </button>
                        </form>
                     @endif
                  </td>
               </tr>
               @empty
               <tr>
                  <td colspan="5" class="text-center">
                     <div class="text-center mb-3 p-5 bg-light">
                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                        <h6>Tidak Ada Data Admin</h6>
                    </div>
                  </td>
               </tr>
               @endforelse
            </tbody>
         </table>
         {{ $admin->appends($data)->links() }}
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
         <form action="{{ route('admin.store') }}" id="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Nama Lengkap</label>
                  <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap">
               </div>
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Masukkan Email">
               </div>
               <div class="form-group row">
                  <div class="col-xl-6">
                     <label for="">Password</label>
                     <div class="input-group" id="show_password">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                        <div class="input-group-addon d-flex align-items-center">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                          </div>    
                    </div>
                  </div>
                  <div class="col-xl-6">
                     <label for="">Konfirmasi Password</label>
                        <div class="input-group" id="show_password2">
                           <input type="password" class="form-control" placeholder="Konfirmasi Password"
                           name="password_confirmation" id="password_confirmation">
                       </div>
                  </div>
               </div>
               <div class="form-group">
                  <label for="">Foto <small>Opsional</small></label>
                  <div class="input-group mb-3">
                     <div class="custom-file">
                       <input type="file" class="custom-file-input" id="inputGroupFile02">
                       <label class="custom-file-label" for="inputGroupFile02" accept="image/*">Choose file</label>
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
<script type="application/javascript">
   $('input[type="file"]').change(function(e){
       var fileName = e.target.files[0].name;
       $('.custom-file-label').html(fileName);
   });
</script>
<script>
   $(document).ready(function() {
   $("#show_password a").on('click', function(event) {
       event.preventDefault();
       if($('#show_password input').attr("type") == "text"){
           $('#show_password input').attr('type', 'password');
           $('#show_password2 input').attr('type', 'password');
           $('#show_password i').addClass( "fa-eye-slash" );
           $('#show_password i').removeClass( "fa-eye" );
       }else if($('#show_password input').attr("type") == "password"){
           $('#show_password input').attr('type', 'text');
           $('#show_password2 input').attr('type', 'text');
           $('#show_password i').removeClass( "fa-eye-slash" );
           $('#show_password i').addClass( "fa-eye" );
       }
   });
});
</script>
@endsection