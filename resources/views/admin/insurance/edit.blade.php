@extends('layouts.admin_layout')

@section('title', 'Редактировать страховую')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование страховой {{$insurance->name }}</h1>
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
                    <h4><i class="icon fa fa-check"></i>{{ session('error') }}</h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('insurance.update', $insurance->id) }} " method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                                    <div class="card-body">
                                        @foreach($banks as $bank)
                                        @if(($loop->index == 0) || (($loop->index) % 3 == 0))
                                                <div class="row border mb-3">
                                                    @endif

                                            <div class="col-3">
                                                <img src="/img/banks/{{ $bank['img'] }}" alt="" height="70" class="mw-100 h-70"> <input type="text" name="{{$bank->id}}" class="form-control mb-2" value="@isset($percents[$bank->id]){{$percents[$bank->id]}}@endisset">
                                            </div>

                                                    @if((($loop->index +1) % 3 == 0) || ($loop->index == 2))
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                            <div class="card-body">
                                <textarea name="contacts" class="tinyMCE" cols="80" rows="5">{{$insurance->contacts}}</textarea>
                            </div>
                                    <!-- /.card-body -->


                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
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
        $(document).ready(function() {
            tinymce.init({
                selector: 'textarea.tinyMCE',
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
