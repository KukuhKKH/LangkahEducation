@extends('layouts.dashboard-app')
@section('title', "Edit Soal Try out - ".$soal->paket->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Edit Soal Try out - {{ $soal->paket->nama }}</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Edit Soal Try out - {{ $soal->paket->nama }}</h6>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('soal.update', $soal->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Soal</label>
                        <textarea type="text" class="form-control @error('soal') is-invalid @enderror" name="soal"
                            placeholder="Soal">{{ $soal->soal }}</textarea>
                        @error('soal')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Pembahasan</label>
                        <textarea type="text" class="form-control @error('pembahasan') is-invalid @enderror"
                            name="pembahasan" placeholder="Pembahaasan">{{ $soal->pembahasan }}</textarea>
                        @error('pembahasan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Soal A</label>
                        <textarea type="text" name="pilihan1"
                            class="form-control @error('pilihan1') is-invalid @enderror"
                            placeholder="Soal A">{{ $jawaban[0] }}</textarea>
                        @error('pilihan1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Soal B</label>
                        <textarea type="text" name="pilihan2"
                            class="form-control @error('pilihan2') is-invalid @enderror"
                            placeholder="Soal B">{{ $jawaban[1] }}</textarea>
                        @error('pilihan2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Soal C</label>
                        <textarea type="text" name="pilihan3"
                            class="form-control @error('pilihan3') is-invalid @enderror"
                            placeholder="Soal C">{{ $jawaban[2] }}</textarea>
                        @error('pilihan3')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Soal D</label>
                        <textarea type="text" name="pilihan4"
                            class="form-control @error('pilihan4') is-invalid @enderror"
                            placeholder="Soal D">{{ $jawaban[3] }}</textarea>
                        @error('pilihan4')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Soal E</label>
                        <textarea type="text" name="pilihan5"
                            class="form-control @error('pilihan5') is-invalid @enderror"
                            placeholder="Soal E">{{ $jawaban[4] }}</textarea>
                        @error('pilihan5')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="">Jawaban yang benar</label>
                                <select name="benar" class="form-control @error('benar') is-invalid @enderror"
                                    autocomplete="off">
                                    <option value="" selected disabled>-- Pilih --</option>
                                    <option value="pilihan1" {{ $benar == "pilihan1" ? 'selected' : '' }}>Soal A
                                    </option>
                                    <option value="pilihan2" {{ $benar == "pilihan2" ? 'selected' : '' }}>Soal B
                                    </option>
                                    <option value="pilihan3" {{ $benar == "pilihan3" ? 'selected' : '' }}>Soal C
                                    </option>
                                    <option value="pilihan4" {{ $benar == "pilihan4" ? 'selected' : '' }}>Soal D
                                    </option>
                                    <option value="pilihan5" {{ $benar == "pilihan5" ? 'selected' : '' }}>Soal E
                                    </option>
                                </select>
                                @error('benar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-xl-12">
                            <div class="form-group">
                                <label for="">Benar</label>
                                <input type="number" class="form-control @error('nilai_benar') is-invalid @enderror"
                                    name="nilai_benar" placeholder="Nilai Ketika benar" value="4"
                                    value="{{ $soal->benar }}" required>
                                @error('nilai_benar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="">Salah <span class="text-danger">Tidak perlu menggunakan tanda minus
                                        (-)</span></label>
                                <input type="number" class="form-control @error('nilai_salah') is-invalid @enderror"
                                    name="nilai_salah" placeholder="Nilai Ketika salah" value="1"
                                    value="{{ $soal->salah }}" required>
                                @error('nilai_salah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="tryout_kategori_soal_id">Subbab Soal</label>
                                <select name="tryout_kategori_soal_id"
                                    class="form-control @error('tryout_kategori_soal_id') is-invalid @enderror"
                                    autocomplete="off">
                                    @foreach ($kategori_soal as $value)
                                    @if ($value->id == $soal->kategori_soal->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->nama }}</option>
                                    @else
                                    <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('tryout_kategori_soal_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="text-right">
                                <a href="{{ url()->previous() }}" type="button" class="btn btn-dark">Kembali</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
{{-- <script src="{{ asset('assets/vendor/ckeditor/styles.js') }}"></script> --}}
<script>
    const option = {
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
