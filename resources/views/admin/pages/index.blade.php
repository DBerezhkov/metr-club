@extends('layouts.admin_layout')

@section('title', 'Страницы')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Страницы</h1>
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
            <div class="col-md-12">
                <a class="btn btn-success mb-4" href="{{route('pages.create')}}">Добавить страницу</a>
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th >
                                    Заголовок
                                </th>
                                <th >
                                    УРЛ
                                </th>
                                <th >
                                    Дата
                                </th>
                                <th>
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $item)
                                <tr>
                                    <td>
                                        {{ $item['id'] }}
                                    </td>
                                    <td>
                                        {{ $item['title'] }}
                                    </td>
                                    <td>
                                        {{ $item['slug'] }}
                                    </td>
                                    <td>
                                        {{ $item['created_at'] }}
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-success btn-sm" href="{{route('pages.edit', $item->id)}}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="{{route('pages.destroy', $item->id)}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="ml-3">
                        {{ $pages->links('vendor.pagination.bootstrap-4') }}
                        </div>
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
    </script>
@endsection
