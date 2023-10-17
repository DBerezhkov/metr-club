@extends('layouts.admin_layout')

@section('title', 'Шаблоны писем')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Шаблоны писем</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->

    </div>

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
                @if (session('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
            </div>
                @endif
                @if (session('error'))
            <div class="alert alert-danger" role="danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                <h4><i class="icon fa fa-times"></i>{{ session('error') }}</h4>
            </div>
                @endif
            <div class="col-md-4">
                <a class="btn btn-success mb-4" href="{{route('demands_templates.create')}}">Добавить шаблон</a>
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
                                    Наименование
                                </th>
                                <th>
                                    Активен
                                </th>
                                <th>
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($templates as $template)
                                <tr>
                                    <td>
                                        {{ $template['id'] }}
                                    </td>
                                    <td>
                                        {{ $template['name'] }}
                                    </td>
                                    <td>
                                        @if ($template['enabled']) <span class="text-green">Да</span> @else <span class="text-red">Нет</span>@endif
                                    </td>
                                    <td class="project-actions" style="display: flex">
                                        <a class="btn btn-success btn-sm" href="{{route('demands_templates.edit', $template['id'] )}}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @if($template['id'] != 1)
                                        <form method="POST" action="{{ route('demands_templates.destroy', $template['id'])}}" class="ml-3">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                        @endif
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

