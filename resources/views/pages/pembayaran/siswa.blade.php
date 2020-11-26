@extends('layouts.dashboard-app')
@section('title', 'List Pembayaran')

@section('content')
   <h1 class="h3 mb-2 text-gray-800">List Pembayaran</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">List Pembayaran</h6>
                <div class="btn-group btn-group-md">
                   <a class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> List Bank</a>
                </div>
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
                        <td>status</td>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Gelombang</th>
                        <th>Total bayar</th>
                        <th>Tanggal Daftar</th>
                        <td>status</td>
                        <th>Aksi</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($pembayaran as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->gelombang->nama }}</td>
                            <td>Rp. {{ number_format($value->gelombang->harga + $value->kode_transfer) }}</td>
                            <td>{{ Carbon\Carbon::parse($value->created_at)->format('d F Y H:i') }}</td>
                            <td>
                                @if (count($value->pembayaran_bukti) > 0)
                                    @if ($value->status == 1)
                                        <span class="badge badge-warning p-2">Berkas telah diupload</span>
                                    @elseif($value->status == 2)
                                        <span class="badge badge-success p-2">Transfer sudah divalidasi</span>
                                    @endif
                                @else
                                    <span class="badge badge-danger p-2">Balum Upload Bukti Pembayaran</span>
                                @endif
                            </td>
                            <td>
                                @if (count($value->pembayaran_bukti) > 0)
                                    @if ($value->status == 1)
                                        <a href="{{ route('pembayaran.siswa.edit', $value->id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit Bukti Pembayaran">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('pembayaran.siswa.show', ['slug' => $value->gelombang->slug, 'pembayaran_id' => $value->id]) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Upload Bukti Pembayaran">
                                        <i class="fas fa-upload"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data
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