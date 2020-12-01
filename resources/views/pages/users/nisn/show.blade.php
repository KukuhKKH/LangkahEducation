@extends('layouts.dashboard-app')
@section('title', 'NISN')

@section('content')
<div class="row">
   <div class="col-8">
       <h1 class="h3 mb-4 text-gray-800">NISN</h1>
   </div>
   <div class="col-4 text-right">
       <a href="{{ asset('template/TemplateNISNSiswa.xlsx') }}" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel NISN Siswa</a>
   </div>
</div>

<div class="card shadow mb-4">
   <div class="card-header py-3">
      <div class="row">
         <div class="col-8">
             <form action="{{ route('sekolah.nisn.import') }}" method="POST" enctype="multipart/form-data">
             @csrf
             <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
                 <div class="form-group">
                     <div class="input-group">
                         <div class="mr-2 d-flex align-items-center">
                             Import Data Excel 
                         </div>
                         <div class="custom-file">
                             <input type="file" name="file" class="custom-file-input" id="inputGroupFile02">
                             <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                         </div>
                         <div class="input-group-append">
                             <button type="submit" class="input-group-text" id="">Upload</button>
                         </div>
                     </div>
                 </div>
             </form>
         </div>
         <div class="col-4 text-right">
             <div class="btn-group btn-group-md">
                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus-circle"></i> Tambah NISN</button>
             </div>
         </div>
     </div>
      <div class="d-flex justify-content-between">
         <h6 class="m-0 font-weight-bold text-primary">NISN</h6>
      </div>
   </div>
   <div class="card-body">
      <form action="" method="get">
         <div class="row mb-4">
             <div class="col-md-6">
                 <input type="text" class="form-control" name="keyword" placeholder="Masukkan nisn">
             </div>
             <div class="col-md-2">
                 <button type="submit" class="btn btn-primary">Cari</button>
                 <a href="{{ route('nisn.show', $sekolah->id) }}" class="btn btn-danger">Hapus Filter</a>
             </div>
         </div>
     </form>
      <div class="table-responsive">
         <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
               <tr>
                  <th>No</th>
                  <th>NISN</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tfoot>
               <tr>
                  <th>No</th>
                  <th>NISN</th>
                  <th>Aksi</th>
               </tr>
            </tfoot>
            <tbody>
               @forelse($nisn_siswa as $value)
               <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $value->nisn }}</td>
                  <td>
                     <form action="{{ route('nisn.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                        @csrf
                        @method("DELETE")
                        <a href="{{ route('nisn.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
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
                  <td colspan="3" class="text-center">
                     Tidak ada data
                  </td>
               </tr>
               @endforelse
            </tbody>
         </table>
         {{ $nisn_siswa->appends($data)->links() }}
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
         <form action="{{ route('nisn.store') }}" id="form" method="post">
            @csrf
            <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}">
            <div class="modal-body">
               <div class="form-group">
                  <label for="">NISN</label>
                  <input type="text" class="form-control" name="nisn" placeholder="Masukkan NISN">
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

@section('js')
<script>
   $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus nisn ini!",
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