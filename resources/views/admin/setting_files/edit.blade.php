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
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('setting_files.update', $setting) }} " method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group col-8">
                                    <label for="exampleInputPassword1">Отображаемое имя</label>
                                    <input type="text" value="{{ $setting->name }}" class="form-control" id="name" name="name" required>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-8">
                                    <label for="exampleInputPassword1">Настройка</label>
                                    <input type="text" value="{{ $setting->setting }}" class="form-control" id="setting" name="setting" disabled>
                                    @error('setting')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @if($setting->setting == 'backup_files')
                                <div class="form-group col-8">
                                    <label for="exampleInputPassword1">Путь резервного копирования</label>
                                    <input type="text" value="{{ $setting->path_to_backup }}" class="form-control" id="path_to_backup" name="path_to_backup">
                                </div>
                                @endif
                                <div class="form-group col-8">
                                    <p class="font-weight-bold">Значение</p>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="form-control" id="enabled" name="enabled"
                                                   value="1" {{ $setting->enabled == 1 ? 'checked' : '' }}>
                                            <label for="enabled">
                                                Включено
                                            </label>
                                        </div>
                                    </div>
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
    </script>
@endsection
