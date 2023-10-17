@extends('layouts.admin_layout')

@section('title', 'Новости')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новости</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <a class="btn btn-success mb-4" href="{{route('news.create')}}">Добавить новость</a>
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
                                    Аннотация
                                </th>
                                <th>
                                    Дата
                                </th>
                                <th style="width: 100px;">
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($news as $item)
                                <tr>
                                    <td>
                                        {{ $item['id'] }}
                                    </td>
                                    <td>
                                        {{ $item['title'] }}
                                    </td>
                                    <td>
                                        {{ $item['annotation'] }}
                                    </td>
                                    <td>
                                        {{ $item['created_at'] }}
                                    </td>
                                    <td class="project-actions" style="display: flex; justify-content: flex-end">
                                        <a class="btn btn-success btn-sm" href="{{route('news.edit', $item->id)}}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{route('news.destroy', $item->id)}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="ml-3">
                        {{ $news->links('vendor.pagination.bootstrap-4') }}
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
