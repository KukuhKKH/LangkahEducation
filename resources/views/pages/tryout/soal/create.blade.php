@extends('layouts.dashboard-app')
@section('title', "Tambah Soal Try out - ".$paket->nama)

@section('content')
   <h1 class="h3 mb-2 text-gray-800">Tambah Soal Try out - {{ $paket->nama }}</h1>
   <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

   <div class="card shadow mb-4">
      <div class="card-header py-3">
          <div class="d-flex justify-content-between mb-1">
          <h6 class="m-0 font-weight-bold text-primary">Tambah Soal Try out - {{ $paket->nama }}</h6>
          </div>
      </div>
      <div class="card-body">
         <form action="{{ route('soal.store') }}" method="post">
            @csrf
            <input type="hidden" name="kategori_id" value="{{ $paket->kategori->id }}">
            <input type="hidden" name="tryout_paket_id" value="{{ $paket->id }}">
            <div class="form-group">
               <label for="">Soal</label>
               <input type="text" class="form-control @error('soal') is-invalid @enderror" name="soal" placeholder="Soal" value="{{ old('soal') }}" required>
               @error('soal')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
            <div class="form-group">
               <label for="">Pembahasan</label>
               <input type="text" class="form-control @error('pembahasan') is-invalid @enderror" name="pembahasan" placeholder="Pembahaasan" value="{{ old('pembahasan') }}" required>
               @error('pembahasan')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
            <div class="form-group">
               <div class="row">
                  <div class="col-6">
                     <label for="">Benar</label>
                     <input type="number" class="form-control @error('nilai_benar') is-invalid @enderror" name="nilai_benar" placeholder="Nilai Ketika benar" value="4" value="{{ old('nilai_benar') }}" required>
                     @error('nilai_benar')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>
                  <div class="col-6">
                     <label for="">Salah <span class="text-danger">Tidak perlu menggunakan tanda minus (-)</span></label>
                     <input type="number" class="form-control @error('nilai_salah') is-invalid @enderror" name="nilai_salah" placeholder="Nilai Ketika salah" value="1" value="{{ old('nilai_salah') }}" required>
                     @error('nilai_salah')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                     @enderror
                  </div>
               </div>
            </div>
            <div class="form-group row">
               <div class="col-6">
                  <label for="">Soal A</label>
                  <input type="text" name="pilihan1" class="form-control @error('pilihan1') is-invalid @enderror" placeholder="Soal A" value="{{ old('pilihan1') }}" required>
                  @error('pilihan1')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-6">
                  <label for="">Soal B</label>
                  <input type="text" name="pilihan2" class="form-control @error('pilihan2') is-invalid @enderror" placeholder="Soal B" value="{{ old('pilihan2') }}" required>
                  @error('pilihan2')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-6">
                  <label for="">Soal C</label>
                  <input type="text" name="pilihan3" class="form-control @error('pilihan3') is-invalid @enderror" placeholder="Soal C" value="{{ old('pilihan3') }}" required>
                  @error('pilihan3')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-6">
                  <label for="">Soal D</label>
                  <input type="text" name="pilihan4" class="form-control @error('pilihan4') is-invalid @enderror" placeholder="Soal D" value="{{ old('pilihan4') }}" required>
                  @error('pilihan4')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-12">
                  <label for="">Soal E</label>
                  <input type="text" name="pilihan5" class="form-control @error('pilihan5') is-invalid @enderror" placeholder="Soal E" value="{{ old('pilihan5') }}" required>
                  @error('pilihan5')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-12">
                  <label for="">Jawaban yang benar</label>
                  <select name="benar" class="form-control @error('benar') is-invalid @enderror">
                     <option value="" selected disabled>-- Pilih --</option>
                     <option value="pilihan1">Soal A</option>
                     <option value="pilihan2">Soal B</option>
                     <option value="pilihan3">Soal C</option>
                     <option value="pilihan4">Soal D</option>
                     <option value="pilihan5">Soal E</option>
                  </select>
                  @error('benar')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
            </div>
            <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary" >Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
   </div>
@endsection

@section('js')
@endsection