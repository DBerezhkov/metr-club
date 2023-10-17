@extends('layouts.partner_layout')

@section('title', 'Агенты')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Агенты</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="accordion px-2" id="accordionExample">
            <div class="card">
                <div  class="card-header border-0 py-1">
                    <div class="form-row">
                        <div class="col-auto">
                            <button onclick="location.href='{{route('employees.create')}}'" type="button" class="btn btn-success mb-2 mt-2 mr-2">Добавить агента</button>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('supervisorAgentsExport') }}">
                                @if(isset($_GET))
                                    @foreach($_GET as $key => $value)
                                        <input type="hidden" name="{{$key}}" value="{{$value}}">
                                    @endforeach
                                @endif
                                <button  type="submit" class="btn btn-primary mb-2 mt-2 mr-2">Экспорт в CSV</button>
                            </form>
                        </div>
                        <div class="col-auto">
                            <button id="btnFilter" class="btn collapsed  btn-dark mb-2 mt-2" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Показать фильтр
                            </button>
                        </div>
                    </div>
                    <div id="collapseTwo" class="collapse @if(isset($_GET) && !empty($_GET)) show @endif" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body py-2">
                            <form action="{{route('employees.index')}}">
                                <div class="form-row mb-3">
                                    <div class="col-auto">
                                        <label for="userName">Поиск:</label>
                                        <input id="userName" type="text" name="name_or_email" class="form-control mr-sm-3" placeholder="введите имя или e-mail" value="{{request()->get('name_or_email')}}">
                                    </div>
                                    <div class="col-auto">
                                        <label for="createDateRange">Дата создания:</label>
                                        <input id="createDateRange" type="text" class="form-control date-range" name="create_date_range" value="{{request()->get('create_date_range')}}"   data-inputmask='"mask": "99-99-9999 - 99-99-9999"' data-mask>
                                    </div>
                                    <div class="col-auto">
                                        <label for="lastVisitRange">Последний вход:</label>
                                        <input id="lastVisitRange" type="text" class="form-control date-range" name="last_visit_range" value="{{request()->get('last_visit_range')}}" data-inputmask='"mask": "99-99-9999 - 99-99-9999"' data-mask>
                                    </div>
                                    <div class="col-auto">
                                        <div style="width: 200px">
                                            <label for="regions">Рейтинг:</label>
                                        </div>
                                        <select class="custom-select" style="margin-right: -135px;" id="rating"
                                                name="rating">
                                            <option @if(!isset($_GET)) selected @endif value="">Выбрать...</option>
                                            <option @if(isset($_GET) && !empty($_GET) && isset($_GET['rating']) && ($_GET['rating'] == 1))selected
                                                    @endif data-toggle="tooltip" data-placement="top" title="Одна звезда" value="1">⭐</option>
                                            <option @if(isset($_GET) && !empty($_GET) && isset($_GET['rating']) && ($_GET['rating'] == 2))selected
                                                    @endif data-toggle="tooltip" data-placement="top" title="Две звезды" value="2">⭐⭐</option>
                                            <option @if(isset($_GET) && !empty($_GET) && isset($_GET['rating']) && ($_GET['rating'] == 3))selected
                                                    @endif data-toggle="tooltip" data-placement="top" title="Две звезды" value="3">⭐⭐⭐</option>
                                        </select>
                                    </div>
                                    <div class="col-auto" style="width: 70px">
                                        <label for="customSwitch1" style="margin: 9px 0px 0px 0px">Онлайн</label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_online"
                                                   @if(isset($_GET) && !empty($_GET) && isset($_GET['is_online']) && ($_GET['is_online'] == "on")) checked @endif>
                                            <label class="custom-control-label" for="customSwitch1"></label>
                                        </div>
                                    </div>
                                    <div class="col-auto" style="padding-top: 30px"><input type="submit" class="btn btn-primary" value="Найти"></div>
                                    <div class="col-auto" style="padding-top: 30px">
                                        @if(isset($_GET) && !empty($_GET)) <a href="{{route('employees.index')}}" class="btn btn-success">Сбросить</a>@endif
                                    </div>
                                </div>
                                @if(isset($_GET) && !empty($_GET)) <div><h6><b>Найдено записей: {{$users_count}}</b></h6> </div> @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div id="scroll_top">↑</div>
            <div id="scroll_bottom">↓</div>
            <div>
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <b><p style="padding-left: 24px; padding-top: 12px">Пользователей онлайн: {{ $online_count }}</p></b>
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Имя
                                </th>
                                <th>
                                    E-mail
                                </th>

                                <th>
                                    Дата создания
                                </th>
                                <th>
                                    Последний вход
                                </th>
                                <th class="text-center">
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)

                                <tr>
                                    <td>
                                        {{ $user['id'] }}
                                    </td>
                                    <td>
                                        <a href="{{route('employees.show', $user->id)}}">{{ $user['name'] }} </a>
                                        @if((isset($user['rating']) && (!empty($user['rating']))))
                                            @php
                                                $rating = json_decode($user['rating']);
                                            @endphp
                                            @if($rating->rating > 0)
                                                <span data-toggle="tooltip" data-placement="top" title="У агента {{$rating->demands}} заявок за последние 90 дней">
                                                @for($i = 1; $i <= $rating->rating; $i++)
                                                    <i class="fas fa-star" style="color:#FFAA3E;"></i>
                                                @endfor
                                                </span>
                                            @endif
                                        @endif
                                        @if($users_active[$user['id']]) <span class="right badge badge-success ml-2" >ONLINE</span> @endif
                                    </td>
                                    <td>
                                        {{ $user['email'] }}
                                    </td>
                                    <td>
                                        {{ $user['created_at'] }}
                                    </td>
                                    <td>
                                        {{ $user['active_at'] }}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-sm" href="{{route('employees.show', $user->id)}}" target="_blank">
                                            Открыть
                                        </a>
                                        @if(isset($user->phone))
                                        <a class="btn btn-success btn-sm" href="https://wa.me/{{$user->phone}}?text=@php echo urlencode('Привет, ' . $user->name) @endphp" target="_blank">
                                            <i class="fab fa-whatsapp">
                                            </i>
                                        </a>
                                        @endif
                                        @if(isset($user->tglogin) && $user->tglogin != '')
                                            <a class="btn btn-info btn-sm" href="https://t.me/{{$user->tglogin}}" target="_blank">
                                                <i class="fab fa-telegram-plane">
                                                </i>
                                            </a>
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

    <style>
            .daterangepicker .ranges {
                float: right !important;
            }
        #scroll_top, #scroll_bottom {
            position: fixed;
            right: 5px;
            z-index: 9999;
            background: #007bff;
            border: 1px solid #ccc;
            box-shadow: 0 1px 0.3em -0.1em rgba(0,0,6,0.5);
            border-radius: 50%;
            cursor: pointer;
            color: #fff;
            text-align: center;
            font-size: 20px;
            text-shadow: 0 1px 2px #000, 0 0 10px #E0F1FF;
            opacity: .5;
            padding: 0 3px 5px 3px;
            width: 36px;
            height: 36px;
        }
        #scroll_top {
            bottom: 50px;
        }
        #scroll_bottom {
            bottom: 10px;
        }
        #scroll_top:hover, #scroll_bottom:hover {
            opacity: .7;
        }
        .checkmark {
            display:inline-block;
            width: 22px;
            height:22px;
            -ms-transform: rotate(45deg); /* IE 9 */
            -webkit-transform: rotate(45deg); /* Chrome, Safari, Opera */
            transform: rotate(45deg);
        }

        .checkmark_stem {
            position: absolute;
            width:3px;
            height:9px;
            background-color: #28a745;
            left:11px;
            top:6px;
        }

        .checkmark_kick {
            position: absolute;
            width:3px;
            height:3px;
            background-color: #28a745;
            left:8px;
            top:12px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: -50%;
            left: 190px;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        /* custom switch */

        .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #28a745;
            border-color: green;
        }

        .custom-switch.custom-switch-lg .custom-control-label {
            padding-left: 3rem;
            padding-bottom: 2rem;
        }

        .custom-switch.custom-switch-lg .custom-control-label::before {
            height: 2rem;
            width: calc(3rem + 0.75rem);
            border-radius: 4rem;
        }


        .custom-switch.custom-switch-lg .custom-control-label::after {
            width: calc(2rem - 4px);
            height: calc(2rem - 4px);
            border-radius: calc(3rem - (2rem / 2));
        }

        .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(calc(2rem - 0.25rem));
        }

    </style>
    <!-- /.content -->

