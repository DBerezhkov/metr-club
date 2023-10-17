@extends('layouts.admin_layout')

@section('title', 'Данные об агенте')

@section('content')
    <!-- Content Header (Page header) -->

    <div class="content-header">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="'danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('error') }}</h4>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <div class="text-center mb-3">
                                <img
                                    src="@if(isset($user->profile_photo_src)) {{$user->profile_photo_src}} @else/img/bear.jpeg @endif"
                                    class="img-fluid rounded-start img-circle"
                                    style="width: unset; border-radius: 3%; border: 2px solid #adb5bd; box-shadow: 1px 0px 5px 0px rgb(0 0 0 / 27%);">
                            </div>

                            <h3 class="profile-username text-center mb-3">{{$user->name}}</h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Порядковый номер агента:</b> <div class="float-right">{{$user->id}}</div>
                                </li>
                                <li class="list-group-item">
                                    <b>Логин:</b> <div class="float-right">{{$user->email}}</div>
                                </li>
                                @if(isset($user->phone)  && $user->phone != '')
                                    <li class="list-group-item">
                                        <b>Телефон:</b><a class="btn btn-success btn-sm float-right"
                                                          href="https://wa.me/{{preg_replace('/[^\d]/', '', $user->phone)}}?text=@php echo urlencode('Привет, ' . $user->name) @endphp"
                                                          target="_blank">
                                            <i class="fab fa-whatsapp">
                                            </i>
                                        </a>
                                        <div class="float-right mr-2">{{$user->phone}}</div>
                                    </li>
                                @endif
                                @if(isset($user->tglogin) && $user->tglogin != '')
                                    <li class="list-group-item">
                                        <b>Telegram:</b> <a class="btn btn-info btn-sm float-right"
                                                            href="https://t.me/{{$user->tglogin}}" target="_blank">
                                            <i class="fab fa-telegram-plane">
                                            </i>
                                        </a>
                                        <div class="float-right mr-2">{{$user->tglogin}}</div>
                                    </li>
                                @endif
                                @if($user->is_employee)
                                    <li class="list-group-item">
                                        <b>Руководитель:</b>
                                        @if($supervisor !== null && !$supervisor->hasRole('supervisor'))
                                            <a class="float-right"
                                               href="{{route('users.show', $user->supervisor_id)}}">{{$supervisor->name}}
                                                (разжалован)</a>
                                        @elseif(isset($supervisor->name))
                                            <a class="float-right"
                                               href="{{route('users.show', $user->supervisor_id)}}">{{$supervisor->name}}</a>
                                        @elseif(isset(\App\Models\User::where('id', $user->supervisor_id)->withTrashed()->first()->name))
                                            <a class="float-right"
                                               href="">{{\App\Models\User::where('id', $user->supervisor_id)->withTrashed()->first()->name}}
                                                (удалён)</a>
                                        @endif
                                    </li>
                                @endif
                            </ul>

                            <a href="{{route('demand.index') . '?search_field=' . $user->email}}"
                               class="btn btn-primary btn-block">Заявки на ипотеку</a>

                            <a href="{{route('credit.index') . '?search_field=' . $user->email}}"
                               class="btn btn-secondary btn-block">Заявки на потребы</a>
                            @if($user->hasRole('supervisor') && isset($user->employees) && $user->employees != '[]')
                            <a href="{{route('users.index') . '?supervisors_employees=' . $user->id}}"
                               class="btn btn-success btn-block">Cубагенты</a>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-primary">
                        <div class="card-header mb-3">
                            <h3 class="card-title">Данные регистрации</h3>
                        </div>
                        <div class="accordion mb-n3" id="accordionRegistrationData">
                            <div class="card">
                                <div class="card-header" id="headingTwoRegistrationData">
                                    <h2 class="mb-0">
                                        <button id="btnAccordionRegistration"
                                                class="btn btn-link btn-block text-left collapsed" type="button"
                                                data-toggle="collapse" data-target="#collapseTwoRegistrationData"
                                                aria-expanded="false" aria-controls="collapseTwoRegistrationData"
                                                style="color: #819090">
                                            Показать регистрационные данные
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwoRegistrationData" class="collapse"
                                     aria-labelledby="headingTwoRegistrationData"
                                     data-parent="#accordionRegistrationData">
                                    <form action="{{route('users.update', $user->id)}}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        @foreach($registration_data[0] as $value)
                                            <div class="form-row pl-3 pr-3 @if($loop->first) mt-3 @endif">
                                                <strong><i
                                                        class="fas {{$value['icon']}} mr-1"></i>{{$value['field_name']}}
                                                </strong>
                                                <input type="text"
                                                       value="@if(isset($user->agent_registration_data)){{$agent_registration_data[$value['key']]}}@endif"
                                                       class="form-control form-control-sm" id="{{$value['key']}}"
                                                       name="{{$value['key']}}">
                                            </div>
                                            <hr class="pl-3 pr-3">
                                        @endforeach
                                        <div class="accordion mb-n3" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button id="btnAccordion"
                                                                class="btn btn-link btn-block text-left collapsed"
                                                                type="button" data-toggle="collapse"
                                                                data-target="#collapseTwo" aria-expanded="false"
                                                                aria-controls="collapseTwo" style="color: #819090">
                                                            Показать технические поля
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                     data-parent="#accordionExample">
                                                    <div class="pl-3 pr-3">
                                                        @foreach($registration_data[1] as $value)
                                                            <strong>{{$value['field_name']}}</strong>
                                                            <input type="text"
                                                                   value="@if(isset($user->agent_registration_data)){{$agent_registration_data[$value['key']]}}@endif"
                                                                   class="form-control form-control-sm @if($loop->last) mb-3 @endif"
                                                                   id="{{$value['key']}}"
                                                                   name="{{$value['key']}}">
                                                            <input type="hidden" name="registration_data">
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div
                                            class="card-body text-center position-relative  @if(!$user->hasRole('admin'))pb-5 @endif">
                                            <div class="@if(!$user->hasRole('admin'))mb-3 @endif">
                                                <button type="submit" class="btn btn-primary btn-block">Обновить
                                                    данные
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @if(!$user->hasRole('admin'))
                                        <div class="card-body text-center position-absolute"
                                             style="bottom: -20px; right: 0; width: 100%">
                                            <div class="mb-3">
                                                <form method="POST" action="{{route('users.destroy', $user->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-block">Удалить
                                                        агента
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{--                        <div class="form_wrapper">--}}
                        @if(isset($user->agent_contract_type_id))
                            <form action="{{ route('users.update', $user->id) }} " method="POST" id='form-snd'
                                  name='formSnd' enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            <strong>Вид сотрудничества</strong>
                                        </td>


                                        <td>
                                            @if ($user->agent_contract_type_id == null)
                                                <strong> Отстутствует информация</strong>
                                            @elseif ($user->agent_contract_type_id == 1)
                                                <strong>Самозанятый</strong>
                                            @elseif ($user->agent_contract_type_id == 2)
                                                <strong>ИП</strong>
                                            @elseif ($user->agent_contract_type_id == 3)
                                                <strong>ООО</strong>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <div class="card-body pt-0 pb-0">
                                    <label for="regions">Регион проживания</label>
                                    <select class="custom-select" id="regions" name="region_id"
                                            aria-label="Default select example">
                                        <option disabled="disabled" value="0"
                                                @if ($user->region == null) selected @endif>Выберите регион
                                        </option>
                                        <option value="{{$default_region->id}}"
                                                @if ($default_region == $user->region) selected @endif>{{$default_region->title}}</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id}}"
                                                    @if ($region == $user->region) selected @endif>{{$region->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!$user->is_supervisor && $supervisors != '[]')
                                    <div class="card-body pt-3 pb-0">
                                        <label for="regions">Руководитель агента</label>
                                        <select class="custom-select" id="setSupervisor" name="set_supervisor"
                                                aria-label="Default select example">
                                            <option disabled="disabled" value="0" selected>Выберите руководителя
                                            </option>
                                            @foreach($supervisors as $supervisor)
                                                <option value="{{$supervisor->id}}"
                                                        @if($user->is_employee && $user->supervisor_id == $supervisor->id) selected @endif>{{$supervisor->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="is_supervisor"
                                               name="is_supervisor"
                                               value="1" {{ $user->is_supervisor == 1 ? 'checked' : '' }}>
                                        <label for="is_supervisor">
                                            Назначить руководителем
                                        </label>
                                    </div>
                                </div>
                                @for ($contract_type_id = 1; $contract_type_id < 4; $contract_type_id++)
                                    <div id="contract_type_card_{{$contract_type_id}}"
                                         class="card-body contract_type_card @if ($contract_type_id != $user->agent_contract_type_id) d-none @endif">
                                        <h4>Данные к договору</h4>
                                        <table class="table table-bordered">
                                            @foreach ( $contract_info_schema[$contract_type_id] as $contract_info_field)
                                                <tr class="font-weight-bold">
                                                    <td class="w-50">
                                                        {{$contract_info_field['field_name']}}

                                                    </td>
                                                    <td><input type="text"
                                                               value="@if(isset($user->agent_contract_props[$contract_type_id][$contract_info_field['key']])){{ $user->agent_contract_props[$contract_type_id][$contract_info_field['key']] }}@endif"
                                                               name="agent_contract_props[{{$contract_type_id}}][{{$contract_info_field['key']}}]"
                                                               class="form-control"
                                                               @if(($contract_type_id < 3) && ($contract_info_field['key'] == 'certificate_number'))
                                                                   data-inputmask='"mask": "999999999999"' data-mask
                                                               @endif
                                                               @if($contract_type_id == $user->agent_contract_type_id) required @endif>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="font-weight-bold">
                                                <td>Передавать номер телефона и ФИО в банки?</td>
                                                <td>
                                                    <div class="icheck-primary d-inline">
                                                        <span
                                                            class="text-{{ $user->agr_send_pd ? 'success' : 'danger' }}">{{ $user->agr_send_pd ? 'Да' : 'Нет' }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                @endfor


                                <div class="form-group text-center mt-3">
                                    <input type="submit" class="btn btn-success ml-4" value="Обновить данные"
                                           id="btn_update_data">
                                </div>
                                <div>
                                </div>
                            </form>
                        @endif
                    </div>
                    <div class="card" id="passForm">
                        @if(session('password_is_changed') !== null)
                            <div class="p-3 m-1" id="info">
                                <div id="tgText" class="tg_text">
                                    Пароль успешно изменен! Новый пароль: {{ session('password_is_changed') }}
                                </div>
                                <div class="mt-3">
                                    <button id="copyButton" class="btn btn-success">Скопировать текст</button>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('users.update', $user->id) }} " method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <h4 class="mb-4"><b>Смена пароля</b></h4>
                                        <label for="exampleInputPassword1">Пароль</label>
                                        <input type="text" value="{{ old('password') }}"
                                               class="form-control col-10 mb-2" id="password" name="password"
                                               placeholder="Введите пароль" required>
                                        <a href="#password" id="random">Сгенерировать пароль</a>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Обновить пароль</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('specialscripts')
    <script src="/js/CopyText.js"></script>
    <script src="/js/GeneratePassword.js"></script>
    <script>
        $('[data-mask]').inputmask()
        var el = $('[name="agent_contract_props[1][certificate_number]"]')
        el.after("<div id='error' class='invalid-feedback'></div>")
        el.keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });

        function ajax() {
            var err = document.getElementById('error')
            err.innerHTML = ""
            var btnCreateContract = $("#btn_create_contract")
            var btnUpdateData = document.getElementById('btn_update_data')
            var data = el.val()
            btnCreateContract.addClass('disabled')
            btnUpdateData.disabled = true

            if (/^\d{12}$/.test(data)) {
                var certificateField = document.getElementsByName('agent_contract_props[1][certificate_number]')[0]
                $.ajax({
                    type: "GET",
                    url: "/api/checknpd/" + data,
                    dataType: "json",
                    success: function (response) {
                        if ("status" in response && response.status === true) {
                            err.innerHTML = "";
                            el.removeClass('is-invalid').addClass('is-valid')
                            btnCreateContract.removeClass('disabled')
                            btnUpdateData.disabled = false
                        } else if ("status" in response && response.status === false || "code" in response) {
                            if (response.code === "taxpayer.status.service.limited.error") {
                                err.innerHTML = "";
                                //таймер обратного отсчета
                                let time = 58
                                let intervalId = setInterval(updateCountDown, 1000)

                                function updateCountDown() {
                                    certificateField.setAttribute('style', 'background: url(/img/icons/loading.gif) no-repeat right center')
                                    certificateField.setAttribute('readonly', 'readonly')
                                    el.removeClass('is-valid').addClass('is-invalid')
                                    btnCreateContract.addClass('disabled')
                                    btnUpdateData.disabled = true
                                    let seconds = time % 60
                                    seconds = seconds < 10 ? "0" + seconds : seconds
                                    err.innerHTML = "Превышено количество запросов, попробуйте еще раз через " + `${seconds}` + " секунд"
                                    time--
                                    if (time < 0) {
                                        clearInterval(intervalId)
                                        certificateField.removeAttribute('style')
                                        certificateField.removeAttribute('readonly')
                                        err.innerHTML = ""
                                    }
                                }
                            } else {
                                el.removeClass('is-valid').addClass('is-invalid')
                                err.innerHTML = response.message
                                btnCreateContract.addClass('disabled')
                                btnUpdateData.disabled = true
                            }
                        }
                    },
                    error: (error) => console.log(JSON.stringify(error))
                });
            } else {
                el.removeClass('is-valid').addClass('is-invalid')
                err.innerHTML = "Введите 12 цифр"
                btnCreateContract.addClass('disabled')
                btnUpdateData.disabled = true
            }
        }

        $(document).ready(function () {
            @if(isset($user->agent_contract_type_id) && $user->agent_contract_type_id == 1)
            ajax();
            $(document).on('change', '[name="agent_contract_props[1][certificate_number]"]',
                function () {
                    ajax();
                });
            @endif

            if (document.getElementById('copyButton') != null) {
                const copyButton = document.getElementById('copyButton');
                copyButton.addEventListener('click', (event) => {
                    copyElementToClipboard('tgText');
                    document.getElementById('copyButton').innerText = 'Текст скопирован';
                });

            }

            $('#collapseTwo').on('show.bs.collapse', function () {
                document.getElementById('btnAccordion').innerText = 'Скрыть технические поля'
            });

            $('#collapseTwo').on('hidden.bs.collapse', function () {
                document.getElementById('btnAccordion').innerText = 'Показать технические поля'
            });
        });

        $('#random').click(function () {
            $('#passForm').effect("bounce", 1000);
        })
    </script>
@endsection
