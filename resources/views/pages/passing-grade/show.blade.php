@extends('layouts.dashboard-app')
@section('title', 'Passing Grade - Universitas '.$universitas->nama)

@section('content')
   <div class="row">
      <div class="col-10">
         <h1 class="h3 mb-2 text-gray-800">Passing Grade - Universitas {{ $universitas->nama }}</h1>
      </div>
      <div class="col-2 text-right">
         <a href="{{ asset('template/TemplatePassingGrade.xlsx') }}" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel</a>
      </div>
   </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
               <div class="col-xl-8">
                  <form action="{{ route('passing-grade.import') }}" method="POST" id="form-import" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="universitas_id" value="{{ $universitas->id }}">
                     <div class="form-group">
                        <label for="">Import Data Excel</label>
                        <div class="input-group">
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
               <div class="col-xl-4 text-right">
                  <div class="btn-group btn-group-md">
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fas fa-fw fa-plus"></i> Tambah Passing Grade</button>
                  </div>
               </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="GET">
                <div class="row mb-4 justify-content-end align-items-center">
                    <div class="col-xl-5">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Masukkan Nama Prodi" aria-label="Masukkan Nama Prodi" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                         </div>
                    </div>
                    <div class="col-xl-auto">
                      <a href="{{ route('passing-grade.show', $universitas->id) }}" class="btn btn-lght text-danger my-1">Refresh</a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th width="25%">Prodi</th>
                        <th>Nama Universitas</th>
                        <th>Passing Grade</th>
                        <th>Kategori</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th width="25%">Prodi</th>
                        <th>Nama Universitas</th>
                        <th>Passing Grade</th>
                        <th>Kategori</th>
                        <th width="25%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($passing_grade as $value)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $value->prodi }}</td>
                           <td>{{ $value->universitas->nama }}</td>
                           <td>{{ $value->passing_grade }} %</td>
                           <td>{{ Str::upper($value->kelompok->nama) }}</td>
                           <td>
                              <form action="{{ route('passing-grade.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                 @csrf
                                 @method('DELETE')
                                 <a href="{{ route('passing-grade.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                 </a>
                                 <button type="button" class="btn btn-danger my-1 hapus" data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                 </button>
                              </form>
                           </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="text-center mb-3 p-5 bg-light">
                                    <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                    <h6>Tidak Ada Data Passing Grade</h6>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $passing_grade->appends($data)->links() }}
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
                <form action="{{ route('passing-grade.store') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $universitas->id }}" name="universitas_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Prodi</label>
                            <input type="text" class="form-control @error('prodi') is-invalid @enderror" name="prodi" placeholder="Masukkan Nama Prodi">
                            @error('prodi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                           <label for="">Passing Grade</label>
                           <input type="number" class="form-control @error('passing_grade') is-invalid @enderror" name="passing_grade" step="0.01"  placeholder="Masukkan Passing grade">
                           @error('passing_grade')
                               <span class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror
                       </div>
                       <div class="form-group">
                        <label for="">Kelompok Prodi</label>
                        <select name="kelompok_id" class="form-control @error('kelompok_id') is-invalid @enderror" style="text-transform: uppercase">
                           <option value="" selected disabled>-- Pilih --</option>
                           @foreach ($kelompok as $value)
                                @if ($value->nama != 'campuran')
                                    <option value="{{ $value->id }}">{{$value->nama}}</option>
                                @endif
                           @endforeach
                        </select>
                        @error('kelompok_id')
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

   $('.custom-file input').change(function (e) {
            var files = [];
            for (var i = 0; i < $(this)[0].files.length; i++) {
                files.push($(this)[0].files[i].name);
            }
            $(this).next('.custom-file-label').html(files.join(', '));
    });
</script>
@endsection