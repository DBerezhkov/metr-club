@extends('layouts.admin_layout')

@section('title', 'Добавить КВ для банка')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить КВ для банка</h1>
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
                <div class="col-md-6">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('reward.store') }} " method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Название банка</label>
                                    <textarea name="name" id="name" cols="80" rows="5" class="tiny">{{ old('name') }}</textarea>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Описание</label>
                                    <textarea name="description" id="description" cols="80" rows="5" class="tiny">{{ old('description') }}</textarea>
                                    @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="advanced_description">Дополнительная инфо</label>
                                    <textarea name="advanced_description" id="" cols="80" rows="5" class="tiny">{{ old('advanced_description') }}</textarea>
                                    @error('advanced_description')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="mail_for_demands">Почта для заявок</label>
                                    <textarea name="mail_for_demands" id="mail_for_demands" cols="80" rows="5" class="tiny">{{ old('mail_for_demands') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="curator">Куратор в банке</label>
                                    <textarea name="curator" id="curator" cols="80" rows="5" class="tiny">{{ old('curator') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="lk">Личный кабинет</label>
                                    <textarea name="lk" id="lk" cols="80" rows="5" class="tiny">{{ old('lk') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="bank_contacts">Контакты банка по заявке</label>
                                    <textarea name="bank_contacts" id="bank_contacts" cols="80" rows="5" class="tiny">{{ old('bank_contacts') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="only_text" >
                                    <label for="checkboxBank">
                                        Только текст
                                    </label>
                                    <textarea name="text" id="text" cols="80" rows="5" class="tiny">{{ old('text') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Прикрепите картинку</label>
                                    <input type="file" class="form-control-file mb-2" name="img" id="img" >
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить</button>
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
        $('[data-mask]').inputmask();

        tinymce.init({
            selector: 'textarea.tiny',
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

    </script>
@endsection
