@extends('layouts.dashboard-app')
@section('title', "Paket Try out - ".$kategori->nama)

@section('content')
    <div class="row">
        <div class="col-10">
            <h1 class="h3 mb-2 text-gray-800">Paket Try out - {{ $kategori->nama }}</h1>
        </div>
        <div class="col-2 text-right">
            <a href="#" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Excel</a>
        </div>
    </div>
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-xl-4">
                    <a href="{{ route('kategori.index') }}" class="btn btn-light">&larr; Kembali</a>
                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-xl-8 ">
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
                        </div>
                        <div class="col-xl-4 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus-circle"></i> Tambah Paket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Status</th>
                        <th>Total Soal Tryout</th>
                        <th width="20%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Status</th>
                        <th>Total Soal Tryout</th>
                        <th width="20%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($paket as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>
                                @if ($value->status)
                                    <span class="badge badge-success p-2">Aktif</span>
                                @else
                                    <span class="badge badge-danger p-2">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ count($value->soal) }}</td>
                            <td>
                                <form action="{{ route('paket.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('paket.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('soal.show', $value->slug) }}" class="btn btn-warning my-1 text-dark">
                                        <i class="fas fa-plus"></i> Soal Tryout
                                    </a>
                                    <button type="button" class="btn btn-danger my-1 hapus" data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Paket Soal</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $paket->appends($data)->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Paket Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('paket.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="tryout_kategori_id" value="{{ $kategori->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                           <label for="">Nama Paket Soal</label>
                           <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Paket Soal">
                           @error('nama')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                               <option value="1">Aktif</option>
                               <option value="0">Tidak Aktif</option>
                            </select>
                            @error('status')
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
         text: "Ingin menghapus paket ini!",
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