@endsection

@section('specialscripts')
    <script src="/js/ClassWatcher.js"></script>
    <script>
        $(function(){
            $('#scroll_top').click(function(){
                $('html, body').animate({scrollTop: 0}, 500)
                return false
            })

            $('#scroll_bottom').click(function (){
                $('html, body').animate({scrollTop: $(document).height()}, 500)
                return false
            })
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $('[data-mask]').inputmask()

        $(function() {

            $('.date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD.MM.YYYY',
                    "separator": "-",
                    "applyLabel": "Ок",
                    "cancelLabel": "Отмена",
                    "fromLabel": "От",
                    "toLabel": "До",
                    "customRangeLabel": "Произвольный",
                    "daysOfWeek": [
                        "Вс",
                        "Пн",
                        "Вт",
                        "Ср",
                        "Чт",
                        "Пт",
                        "Сб"
                    ],
                    "monthNames": [
                        "Январь",
                        "Февраль",
                        "Март",
                        "Апрель",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Август",
                        "Сентябрь",
                        "Октябрь",
                        "Ноябрь",
                        "Декабрь"
                    ],
                    firstDay: 1
                },
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                    'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                    'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                alwaysShowCalendars: true,
            });

            $('.date-range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.date-range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });

        $(document).ready(function () {

            if(document.getElementById('collapseTwo').classList.contains('show')){
                console.log(11111)
                document.getElementById('btnFilter').innerText = 'Скрыть фильтр'
            } else {
                document.getElementById('btnFilter').innerText = 'Показать фильтр'
            }

            let targetNode = document.getElementById('collapseTwo')

            function workOnClassAdd() {
                console.log('show')
                document.getElementById('btnFilter').innerText = 'Скрыть фильтр'
            }

            function workOnClassRemoval() {
                console.log('hide')
                document.getElementById('btnFilter').innerText = 'Показать фильтр'
            }
            let classWatcher = new ClassWatcher(targetNode, 'show', workOnClassAdd, workOnClassRemoval)
        })
    </script>
@endsection
