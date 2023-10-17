@extends('layouts.partner_layout')

@section('title', 'Пикассо')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Мои рисунки</h1>
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
                                    Клиент
                                </th>
                                <th style="width: 15%">
                                    Банки
                                </th>
                                <th style="width: 15%">
                                    Желаемая должность
                                </th>
                                <th style="width: 15%">
                                    Дата
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pics as $pic)

                                <tr>
                                    <td>
                                        {{ $pic['id'] }}
                                    </td>
                                    <td>
                                        {{ $pic['clientname'] }}
                                    </td>
                                    <td>
                                        {{ $pic['banks'] }}
                                    </td>
                                    <td>
                                        {{ $pic['position'] }}
                                    </td>
                                    <td>
                                        {{ $pic['created_at'] }}
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
