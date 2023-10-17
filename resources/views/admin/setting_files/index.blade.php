@extends('layouts.admin_layout')

@section('title', 'Настройки')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Настройки файлов заявок</h1>
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
            <div class="col-md-4">
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Настройка
                                </th>
                                <th class="text-center">
                                    Значение
                                </th>
                                <th class="text-center">
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($settings as $item)
                                <tr>
                                    <td>
                                        {{ $item['id'] }}
                                    </td>
                                    <td>
                                        {{ $item['name'] }}
                                    </td>
                                    <td class="text-center">
                                        <div class="icheck-primary d-inline">
                                            <span class="text-{{ $item->enabled ? 'success' : 'danger' }}">{{ $item->enabled ? 'Да' : 'Нет' }}</span>
                                        </div>
                                    </td>
                                    <td class="project-actions text-center">
                                        <a class="btn btn-success btn-sm" href="{{route('setting_files.edit', $item['id'])}}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

