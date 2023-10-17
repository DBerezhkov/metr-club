@extends('layouts.partner_layout')

@section('title', 'Лиды')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список лидов</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 5%">
                                    #
                                </th>
                                <th style="width: 15%">
                                    ФИО
                                </th>
                                <th style="width: 15%">
                                    Телефон
                                </th>
                                <th style="width: 40%">
                                    Комментарий
                                </th>
                                <th style="width: 10%">
                                    Дата
                                </th>
                                <th style="width: 5%">
                                    Статус
                                </th>
                                <th style="width: 10%">
                                    Автор
                                </th>
                                <th style="width: 25%">
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leads as $lead)

                                <tr>
                                    <td>
                                        {{ $lead['id'] }}
                                    </td>
                                    <td>
                                        {{ $lead['name'] }}
                                    </td>
                                    <td>
                                        {{ $lead['phone'] }}
                                    </td>
                                    <td>
                                        {{ $lead['comment'] }}
                                    </td>
                                    <td>
                                        {{ $lead['date'] }}
                                    </td>
                                    <td>
                                        {{ $lead->StatusText }}
                                        @if($lead['user_comment'] == '')
                                            <span class="badge badge-danger">!</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $lead->manager['name'] }}
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{route('leads.edit', $lead['id'])}}">
                                            <i class="fas fa-user-edit">
                                            </i>
                                            Открыть
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
