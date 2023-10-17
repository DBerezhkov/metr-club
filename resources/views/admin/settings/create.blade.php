@extends('layouts.admin_layout')

@section('title', 'Добавление новости')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новая настройка</h1>
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
                        <form action="{{ route('settings.store') }} " method="POST" id='formSnd' enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">Отображаемое имя</label>
                                        <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name" required>
                                        @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">Настройка (англ)</label>
                                        <input type="text" value="{{ old('setting') }}" class="form-control" id="setting" name="setting" required>
                                        @error('setting')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-8">
                                        <p class="font-weight-bold">Значение</p>
                                        <textarea name="param" id="param" class="form-control" rows="10" required>{{ old('param') }}</textarea>
                                        @error('param')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                <button type="submit" id="btnSubmit" class="btn btn-success">Добавить настройку</button>
                            </div>


                            <!-- /.card-body -->

                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('specialscripts')
    <!-- Page specific script -->
    <script>
        $('[data-mask]').inputmask()
        $(document).ready(function() {
            $('.is_wysiwyg').click(function (){
                $('.param').toggle()
            });
        });
    </script>
@endsection
