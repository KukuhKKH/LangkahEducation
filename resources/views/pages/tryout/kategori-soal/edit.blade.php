@extends('layouts.dashboard-app')
@section('title', "Kategori Soal Tryout - ".$kategori->nama)

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Edit Kategori Soal Tryout - {{ $kategori->nama }}</h1>

   <div class="card shadow mb-4">
      <div class="card-header py-3">
          <div class="d-flex justify-content-between mb-1">
          <h6 class="m-0 font-weight-bold text-primary">Edit Kategori Soal Tryout - {{ $kategori->nama }}</h6>
          </div>
      </div>
      <div class="card-body">
         <form action="{{ route('kategori-soal.update', $kategori->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="jenis">Jenis Kategori</label>
                <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" autocomplete="off">
                    <option value="tps" {{ $kategori->jenis == 'tps' ? 'selected' : '' }}>TPS</option>
                    <option value="tka" {{ $kategori->jenis == 'tka' ? 'selected' : '' }}>TKA</option>
                </select>
                @error('nama')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="tipe">Tipe Kategori</label>
                <select name="tipe" class="form-control @error('tipe') is-invalid @enderror" autocomplete="off">
                    <option value="umum" {{ $kategori->tipe == 'umum' ? 'selected' : '' }}>UMUM</option>
                    <option value="saintek" {{ $kategori->tipe  == 'saintek' ? 'selected' : '' }}>SAINTEK</option>
                    <option value="soshum" {{ $kategori->tipe == 'soshum' ? 'selected' : '' }}>SOSHUM</option>
                </select>
                @error('nama')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
               <label for="nama">Nama Kategori</label>
               <input name="nama" type="text" class="form-control form-control-user @error('nama') is-invalid @enderror" id="namaKategori" placeholder="Nama Kategori" value="{{ $kategori->nama }}" required>
               @error('nama')
               <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
               @enderror
           </div>
           <div class="form-group">
               <label for="kode">Kode Kategori </label><small class="text-danger ml-2">*Huruf Kapital</small>
               <input name="kode" type="text" class="form-control form-control-user @error('kode') is-invalid @enderror" id="kodeKategori" placeholder="Nama Kategori" value="{{ $kategori->kode }}" required>
               @error('kode')
               <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
               @enderror
           </div>
           <div class="form-group">
               <label for="waktu">Waktu Pengerjaan <small class="text-danger">*Dalam menit</small></label>
               <div class="input-group">
                   <input name="waktu" type="number" class="form-control form-control-user clockpicker @error('waktu') is-invalid @enderror" id="waktuSoal" placeholder="Waktu Pengerjaan" value="{{ $kategori->waktu }}" required>
               </div>
               @error('waktu')
               <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
               @enderror
           </div>
            <div class="text-right">
                <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary" >Kembali</a>
            <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
      </div>
   </div>
@endsection