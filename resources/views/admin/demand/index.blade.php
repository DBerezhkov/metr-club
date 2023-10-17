@extends('layouts.admin_layout')

@section('title', 'Заявки')

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
                    <h1 class="m-0">Все заявки на ипотеку</h1>
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
                        <div class="col-auto">
                            <form action="{{route('demandsExport')}}">
                                <button type="submit" class="btn btn-primary mb-2 mt-2 mr-2">Экспорт в CSV</button>
                                <input type="hidden" name="search_field" value="{{request()->get('search_field')}}">
                                <input type="hidden" name="create_date_range" value="{{request()->get('create_date_range')}}">
                                @if(isset($_GET["name_of_banks"]))
                                    @foreach($_GET["name_of_banks"] as $value)
                                        <input type="hidden" name="name_of_banks[]" value="{{$value}}">
                                    @endforeach
                                @endif
                                <input type="hidden" name="region" value="{{request()->get('region')}}">
                            </form>
                        </div>
                        <div class="col-auto">
                            <button id="btnFilter" class="btn collapsed  btn-dark mb-2 mt-2" type="button"
                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                Показать фильтр
                            </button>
                        </div>
                    </div>
                    <div id="collapseTwo"
                         class="collapse @if(request()->get('search_field') || request()->get('name_of_banks') || request()->get('create_date_range') || request()->get('region') !== null && !empty($_GET)) show @endif"
                         aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body py-2">
                            <form action="{{route('demand.index')}}">
                                <div class="form-row mb-3">
                                    <div class="col-auto">
                                        <label for="search_field">Поиск:</label>
                                        <input name="search_field"
                                               @if(isset($_GET['search_field']) && !empty($_GET)) value="{{request()->get('search_field')}}"
                                               @endif
                                               type="text" class="form-control" id="exampleFormControlInput1"
                                               data-toggle="tooltip"
                                               title="Введите одно из значений: ФИО, контактный телефон, имя или email сотрудника"
                                               placeholder="Введите запрос">
                                    </div>
                                    <div class="col-auto">
                                        <label for="createDateRange">Дата создания:</label>
                                        <input id="createDateRange" type="text" class="form-control date-range"
                                               name="create_date_range" value="{{request()->get('create_date_range')}}"
                                               data-inputmask='"mask": "99-99-9999 - 99-99-9999"' data-mask>
                                    </div>
                                    <div class="px-1">
                                        <div style="width: 200px">
                                            <label for="nameOfBanks">Банки:</label>
                                        </div>
                                        <select id="nameOfBanks" class="form-control" name="name_of_banks[]">
                                        </select>
                                    </div>
                                    <div class="px-1">
                                        <div style="width: 300px">
                                            <label for="regions">Регионы:</label>
                                        </div>
                                        <select class="custom-select" style="margin-right: -135px;" id="regions"
                                                name="region">
                                            <option @if(!isset($_GET)) selected @endif value="">Выбрать...</option>
                                            @foreach($regions as $region)
                                                <option
                                                    @if(isset($_GET) && !empty($_GET) && isset($_GET['region']) && ($_GET['region'] == $region['id']))selected
                                                    @endif  value="{{$region['id']}}">{{$region['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto" style="padding-top: 31px"><input type="submit"
                                                                                           class="btn btn-primary"
                                                                                           value="Найти"></div>
                                    <div class="col-auto" style="padding-top: 31px">
                                        @if(request()->get('search_field') || request()->get('name_of_banks') || request()->get('create_date_range') || request()->get('region') !== null && !empty($_GET))
                                            <a href="{{route('demand.index')}}" class="btn btn-success">Сбросить</a>
                                        @endif
                                    </div>
                                </div>
                                @if(request()->get('search_field') || request()->get('name_of_banks') || request()->get('create_date_range') || request()->get('region') !== null && !empty($_GET))
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
                                <th style="width: 20%">
                                    Сотрудник
                                </th>
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
                                        <a href="{{route('demand.show', $demand->id)}}">{{ $demand['name'] }}</a>
                                    </td>
                                    <td>
                                        {{ $demand['contact_phone'] }}
                                    </td>

                                    <td>
                                        @if($demand->agent)
                                        <a href="/admin_panel/users/{{ $demand->agent['id'] }}">{{ $demand->agent['name'] }}</a> ({{ $demand->agent['email'] }})
                                        @endif
                                    </td>
                                    <td>
                                        {{ $demand['created_at'] }}
                                    </td>
                                    <td>
                                        {{$demand -> printBanksList($demand->banks_list)}}
                                    </td>
                                    <td class="project-actions text-center">
                                        <a class="btn btn-primary btn-sm" href="{{route('demand.show', $demand->id)}}" target="_blank">
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
            for (let parameter of arrayParameters) {
                let idFromParameters = parameter.replace(/name_of_banks\[?%?5?B?%?5?D?\d*\]?%?5?B?%?5?D?=/, '')
                banksIdFromParameters.push(Number(idFromParameters));
            }
            console.log(banksIdFromParameters)
            for (let bank of banksList) {
                let isParametersContainsBanksId = false;
                isParametersContainsBanksId = banksIdFromParameters.includes(bank['id'])
                data.push({
                    "id": bank['id'],
                    "text": bank['name'],
                    "selected": isParametersContainsBanksId,
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
    </script>
@endsection
