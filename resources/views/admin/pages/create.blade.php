@extends('layouts.admin_layout')

@section('title', 'Добавление страницы')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новая страница</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="'alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="'danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-times"></i>{{ session('error') }}</h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('pages.store') }} " method="POST" id='formSnd' enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">Название</label>
                                        <input type="text" value="{{ old('title') }}" class="form-control" id="title" name="title" required>
                                        @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">URL</label>
                                        <input type="text" value="{{ old('slug') }}" class="form-control" id="slug" name="slug" required data-inputmask-regex='[a-zA-Z0-9\-]*' data-mask>
                                        @error('slug')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-12">
                                        <p class="font-weight-bold">Содержимое</p>
                                        <textarea name="content" id="article_text" class="form-control tinyMCE" rows="50">{{ old('content') }}</textarea>
                                        @error('content')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" id="btnSubmit" class="btn btn-success">Добавить страницу</button>
                            </div>
                            <!-- /.card-body -->

                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <style>
        .tox .tox-promotion {
            display: none;
        }
    </style>

@endsection

@section('specialscripts')
    <!-- Page specific script -->
    <script>
        $('[data-mask]').inputmask()

        function urlLit(w,v) {
        var tr='a b v g d e ["zh","j"] z i y k l m n o p r s t u f h c ch sh ["shh","shch"] ~ y ~ e yu ya ~ ["jo","e"]'.split(' ');
        var ww=''; w=w.toLowerCase();
        for(i=0; i<w.length; ++i) {
        cc=w.charCodeAt(i); ch=(cc>=1072?tr[cc-1072]:w[i]);
        if(ch.length<3) ww+=ch; else ww+=eval(ch)[v];}
        return(ww.replace(/[^a-zA-Z0-9\-]/g,'-').replace(/[-]{2,}/gim, '-').replace( /^\-+/g, '').replace( /\-+$/g, ''));
    }

        $(document).ready(function() {
        $('#title').bind('change keyup input click', function(){
            $('#slug').val(urlLit($('#title').val(),0))
        });
    });


        $(document).ready(function() {
            tinymce.init({
                selector: 'textarea#article_text',
                language: 'ru',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'autoresize', 'emoticons'
                ],
                menubar: 'file edit insert view table tools help',
                toolbar: 'undo redo | fontsize blocks | ' +
                    'forecolor bold italic underline backcolor emoticons image| alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat',
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap'); body { font-family:Nunito,sans-serif; font-size:16px } p { margin: 0 }",
                font_size_formats: "8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt",
                resize: true,
                min_height: 400,
                file_picker_callback: (cb, value, meta) => {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.addEventListener('change', (e) => {
                        const file = e.target.files[0];

                        const reader = new FileReader();
                        reader.addEventListener('load', () => {

                            const id = 'blobid' + (new Date()).getTime();
                            const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            const base64 = reader.result.split(',')[1];
                            const blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            cb(blobInfo.blobUri(), { title: file.name });
                        });
                        reader.readAsDataURL(file);
                    });

                    input.click();
                },
                image_description: false,
                paste_as_text: true,
                forced_root_block : 'div'
            });
        });
    </script>
@endsection
