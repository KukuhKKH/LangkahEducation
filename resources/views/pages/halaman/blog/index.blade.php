@extends('layouts.dashboard-app')
@section('title', 'Daftar Artikel')

@section('content')
<div class="row">
    <div class="col-10">
        <h1 class="h3 mb-4 text-gray-800">Daftar Artikel</h1>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-xl-12 text-right">
                <div class="btn-group btn-group-md">
                    <a href="{{ route('blog.create') }}" type="button" class="btn btn-primary"><i
                            class="fas fa-fw fa-plus"></i> Buat Artikel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="GET">
            <div class="row mb-4 align-items-center justify-content-between">
                <div class="col-xl-5">
                    @hasanyrole('superadmin|admin')
                    <select class="form-control" name="show">
                        <option value="me">Artikel Saya</option>
                        <option value="all">Semua Artikel</option>
                      </select>
                    @endhasanyrole
                </div>
                <div class="col-xl-5 text-right mt-2">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Masukkan Judul Artikel" aria-label="Masukkan Judul Artikel" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit">Tampil</button>
                        </div>
                     </div>
                </div>
                <div class="col-xl-auto">
                  <a href="{{ route('blog.index') }}" class="btn btn-lght text-danger my-1">Refresh</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th width="25%">Judul</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tanggal Upload</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($artikel as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->judul }}</td>
                        <td>{{ $value->user->name }}</td>
                        <td>
                            @if ($value->status)
                                <div class="badge badge-success">Publish</div>
                            @else
                            <div class="badge badge-danger">Draft</div>
                            @endif
                        </td>
                        <td>{{ date('d F Y', strtotime($value->created_at)) }}</td>
                        <td>
                            <form action="{{ route('blog.destroy', $value->id) }}" method="POST"
                                id="form-{{ $value->id }}">
                                @csrf
                                @method("DELETE")
                                <a href="{{ route('page.blog.detail', $value->slug) }}" class="btn btn-primary my-1"
                                    data-toggle="tooltip" data-placement="top" title="Lihat Artikel">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('blog.edit', $value->id) }}" class="btn btn-success my-1"
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
                        <td colspan="6">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Artikel</h6>
                            </div>

                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th width="25%">Judul</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tanggal Upload</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
            {{ $artikel->links() }}
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(".hapus").on('click', function() {
      Swal.fire({
         title: 'Yakin?',
         text: "Ingin menghapus artikel ini!",
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