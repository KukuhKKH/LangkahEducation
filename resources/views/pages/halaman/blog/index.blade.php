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
                            class="fas fa-fw fa-plus-circle"></i> Buat Artikel</a>
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
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($artikel as $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->judul }}</td>
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
                        <td colspan="5">
                            <div class="text-center mb-3 p-5 bg-light">
                                <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                <h6>Tidak Ada Testimonial</h6>
                            </div>

                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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