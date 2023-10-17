@extends('layouts.admin_layout')

@section('title', 'Таблица КВ')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Таблица КВ</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('reward.create') }}">
                    Добавить банк
                </a>
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <th style="width: 5%">
                                    Банк
                                </th>
                                <th>
                                    КВ
                                </th>
                                <th>
                                    Дополнительная инфо/Инструкции
                                </th>
                                <th style="width: 13%">
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rewards as $reward)

                                <tr>
                                    <td>
                                        {{ $reward['id'] }}
                                    </td>
                                    <td>
                                        <img src="/img/banks/{{ $reward['img'] }}" alt="" width="100">
                                    </td>
                                    <td>
                                        {!!  $reward['description']  !!}
                                    </td>
                                    <td>
                                        {!! $reward['advanced_description'] !!}
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm mb-2" href="{{route('reward.edit', $reward['id'])}}">
                                            Редактировать
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
    <style>
        p {
            margin: 0;
        }
    </style>
@endsection

@section('specialscripts')
    <!-- Page specific script -->
    <script>
        $('[data-mask]').inputmask()
    </script>
@endsection
