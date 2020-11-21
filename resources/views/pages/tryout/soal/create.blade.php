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
               <textarea type="text" class="form-control @error('soal') is-invalid @enderror" id="soal" name="soal" placeholder="Soal">{{ old('soal') }}</textarea>
               @error('soal')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
            <div class="form-group">
               <label for="">Pembahasan</label>
               <textarea type="text" class="form-control @error('pembahasan') is-invalid @enderror" id="pembahasan" name="pembahasan" placeholder="Pembahaasan">{{ old('pembahasan') }}</textarea>
               @error('pembahasan')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
            <div class="form-group row">
               <div class="col-6">
                  <label for="">Jawaban A</label>
                  <textarea type="text" name="pilihan1" id="pilihan1" class="form-control @error('pilihan1') is-invalid @enderror" placeholder="Jawaban A">{{ old('pilihan1') }}</textarea>
                  @error('pilihan1')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-6">
                  <label for="">Jawaban B</label>
                  <textarea type="text" name="pilihan2" id="pilihan2" class="form-control @error('pilihan2') is-invalid @enderror" placeholder="Jawaban B">{{ old('pilihan2') }}</textarea>
                  @error('pilihan2')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-6">
                  <label for="">Jawaban C</label>
                  <textarea type="text" name="pilihan3" id="pilihan3" class="form-control @error('pilihan3') is-invalid @enderror" placeholder="Jawaban C">{{ old('pilihan3') }}</textarea>
                  @error('pilihan3')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-6">
                  <label for="">Jawaban D</label>
                  <textarea type="text" name="pilihan4" id="pilihan4" class="form-control @error('pilihan4') is-invalid @enderror" placeholder="Jawaban D">{{ old('pilihan4') }}</textarea>
                  @error('pilihan4')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-12">
                  <label for="">Jawaban E</label>
                  <textarea type="text" name="pilihan5" id="pilihan5" class="form-control @error('pilihan5') is-invalid @enderror" placeholder="Jawaban E">{{ old('pilihan5') }}</textarea>
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
            <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary" >Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
   </div>
@endsection

@section('css')
   {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/ckeditor/contents.css') }}"> --}}
@endsection

@section('js')
   <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
   {{-- <script src="{{ asset('assets/vendor/ckeditor/styles.js') }}"></script> --}}
   <script>
      const option =  {
         filebrowserImageBrowseUrl: '/filemanager?type=Images',
         filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
         filebrowserBrowseUrl: '/filemanager?type=Files',
         filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
      }

      CKEDITOR.replace('soal', option)
      CKEDITOR.replace('pembahasan', option)
      CKEDITOR.replace('pilihan1', option)
      CKEDITOR.replace('pilihan2', option)
      CKEDITOR.replace('pilihan3', option)
      CKEDITOR.replace('pilihan4', option)
      CKEDITOR.replace('pilihan5', option)
   </script>
@endsection