@extends('layouts.admin_layout')

@section('title', 'Главная')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Админ-панель</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- ./col -->
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$demands_today}}</h3>
                            <p>Заявок сегодня</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$demands_yesterday}}</h3>
                            <p>Заявок вчера</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$demands}}</h3>
                            <p>Заявок в месяце</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$users}} ({{$usersall}})</h3>

                            <p>Агентов</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$count_registration_today}} ({{$count_registration_yesterday}})</h3>

                            <p>Регистраций</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <!-- small box -->
                    <div class="small-box bg-fuchsia">
                        <div class="inner">
                            <h3>{{$usersactive}}</h3>

                            <p>Активных за месяц</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ribbon-a"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($banks_stat as $tmp)
                <div class="col-lg-12 col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Статистика @if($loop->index == 0) за текущий квартал@else за {{$quarter - 1}} квартала этого года @endif</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="stackedBarChart_{{$loop->index}}" style="min-height: 305px; height: 305px; max-height: 305px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                @endforeach
                    <div class="col-lg-12 col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Статистика за год</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChartYear" style="min-height: 305px; height: 305px; max-height: 305px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('specialscripts')
    <script>
        //---------------------
        //- STACKED BAR CHART -
        //---------------------
        @foreach($banks_stat as $bank_stat)
        var stackedBarChartCanvas = $('#stackedBarChart_{{$loop->index}}').get(0).getContext('2d')
        var areaChartData = {
            labels  : [@foreach($bank_stat as $bank)

                @if($bank['count'] > 0)'{{$bank['name']}}',@endif
                @endforeach],
            datasets: [
                {
                    label               : 'Заявки',
                    backgroundColor     : 'rgba(90,196,95,0.6)',
                    borderColor         : 'rgba(60,141,188,0.5)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [@foreach($bank_stat as $bank)
                        @if($bank['count'] > 0)'{{$bank['count']}}',@endif
                        @endforeach]
                },
            ]
        }
        var stackedBarChartData = $.extend(true, {}, areaChartData)

        var stackedBarChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
        })
        @endforeach


        var BarChartCanvas = $('#barChartYear').get(0).getContext('2d')
        var areaChartData = {
            labels  : [@foreach($year_stat[0] as $month=>$stat)
                '{{$month}}',
                @endforeach],
            datasets: [
                {
                    label               : 'Заявки, шт.',
                    backgroundColor     : 'rgb(208,212,221,0.7)',
                    borderColor         : 'rgba(60,141,188,0.5)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [@foreach($year_stat[0] as $stat=>$data)
                       '{{$data}}',
                        @endforeach]
                },
                {
                    label               : 'Сумма, млн. руб.',
                    backgroundColor     : 'rgba(0,122,254,0.8)',
                    borderColor         : 'rgba(60,141,188,0.5)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [@foreach($year_stat[1] as $stat=>$data)
                        '{{$data}}',
                        @endforeach]
                },
            ]
        }
        var BarChartData = $.extend(true, {}, areaChartData)

        var BarChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }

        new Chart(BarChartCanvas, {
            type: 'bar',
            data: BarChartData,
            options: BarChartOptions
        })

    </script>
@endsection
