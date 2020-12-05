@extends('layouts.dashboard-app')
@section('title', "Soal Try out - ".$paket->nama)

@section('content')
<div class="row mb-4">
    <div class="col-xl-6">
        <h1 class="h3 text-gray-800">Soal Try out - {{ $paket->nama }}</h1>
    </div>
    <div class="col-xl-6 text-right">
        <a href="{{ asset('template/TemplateSoalBatch.xlsx') }}" download="" class="btn btn-success my-1"><i
                class="fas fa-fw fa-file-excel"></i> Template Soal</a>
        <button type="button" class="btn btn-info my-1" data-toggle="modal" data-target="#modalData"><i
                class="fa fa-eye"></i> Daftar ID Kategori</button>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('soal.import_batch') }}" method="POST" id="form-import"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="mr-2 d-flex align-items-center">
                                Import Soal
                            </div>
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="inputGroupFile02"
                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                    required>
                                <label class="custom-file-label" for="inputGroupFile02">Pilih FIle</label>
                            </div>
                            <div class="input-group-append" id="btn-submit">
                                <button type="submit" class="input-group-text">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-right">
                <div class="btn-group btn-group-md mb-3">
                    <a href="{{ route('soal.create', $paket->slug) }}" class="btn btn-primary"><i
                            class="fa fa-plus"></i> Tambah Soal</a>
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
                        <th>Soal</th>
                        <th>Kategori Soal</th>
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
                        <th>Kategori Soal</th>
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
                        <td>{{ $value->kategori_soal->kode }}</td>
                        <td>{{ $value->benar }}</td>
                        <td>{{ $value->salah }}</td>
                        <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d F Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($value->updated_at)->format('d F Y') }}</td>
                        <td>
                            <form action="{{ route('soal.destroy', $value->id) }}" method="POST"
                                id="form-{{ $value->id }}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('soal.edit', $value->id) }}" class="btn btn-success my-1"
                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger hapus my-1" data-id="{{ $value->id }}"
                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Soal</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $tryout->appends($data)->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Kategori Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paket_soal as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->nama }}</td>
                                <td>{{ $value->kode }}</td>
                                <td>{{ $value->waktu }} Menit</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center mb-3 p-5 bg-light">
                                        <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                        <h6>Tidak Ada Soal</h6>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(".hapus").on('click', function () {
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
    });
    $('.custom-file input').change(function (e) {
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));
    });

</script>
@endsection
