@extends('layouts.dashboard-app')
@section('title', 'Passing Grade - Universitas')

@section('content')
   <div class="row">
      <div class="col-10">
         <h1 class="h3 mb-2 text-gray-800">Passing Grade - Universitas</h1>
      </div>
      <div class="col-2 text-right">
         <a href="{{ asset('template/TemplateUniversitas.xlsx') }}" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel</a>
      </div>
   </div>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
               <div class="col-8">
                  <form action="{{ route('universitas.import') }}" method="POST" id="form-import" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                        <div class="input-group">
                           <div class="mr-2 d-flex align-items-center">
                              Import Data Excel 
                           </div>
                           <div class="custom-file">
                              <input type="file" name="file" class="custom-file-input" id="inputGroupFile02" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                              <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                           </div>
                           <div class="input-group-append" id="btn-submit">
                              <button type="submit" class="input-group-text">Upload</button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="col-4 text-right">
                  <div class="btn-group btn-group-md">
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus-circle"></i> Tambah Universitas</button>
                  </div>
               </div>
            </div>
         <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Passing Grade - Universitas</h6>
         </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Total Prodi</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Total Prodi</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($universitas as $value)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $value->nama }}</td>
                           <td>{{ count($value->passing_grade) }}</td>
                           <td>
                              <form action="{{ route('universitas.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                 @csrf
                                 @method('DELETE')
                                 <a href="#" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                 </a>
                                 <a href="{{ route('passing-grade.show', $value->id) }}" class="btn btn-secondary">Tamah Prodi</a>
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
                {{ $universitas->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('universitas.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Universitas</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Universitas">
                            @error('nama')
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


@section('js')
<script>
   $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus pendaftaran ini!",
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