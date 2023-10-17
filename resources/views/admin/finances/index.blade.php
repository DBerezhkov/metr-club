@extends('layouts.admin_layout')

@section('title', 'Финансы')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Финансы</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
               <div class="col-md-10">
                   <button type="button" class="btn btn-success mb-3">Добавить запись</button>
                   <p>Текущий баланс:  <span class="bg-success">+2 999 500 руб.</span></p>
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped projects">
                                <thead>
                                <tr>
                                    <th style="width: 5%">
                                        #
                                    </th>
                                    <th style="width: 10%">
                                        Дата
                                    </th>
                                    <th style="width: 10%">
                                        Операция
                                    </th>

                                    <th>
                                        Тип
                                    </th>
                                    <th>
                                        Сумма
                                    </th>
                                    <th>
                                        Комментарий
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr style="background-color: #ffa3a3!important;">
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        01.01.2001
                                    </td>
                                    <td>
                                        Кредит
                                    </td>
                                    <td>
                                        Оплата хостинга
                                    </td>
                                    <td>
                                        -500.00
                                    </td>
                                    <td>
                                        Оплата сервера
                                    </td>

                                </tr>
                                <tr style="background-color: #ffa3a3!important;">
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        02.01.2001
                                    </td>
                                    <td>
                                        Кредит
                                    </td>
                                    <td>
                                        Зарплата
                                    </td>
                                    <td>
                                        -500 000.00
                                    </td>
                                    <td>
                                        Выдача ЗП ВЕКЛИЧ
                                    </td>

                                </tr>
                                <tr class="bg-green">
                                    <td>
                                        3
                                    </td>
                                    <td>
                                        02.02.2001
                                    </td>
                                    <td>
                                        Дебет
                                    </td>
                                    <td>
                                        Выплата от партнёра
                                    </td>
                                    <td>
                                        + 3 500 000.00
                                    </td>
                                    <td>
                                        Выплата от СОВКОМБАНК
                                    </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
