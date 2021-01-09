@extends('layouts.dashboard-app')
@section('title', 'List Pembayaran')

@section('content')
   <h1 class="h3 mb-2 text-gray-800">List Pembayaran</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">List Pembayaran</h6>
             </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Gelombang</th>
                        <th>Total bayar</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Gelombang</th>
                        <th>Total bayar</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($pembayaran as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->gelombang->nama }}</td>
                            <td>
                                @if ($value->gelombang->harga == 0)
                                {{"GRATIS"}}
                                @else
                                Rp. {{ number_format($value->gelombang->harga + $value->kode_transfer) }}
                                @endif
                            </td>
                            <td>{{ Carbon\Carbon::parse($value->created_at)->format('d F Y H:i') }}</td>
                            <td>
                                @if (count($value->pembayaran_bukti) > 0)
                                    @if ($value->status == 1)
                                        <span class="badge badge-warning p-2">Berkas telah diupload</span>
                                    @elseif($value->status == 2)
                                        <span class="badge badge-success p-2">Transfer sudah divalidasi</span>
                                    @elseif($value->status == 3)
                                        <span class="badge badge-danger p-2">Transfer ditolak</span>
                                    @endif
                                @else
                                    @if($value->status == 3)
                                        <span class="badge badge-danger p-2">Transfer ditolak</span>
                                    @else
                                        <span class="badge badge-danger p-2">Belum Upload Bukti Pembelian</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($value->status != 3)
                                    @if (count($value->pembayaran_bukti) > 0)
                                        @if ($value->status == 1)
                                            <a href="{{ route('pembayaran.siswa.edit', $value->id) }}" class="btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Edit Bukti Pembayaran">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if ($value->status == 3)
                                            <a href="{{ route('pembayaran.siswa.edit', $value->id) }}" class="btn btn-warning my-1" data-toggle="tooltip" data-placement="top" title="Upload ulang Pembayaran">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    @else
                                        <form action="{{ route('pembayaran.siswa.destroy', $value->id) }}" id="form-{{ $value->id }}">
                                            <a href="{{ url('dashboard/pembayaran/'.$value->id.'/detail') }}" class="btn btn-primary my-1" data-toggle="tooltip" data-placement="top" title="Upload Pembayaran">
                                                <i class="fas fa-upload"></i>
                                            </a>
                                            {{-- <a href="{{ route('pembayaran.siswa.show', ['slug' => $value->gelombang->slug, 'pembayaran_id' => $value->id]) }}" class="btn btn-secondary my-1" data-toggle="tooltip" data-placement="top" title="Upload Bukti Pembayaran">
                                                <i class="fas fa-upload"></i>
                                            </a> --}}
                                            <button type="button" class="btn btn-danger my-1 batal" data-toggle="tooltip" data-placement="top" title="Batal Beli Produk" data-id="{{ $value->id }}">
                                                <i class="fas fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <?php $bukti = $value->pembayaran_bukti->first()->bukti; ?>
                                    <a href="{{ asset("upload/bukti/$bukti") }}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat Bukti Pembayaran">
                                       <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="text-center mb-3 p-5 bg-light">
                                    <img class="mb-3" height="50px" src="{{asset('assets/img/null-icon.svg')}}" alt="">
                                    <h6>Tidak Ada Pembayaran</h6>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $pembayaran->appends($data)->links() }}
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(".batal").on('click', function() {
            Swal.fire({
                title: 'Yakin?',
                text: "Ingin membatalkan membeli produk ini!",
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