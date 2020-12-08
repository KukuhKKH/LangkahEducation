@extends('layouts.dashboard-app')
@section('title', 'Tambah Permission')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between mb-1">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Permission</h6>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('permission.store') }}" method="POST">
                @csrf
                <?php $j = 0; ?>
                @for($i = 0; $i < $total; $i++)
                <div class="form-group">
                    <label for="">Permission ke-{{ ++$j }}</label>
                    <input type="text" class="form-control" name="permission[]" placeholder="Masukkan Permission">
                </div>
                @endfor
                <div class="text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
