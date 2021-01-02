@extends('layouts.dashboard-app')
@section('title', 'Buat Artikel')

@section('content')
<div class="row">
    <div class="col-10">
        <h1 class="h3 mb-4 text-gray-800">Buat Artikel</h1>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12 text-right">
                    <button class="btn btn-primary" type="submit">
                        Simpan Perubahan</button>
                </div>
                <div class="col-lg-12 mt-4">
                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label for="">Judul Artikel</label>
                        </div>
                        <div class="col-md-10">
                            <input name="judul" type="text"
                                class="form-control form-control-user @error('judul') is-invalid @enderror" id="judul"
                                placeholder="Masukkan Judul Artikel" value="{{ old('judul') }}" required>
                            @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2">
                            <label for="">Thumbnail</label>
                        </div>
                        <div class="col-md-10">
                            <small>Rekomendasi Ukuran 1200x330 , Ukuran Maksimal 2 MB</small>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input form-control form-control-user @error('foto') is-invalid @enderror"
                                        id="foto" name="foto">
                                    @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="">Kategori</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="kategori[]" class="select2 form-control @error('kategori') is-invalid @enderror" id="kategori" multiple="multiple">
                                        @foreach ($kategori as $value)
                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="">Status</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1">Publikasikan</option>
                                        <option value="0">Simpan ke Draf</option>
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="form-group">
                        <textarea type="text" class="konten-textarea form-control @error('isi') is-invalid @enderror" id="isi"
                            name="isi" placeholder="Tulis Artikel">{{ old('isi') }}</textarea>
                        @error('isi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('css')
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/ckeditor/contents.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endsection

@section('js')
{{-- <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/ckeditor/styles.js') }}"></script> --}}
<script src="{{ asset('assets/vendor/select2/dist/js/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // const option = {
    //     filebrowserImageBrowseUrl: '/filemanager?type=Images',
    //     filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=' + $('meta[name="csrf-token"]').attr('content'),
    //     filebrowserBrowseUrl: '/filemanager?type=Files',
    //     filebrowserUploadUrl: '/filemanager/upload?type=Files&_token=' + $('meta[name="csrf-token"]').attr('content')
    // }
    // CKEDITOR.replace('isi', option)
    // CKEDITOR.config.height = 500;
    $(document).ready(function() {
        $("#kategori").select2({
            placeholder: "Pilih Kategori",
            allowClear: true
        })
    })

    const editor_config = {
        selector: 'textarea',
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
        height: 300,
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

    $("#foto").change(function() {
        if(this.files[0].size > 2097152){
            alert("Maaf Gambar Kamu Terlalu Besar");
            $("#foto").val('');
            $('.custom-file-label').html("Choose File");
        }
    });
</script>

<script type="application/javascript">
    $('input[type="file"]').change(function (e) {
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

</script>
@endsection
