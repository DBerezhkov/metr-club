@extends('layouts.admin_layout')

@section('title', 'Редактировать настройку')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать настройку</h1>
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
                        <form action="{{ route('settings.update', $settings) }} " method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group col-4">
                                    <label for="exampleInputPassword1">Отображаемое имя</label>
                                    <input type="text" value="{{ $settings->name }}" class="form-control" id="name" name="name" required>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label for="exampleInputPassword1">Настройка (англ)</label>
                                    <input type="text" value="{{ $settings->setting }}" class="form-control" id="setting" name="setting" required>
                                    @error('setting')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-8">
                                    <p class="font-weight-bold">Значение</p>
                                    <input type="checkbox" id="wysiwyg" name="wysiwyg" @if ($settings->is_wysiwyg) checked @endif ><label for="wysiwyg">Красивый текст</label>
                                    <textarea name="param" id="param" class="form-control tinyMCE" rows="10" required>{{ $settings->param }}</textarea>
                                    @error('param')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" id="btnSubmit" class="btn btn-success">Сохранить изменения</button>
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

        $(document).ready(function() {

            if($('#wysiwyg').prop('checked') == true){
                tinyMCEinit()
            }

            function tinyMCEinit() {
                tinymce.init({
                    selector: 'textarea.tinyMCE',
                    language: 'ru',
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'autoresize', 'emoticons'
                    ],
                    menubar: 'edit view tools help',
                    toolbar: 'undo redo | fontsize blocks | ' +
                        'forecolor bold italic underline backcolor emoticons| alignleft aligncenter ' +
                        'alignright alignjustify | bullist numlist outdent indent | ' +
                        'removeformat',
                    content_style: "@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap'); body { font-family:Nunito,sans-serif; font-size:16px } p { margin: 0 }",
                    font_size_formats: "8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt",
                    resize: true,
                    image_description: false,
                    paste_as_text: true,
                    forced_root_block : 'div'
                });
            }

            $('#wysiwyg').change(function(e){
                console.log(e)
                if(e.target.checked) {
                    console.log('checked')
                    tinyMCEinit()
                } else {
                    console.log('unchecked')
                    tinymce.remove("textarea.tinyMCE")
                }
            })
        });
    </script>
@endsection
