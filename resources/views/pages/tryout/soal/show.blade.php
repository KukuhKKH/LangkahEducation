@extends('layouts.dashboard-app')
@section('title', "Soal Try out - ".$paket->nama)

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Soal Try out - {{ $paket->nama }}</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

    <div class="mb-3">
        <a href="{{ asset('template/TemplateUniversitas.xlsx') }}" download="" class="btn btn-success"><i class="fas fa-fw fa-file-excel"></i> Template Soal</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-8">
                   <form action="{{ route('soal.import_batch') }}" method="POST" id="form-import" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                      <div class="form-group">
                         <div class="input-group">
                            <div class="mr-2 d-flex align-items-center">
                               Import Soal
                            </div>
                            <div class="custom-file">
                               <input type="file" name="file" class="custom-file-input" id="inputGroupFile02" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                               <label class="custom-file-label" for="inputGroupFile02">Pilih FIle</label>
                            </div>
                            <div class="input-group-append" id="btn-submit">
                               <button type="submit" class="input-group-text">Upload</button>
                            </div>
                         </div>
                      </div>
                   </form>
                </div>
             </div>
            <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Soal Try out - {{ $paket->nama }}</h6>
                <div class="btn-group btn-group-md mb-3">
                    <a href="{{ route('paket.index') }}" class="btn btn-warning text-dark">Kembali</a>
                    <a href="{{ route('soal.create', $paket->slug) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-plus"></i> Tambah Soal</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Soal</th>
                        <th>Nilai Benar</th>
                        <th>Nilai Salah</th>
                        <th>Tgl Dibuat</th>
                        <th>Tgl Diupdate</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Soal</th>
                        <th>Nilai Benar</th>
                        <th>Nilai Salah</th>
                        <th>Tgl Dibuat</th>
                        <th>Tgl Diupdate</th>
                        <th width="15%">Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($tryout as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ strip_tags($value->soal) }}</td>
                            <td>{{ $value->benar }}</td>
                            <td>{{ $value->salah }}</td>
                            <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($value->updated_at)->format('d F Y') }}</td>
                            <td>
                                <form action="{{ route('soal.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('soal.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger hapus" data-id="{{ $value->id }}" data-toggle="tooltip" data-placement="top" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $tryout->appends($data)->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
   $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus soal ini!",
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