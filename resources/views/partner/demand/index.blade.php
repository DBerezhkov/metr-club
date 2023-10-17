@extends('layouts.partner_layout')

@section('title', 'Заявки')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Заявки на ипотеку</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">

        <div class="accordion px-2" id="accordionExample">
            <div class="card">
                <div class="card-header border-0 py-1">
                    <div class="form-row">
                        @if(auth()->user()->hasRole('supervisor'))
                        <div class="col-auto">
                            <form action="{{route('supervisorDemandsExport')}}">
                                <button type="submit" class="btn btn-primary mb-2 mt-2 mr-2">Экспорт в CSV</button>
                                <input type="hidden" name="search_field" value="{{request()->get('search_field')}}">
                                <input type="hidden" name="create_date_range" value="{{request()->get('create_date_range')}}">
                                <input type="hidden" name="supervisors_demands" value="{{request()->get('supervisors_demands')}}">
                                <input type="hidden" name="employees_demands" value="{{request()->get('employees_demands')}}">
                                @if(isset($_GET["name_of_banks"]))
                                    @foreach($_GET["name_of_banks"] as $value)
                                        <input type="hidden" name="name_of_banks[]" value="{{$value}}">
                                    @endforeach
                                @endif
                            </form>
                        </div>
                        @endif
                        <div class="col-auto">
                            <button id="btnFilter" class="btn collapsed  btn-dark mb-2 mt-2" type="button"
                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                Показать фильтр
                            </button>
                        </div>
                    </div>
                    <div id="collapseTwo"
                         class="collapse @if(isset($_GET) && !empty($_GET)) show @endif"
                         aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body py-2">
                            <form @if(auth()->user()->hasRole('supervisor')) action="{{route('supervisor_demands.index')}}" @else action="{{route('demands.index')}}" @endif>
                                <div class="form-row mb-3">
                                    <div class="col-auto">
                                        <label for="search_field">Поиск:</label>
                                        <input name="search_field"
                                               @if(isset($_GET['search_field']) && !empty($_GET)) value="{{request()->get('search_field')}}"
                                               @endif type="text" class="form-control" id="exampleFormControlInput1"
                                               data-toggle="tooltip" title="Введите одно из значений: ФИО или контактный телефон {{auth()->user()->hasRole('supervisor') ? 'или имя сотрудника':''}}"
                                               placeholder="Введите запрос">
                                    </div>
                                    <div class="col-auto">
                                        <label for="createDateRange">Дата создания:</label>
                                        <input id="createDateRange" type="text" class="form-control date-range"
                                               name="create_date_range" value="{{request()->get('create_date_range')}}"
                                               data-inputmask='"mask": "99-99-9999 - 99-99-9999"' data-mask>
                                    </div>
                                    <div class="px-1">
                                        <div style="width: 150px">
                                            <label for="nameOfBanks">Банки:</label>
                                        </div>
                                        <select id="nameOfBanks" class="form-control" name="name_of_banks[]">
                                        </select>
                                    </div>
                                    @if(auth()->user()->hasRole('supervisor'))
                                    <div class="col-auto d-flex flex-row-reverse align-items-end mb-2">
                                        <label for="supervisors_demands" style="width: 90px" class="mb-1 ml-n3">Только мои</label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="checkbox" class="custom-control-input" id="supervisors_demands" name="supervisors_demands"
                                                   @if(isset($_GET) && !empty($_GET) && isset($_GET['supervisors_demands']) && ($_GET['supervisors_demands'] == "on")) checked @endif>
                                            <label class="custom-control-label" for="supervisors_demands"></label>
                                        </div>
                                    </div>

                                        <div class="col-auto d-flex flex-row-reverse align-items-end mb-2">
                                            <label for="employees_demands" style="width: 120px" class="mb-1 ml-n3">Только агентов</label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" class="custom-control-input" id="employees_demands" name="employees_demands"
                                                       @if(isset($_GET) && !empty($_GET) && isset($_GET['employees_demands']) && ($_GET['employees_demands'] == "on")) checked @endif>
                                                <label class="custom-control-label" for="employees_demands"></label>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-auto" style="padding-top: 31px"><input type="submit"
                                                                                           class="btn btn-primary"
                                                                                           value="Найти"></div>
                                    <div class="col-auto" style="padding-top: 31px">
                                        @if(isset($_GET) && !empty($_GET))
                                            @if(auth()->user()->hasRole('supervisor'))
                                                <a href="{{route('supervisor_demands.index')}}" class="btn btn-success">Сбросить</a>
                                            @else
                                            <a href="{{route('demands.index')}}" class="btn btn-success">Сбросить</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @if(isset($_GET) && !empty($_GET))
                                    <div><h6><b>Найдено записей: {{$demands_count}} </b></h6></div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="container-fluid">
            <div>
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 5%">
                                    #
                                </th>
                                <th style="width: 23%">
                                    ФИО
                                </th>
                                <th style="width: 14%">
                                    Контактный телефон
                                </th>
                                @if(auth()->user()->hasRole('supervisor'))
                                <th style="width: 20%">
                                    Сотрудник
                                </th>
                                @endif
                                <th style="width: 13%">
                                    Дата
                                </th>
                                <th style="width: 16%">
                                    Банк
                                </th>
                                <th style="width: 10%" class="text-center">
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($demands as $demand)

                                <tr>
                                    <td>
                                        {{ $demand['id'] }}
                                    </td>
                                    <td>
                                        <a href="{{route('demands.show', $demand->id)}}">{{ $demand['name'] }}</a>
                                    </td>
                                    <td>
                                        {{ $demand['contact_phone'] }}
                                    </td>
                                    @if(auth()->user()->hasRole('supervisor'))
                                    <td>
                                        @if(isset($demand->agent))
                                        <a href="{{route('employees.show', $demand->agent['id'])}}" target="_blank">
                                            {{ $demand->agent['name'] }}
                                        </a>
                                        @elseif($demand->agent()->withTrashed()->get()->first() != null)
                                            <div>{{$demand->agent()->withTrashed()->get()->first()->name}}</div>
                                        @endif
                                        @if((isset($demand->agent['rating']) && (!empty($demand->agent['rating']))))
                                            @php
                                                $rating = json_decode($demand->agent['rating']);
                                            @endphp
                                            @if($rating->rating > 0)
                                                <span data-toggle="tooltip" data-placement="top" title="У агента {{$rating->demands}} заявок за последние 90 дней">
                                                @for($i = 1; $i <= $rating->rating; $i++)
                                                        <i class="fas fa-star" style="color:#FFAA3E;"></i>
                                                    @endfor
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    @endif
                                    <td>
                                        {{ $demand['created_at'] }}
                                    </td>
                                    <td>
                                        {{$demand -> printBanksList($demand->banks_list)}}
                                    </td>
                                    <td class="project-actions text-center">
                                        <a class="btn btn-primary btn-sm mb-2" href="{{route('demands.show', $demand->id)}}">
                                            Открыть
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="ml-3 my-3">
                            {{ $demands->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <style>

        .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #007bff;
            border-color: #007bff;
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

@endsection

@section('specialscripts')
    <!-- Page specific script -->
    <script src="/js/ClassWatcher.js"></script>
    <script>

        $(document).ready(function () {
            @php
                $banks_list1 = [];
                foreach($banks as $bank) {
                   $banks_list1[] = array("id"=>$bank['id'], "name" => $bank['name']);
                }
            @endphp
            let banksList = {!! json_encode($banks_list1) !!};
            let data = [];
            let banksParametersFromURL = window.location.search
            let arrayParameters = banksParametersFromURL.toString().substring(1).split('&')
            let banksIdFromParameters = [];
            for(let parameter of arrayParameters){
                let idFromParameters = parameter.replace(/name_of_banks\[?%?5?B?%?5?D?\d*\]?%?5?B?%?5?D?=/, '')
                banksIdFromParameters.push(Number(idFromParameters));
            }
            for (let bank of banksList) {
                let isParametersContainsBanksId = false;
                isParametersContainsBanksId = banksIdFromParameters.includes(bank['id'])
                data.push({
                    "id": bank['id'],
                    "text": bank['name'],
                    "selected" : isParametersContainsBanksId,
                })
            }

            $('#nameOfBanks').select2({
                placeholder: 'Выберите банк',
                theme: 'bootstrap4',
                maximumSelectionLength: 5,
                width: '100%',
                dropdownAutoWidth: true,
                multiple: true,
                language: "ru",
                data: data,
            })

        })
        $('[data-mask]').inputmask()

        $(function () {

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
                }
            });

            $('.date-range').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.date-range').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

        });

        $(document).ready(function () {

            if (document.getElementById('collapseTwo').classList.contains('show')) {
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

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
