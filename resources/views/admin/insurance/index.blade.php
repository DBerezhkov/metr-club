@extends('layouts.admin_layout')

@section('title', 'Таблица Страховых')

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
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table_dark">
                            <thead>
                            <tr>
                                <th style="width: 5%" class="cent">
                                    #
                                </th>
                                @foreach($insurances as $insurance)
                                    <th class="cent">
                                        {{$insurance['name']}}
                                        <a class="btn btn-primary btn-sm mb-2" href="{{route('insurance.edit', $insurance['id'])}}">
                                            Редактировать
                                        </a>
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Контакты</td>
                                @foreach($insurances as $insurance)
                                    <td>{!! $insurance['contacts'] !!}</td>
                                @endforeach
                            </tr>
                            @foreach($banks as $bank)

                                <tr class="border">
                                    <td><img src="/img/banks/{{ $bank['img'] }}" alt="" width="150"></td>
                                    @foreach($insurances as $insurance)
                                        @php
                                        $r = (array) json_decode($insurance['percents']);
                                        @endphp
                                        <td class="text-center border">
                                            @if(isset($r[$bank['id']])){{ $r[$bank['id']] }} @endif</td>
                                    @endforeach
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
