@extends('layouts.admin_layout')

@section('title', 'Настройки')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Настройки</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <a class="btn btn-success mb-4" href="{{route('settings.create')}}">Добавить настройку</a>
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
                                <th>
                                    Значение
                                </th>
                                <th>
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
                                    <td @if($item['is_wysiwyg']) class="text-danger" @endif >
                                        @if($item['is_wysiwyg']) Много текста. Откройте для просмотра @else {{ $item['param'] }} @endif
                                    </td>
                                    <td class="project-actions">
                                        <a class="btn btn-success btn-sm" href="{{route('settings.edit', $item['id'])}}">
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

@section('specialscripts')
    <!-- Page specific script -->
    <script>
        $('[data-mask]').inputmask()
    </script>
@endsection
