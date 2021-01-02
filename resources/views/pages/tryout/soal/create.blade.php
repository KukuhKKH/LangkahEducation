@extends('layouts.dashboard-app')
@section('title', "Tambah Soal Try out - ".$paket->nama)

@section('content')
<h1 class="h3 mb-2 text-gray-800">Tambah Soal Try out - {{ $paket->nama }}</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Soal Try out - {{ $paket->nama }}</h6>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('soal.store') }}" method="post">
            @csrf
            <input type="hidden" name="tryout_paket_id" value="{{ $paket->id }}">
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Soal</label>
                        <textarea type="text" class="daditiny form-control @error('soal') is-invalid @enderror" id="soal"
                            name="soal" placeholder="Soal">{{ old('soal') }}</textarea>
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
                        <textarea type="text" class="daditiny form-control @error('pembahasan') is-invalid @enderror"
                            id="pembahasan" name="pembahasan"
                            placeholder="Pembahaasan">{{ old('pembahasan') }}</textarea>
                        @error('pembahasan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Jawaban A</label>
                        <textarea type="text" name="pilihan1" id="pilihan1"
                            class="form-control daditiny @error('pilihan1') is-invalid @enderror"
                            placeholder="Jawaban A">{{ old('pilihan1') }}</textarea>
                        @error('pilihan1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Jawaban B</label>
                        <textarea type="text" name="pilihan2" id="pilihan2"
                            class="form-control daditiny @error('pilihan2') is-invalid @enderror"
                            placeholder="Jawaban B">{{ old('pilihan2') }}</textarea>
                        @error('pilihan2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Jawaban C</label>
                        <textarea type="text" name="pilihan3" id="pilihan3"
                            class="form-control daditiny @error('pilihan3') is-invalid @enderror"
                            placeholder="Jawaban C">{{ old('pilihan3') }}</textarea>
                        @error('pilihan3')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Jawaban D</label>
                        <textarea type="text" name="pilihan4" id="pilihan4"
                            class="form-control daditiny @error('pilihan4') is-invalid @enderror"
                            placeholder="Jawaban D">{{ old('pilihan4') }}</textarea>
                        @error('pilihan4')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="">Jawaban E</label>
                        <textarea type="text" name="pilihan5" id="pilihan5"
                            class="form-control daditiny @error('pilihan5') is-invalid @enderror"
                            placeholder="Jawaban E">{{ old('pilihan5') }}</textarea>
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
                        {{-- <div class="col-xl-12">
                            <div class="form-group">
                                <label for="">Benar</label>
                                <input type="number" class="form-control @error('nilai_benar') is-invalid @enderror"
                                    name="nilai_benar" placeholder="Nilai Ketika benar" value="4"
                                    value="{{ old('nilai_benar') }}" required>
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
                                    name="nilai_salah" placeholder="Nilai Ketika salah" value="{{ old('nilai_salah') ?? 1 }}" required>
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
                                    <option value="{{ $value->id }}">{{ $value->nama }}</option>
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
                              <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('css')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/ckeditor/contents.css') }}"> --}}
@endsection

@section('js')
{{-- <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/ckeditor/styles.js') }}"></script> --}}
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script>
    const TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    // const URL_LFM = "{{ url('/') }}";
    // const option = {
    //     filebrowserImageBrowseUrl: URL_LFM +'/filemanager?type=Images',
    //     filebrowserImageUploadUrl: URL_LFM +'/filemanager/upload?type=Images&_token='+TOKEN,
    //     filebrowserBrowseUrl: URL_LFM +'/filemanager?type=Files',
    //     filebrowserUploadUrl: URL_LFM +'/filemanager/upload?type=Files&_token='+TOKEN
    // }

    // $(document).ready(function() {
    //     CKEDITOR.replace('soal', option)
    //     CKEDITOR.replace('pembahasan', option)
    //     CKEDITOR.replace('pilihan1', option)
    //     CKEDITOR.replace('pilihan2', option)
    //     CKEDITOR.replace('pilihan3', option)
    //     CKEDITOR.replace('pilihan4', option)
    //     CKEDITOR.replace('pilihan5', option)
    // })

    const editor_config = {
        selector: '.daditiny',
        directionality: document.dir,
        path_absolute: "/",
        menubar: 'edit insert view format table',
        plugins: [
            "advlist autolink lists link image charmap preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media save table contextmenu directionality",
            "paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | formatselect styleselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | fullscreen code",
        relative_urls: false,
        language: document.documentElement.lang,
        height: 200,
        paste_data_images: true,
        // images_upload_url: "/filemanager/upload?type=Images&_token=" + $('meta[name="csrf-token"]').attr('content'),
        file_browser_callback : function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body').clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body').clientHeight;

            var cmsURL = editor_config.path_absolute + 'filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images&_token=" + $('meta[name="csrf-token"]').attr('content')
            } else {
                cmsURL = cmsURL + "&type=Files&_token=" + $('meta[name="csrf-token"]').attr('content')
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        },
        paste_preprocess: async function(plugin, args) {
            let editor = tinyMCE.activeEditor
            editor.selection.collapse()
            let url_blob = args.content
            let match_string = url_blob.match(/"([^']+)"/)[1]
            let size_blob = await fetch(match_string).then(r => r.blob())
            if(size_blob.size > 1000000) {
                Swal.fire('Error!','Maaf Gambar Harus Kurang dari 1 MB','error')
                $(editor.dom.doc).find('img[src^="'+match_string+'"]').remove()
            }
        }
    }

    tinymce.init(editor_config)

</script>
@endsection
