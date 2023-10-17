@extends('layouts.partner_layout')
@section('title', 'Профиль')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
    <!-- InputMask -->
    <script src="/admin/plugins/inputmask/jquery.inputmask.min.js"></script>

    <section class="content">
        <div class="container-fluid" id="app">
            @if (session('success'))
                <div class="alert alert-success" role="'alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @isset($user->agent_registration_data)
                @php
                    $phone = json_decode($user->agent_registration_data)->telnumber;
                @endphp
            @endisset
            @if (session('error'))
                <div class="alert alert-danger" role="'danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-times"></i>{{ session('error') }}</h4>
                </div>
            @endif
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Выберите фото</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('profile.update', $user->id) }} " method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="modal-body">
                                <div style="margin-right: 20px;">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input mb-2" id="profile_photo" name="profile_photo" required>
                                        <label class="custom-file-label" for="validatedCustomFile"
                                               data-browse="Выбрать файл">Выбрать файл...</label>
                            @error('profile_photo')
                           <p class="text-danger">{{ $message }}</p>
                            <script>$(document).ready(function () {$('#exampleModal').modal('show')})</script>
                            @enderror
                            @error('profile_photo.*')
                            <p class="text-danger">{{ $message }}</p>
                                        <script>$(document).ready(function () {$('#exampleModal').modal('show')})</script>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary">Обновить</button>
                                <button class="btn btn-danger ml-3" data-dismiss="modal">Закрыть</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-3  mt-4">
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <div class="text-center mb-3">
                                <img  src="@if(isset($user->profile_photo_src)) {{$user->profile_photo_src}} @else/img/bear.jpeg @endif" class="img-fluid rounded-start img-circle" style="width: unset; border-radius: 3%; border: 2px solid #adb5bd; box-shadow: 1px 0px 5px 0px rgb(0 0 0 / 27%);">
                            </div>
                            <ul class="list-group list-group-unbordered mb-3">
                                @foreach($registration_data[0] as $value)
                                    @if(isset($agent_registration_data[$value['key']]) && $agent_registration_data[$value['key']] != '' && !$loop->last)
                                        @if($value['key'] != 'form_of_interaction')
                                    <li class="list-group-item">
                                        <b>{{$value['field_name']}}</b> <div class="float-right">{{$agent_registration_data[$value['key']]}}</div>
                                    </li>
                                        @endif
                                    @endif
                                @endforeach
                                @if($user->is_employee == 1 && isset($supervisor->name) && $supervisor->hasRole('supervisor'))
                                <li class="list-group-item">
                                    <b>Руководитель</b> <div class="float-right">{{$supervisor->name}}</div>
                                </li>
                                    @endif
                            </ul>
                                <button type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">Изменить фото профиля</button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-6 mt-4">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{--                        <div class="form_wrapper">--}}
                        <form action="{{ route('profile.update', $user->id) }} " method="POST" id='form-snd'
                              name='formSnd' enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if ($user->agent_contract_type_id == null)
                                <div class="card-body">
                                    <h2 class="text-center text-red">ВНИМАНИЕ!</h2>
                                    <h3 class="text-center text-red">Для полноценной работы с системой, необходимо
                                        указать данные для договора</h3>
                                </div>
                            @endif
                            @if ($user->agr_send_pd_is_read == 0)
                                <div class="card-body">
                                    {!! $text_agr_send_pd !!}
                                </div>
                                @php
                                    auth()->user()->update(['agr_send_pd_is_read' => 1,]);
                                @endphp
                            @endif

                            <div class="card-body">
                                <h4 class="text-center">Данные о сотрудничестве</h4>
                                @if(!$user->is_employee)
                                <select class="custom-select" id="agent_contract_type_id" name="agent_contract_type_id"
                                        aria-label="Default select example">

                                    <option disabled="disabled" value="0"
                                            @if ($user->agent_contract_type_id == null) selected @endif>Выберите вашу
                                        форму сотрудничества
                                    </option>
                                    <option value="1" @if ($user->agent_contract_type_id == 1) selected @endif>
                                        Самозанятый
                                    </option>
                                    <option value="2" @if ($user->agent_contract_type_id == 2) selected @endif>ИП
                                    </option>
                                    <option value="3" @if ($user->agent_contract_type_id == 3) selected @endif>ООО
                                    </option>
                                </select>
                                @else
                                    <input type="hidden" name="agent_contract_type_id" value="{{$user->agent_contract_type_id}}">
                                @endif
                            </div>
                            <div class="card-body">
                                <div id="regions_selector"><label for="regions">Регион проживания</label>
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
                                    </select></div>
                            </div>
                            @if(!$user->is_employee && !$user->is_supervisor && ($user->employees == '[]' || !isset($user->employees)))
                            <div class="card-body">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="form-control" id="is_supervisor"
                                           name="is_supervisor"
                                           value="1">
                                    <label for="is_supervisor" data-toggle="tooltip" title="При выборе данной опции, вы сможете самостоятельно добавлять агентов и управлять их заявками">
                                        Стать руководителем
                                    </label>
                                </div>
                                </div>
                            @endif
                            @for ($contract_type_id = 1; $contract_type_id < 4; $contract_type_id++)
                                <div id="contract_type_card_{{$contract_type_id}}"
                                     class="card-body contract_type_card @if ($contract_type_id != $user->agent_contract_type_id) d-none @endif">
                                    @foreach ( $contract_info_schema[$contract_type_id] as $contract_info_field)
                                        @if(!$user->is_employee)
                                        @if (isset($contract_info_field['ceo_spec']))

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="agent_contract_props[{{$contract_type_id}}][{{$contract_info_field['key']}}]"
                                                       id="is_ceo"
                                                       checked
                                                       value="true">
                                                <label class="form-check-label" for="is_ceo">
                                                    Генеральный директор
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="agent_contract_props[{{$contract_type_id}}][{{$contract_info_field['key']}}]"
                                                       id="is_not_ceo"
                                                       value="false"
                                                >
                                                <label class="form-check-label" for="is_not_ceo">
                                                    По доверенности
                                                </label>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label
                                                    for="{{$contract_info_field['key']}}-{{$contract_type_id}}">{{$contract_info_field['field_name']}}</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="{{$contract_info_field['key']}}-{{$contract_type_id}}"
                                                       name="agent_contract_props[{{$contract_type_id}}][{{$contract_info_field['key']}}]"
                                                       @if(($contract_type_id < 3) && ($contract_info_field['key'] == 'certificate_number'))
                                                           data-inputmask='"mask": "999999999999"' data-mask
                                                       @endif
                                                       value="@if($user->agent_contract_type_id &&
                                                        isset($user->agent_contract_props[$contract_type_id]) &&
                                                        isset($user->agent_contract_props[$contract_type_id][$contract_info_field['key']])
                                                        ){{$user->agent_contract_props[$contract_type_id][$contract_info_field['key']]}}@elseif(($contract_info_field['key'] == 'phone') && (!(isset($user->agent_contract_props[$contract_type_id][$contract_info_field['key']]))) && (isset($phone))){{$phone}}@endif"
                                                       placeholder="{{$contract_info_field['field_name']}}"
                                                       @if($contract_type_id == $user->agent_contract_type_id) required @endif>
                                            </div>
                                        @endif
                                        @else
                                            @if($contract_info_field['key'] == 'phone' || $contract_info_field['key'] == 'email')
                                                <div class="form-group">
                                                    <label
                                                        for="{{$contract_info_field['key']}}-{{$contract_type_id}}">{{$contract_info_field['field_name']}}</label>
                                                    <input type="text"
                                                           class="form-control"
                                                           id="{{$contract_info_field['key']}}-{{$contract_type_id}}"
                                                           name="agent_contract_props[{{$contract_type_id}}][{{$contract_info_field['key']}}]"
                                                           value="@if($user->agent_contract_type_id &&
                                                        isset($user->agent_contract_props[$contract_type_id]) &&
                                                        isset($user->agent_contract_props[$contract_type_id][$contract_info_field['key']])
                                                        ){{$user->agent_contract_props[$contract_type_id][$contract_info_field['key']]}}@elseif(($contract_info_field['key'] == 'phone') && (!(isset($user->agent_contract_props[$contract_type_id][$contract_info_field['key']]))) && (isset($phone))){{$phone}}@endif"
                                                           placeholder="{{$contract_info_field['field_name']}}"
                                                           @if($contract_type_id == $user->agent_contract_type_id) required @endif>
                                                </div>
                                            @else
                                                    <input type="hidden"
                                                           class="form-control"
                                                           id="{{$contract_info_field['key']}}-{{$contract_type_id}}"
                                                           name="agent_contract_props[{{$contract_type_id}}][{{$contract_info_field['key']}}]"
                                                           value="@if($user->agent_contract_type_id &&
                                                        isset($user->agent_contract_props[$contract_type_id]) &&
                                                        isset($user->agent_contract_props[$contract_type_id][$contract_info_field['key']])
                                                        ){{$user->agent_contract_props[$contract_type_id][$contract_info_field['key']]}}@elseif(($contract_info_field['key'] == 'phone') && (!(isset($user->agent_contract_props[$contract_type_id][$contract_info_field['key']]))) && (isset($phone))){{$phone}}@endif"
                                                           placeholder="{{$contract_info_field['field_name']}}"
                                                           @if($contract_type_id == $user->agent_contract_type_id) required @endif>
                                            @endif
                                        @endif
                                    @endforeach

                                </div>
                            @endfor

                            @if(!$user->is_employee)
                            <div class="form-group clearfix ml-4">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="form-control" id="agr_send_pd" name="agr_send_pd" value="1"{{$user->agr_send_pd == 1 ? 'checked' : ''}}>
                                    <label for="agr_send_pd">
                                        Передавать номер телефона и ФИО в банки
                                    </label>
                                </div>
                            </div>
                            @endif

                            <div class="form-group clearfix ml-4">
                                <div class="icheck-primary d-inline">
                                    <a href="{{route('sopd')}}"><u>Согласие на обработку персональных данных</u></a>
                                </div>
                            </div>



                            <div class="form-group text-center">
                                <button type="submit" form="form-snd" id='btnSubmit' class="btn btn-primary ">Обновить
                                    данные
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <script>
        $(document).ready(function () {
            $('[data-mask]').inputmask();
        });
        function initials(str) {
            parts = str.split(/\s+/).map((w, i) => i ? w.substring(0, 1).toUpperCase() + '.' : w);
            return parts[1] + parts[2] + ' ' + parts[0];
        }

        (function () {
            function hasClass(el, className) {
                if (el.classList)
                    return el.classList.contains(className)
                else
                    return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'))
            }

            function addClass(el, className) {
                if (el.classList)
                    el.classList.add(className)
                else if (!hasClass(el, className)) el.className += " " + className
            }

            function removeClass(el, className) {
                if (el.classList)
                    el.classList.remove(className)
                else if (hasClass(el, className)) {
                    var reg = new RegExp('(\\s|^)' + className + '(\\s|$)')
                    el.className = el.className.replace(reg, ' ')
                }
            }

            var contractTypeIdSelect = document.getElementById('agent_contract_type_id');
            if(contractTypeIdSelect != null) {
                contractTypeIdSelect.addEventListener('change', function () {
                    var elems = document.querySelectorAll('.contract_type_card')

                    ;[].forEach.call(elems, function (el) {
                        addClass(el, 'd-none')

                        el.querySelectorAll('input').forEach((input) =>
                            input.removeAttribute('required')
                        )
                    })

                    var el = document.getElementById('contract_type_card_' + this.value)
                    removeClass(el, 'd-none')

                    el.querySelectorAll('input').forEach((input) =>
                        input.setAttribute('required', '')
                    )
                })
            }

            document.getElementById('full_name-1').addEventListener("change", function () {
                document.getElementById('shortname-1').value = initials(document.getElementById('full_name-1').value);

            });
        })();

        //Check NPD SE
        $(document).ready(function () {
            $('[data-mask]').inputmask()
            var el = $('[name="agent_contract_props[1][certificate_number]"]')
            el.after("<div id='error' class='invalid-feedback'></div>")
            var err = document.getElementById('error')
            err.innerHTML = ""
            var button = document.getElementById('btnSubmit')
            el.keydown(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });

            $(document).on('change', '[name="agent_contract_props[1][certificate_number]"]',
                function () {
                    var data = el.val()
                    var certificateField = document.getElementsByName('agent_contract_props[1][certificate_number]')[0]
                    button.disabled = true
                    if (/^\d{12}$/.test(data)) {
                        err.innerHTML = "";
                        $.ajax({
                            type: "GET",
                            url: "/api/checknpd/" + data,
                            dataType: "json",
                            success: function (response) {
                                if ("status" in response && response.status === true) {
                                    err.innerHTML = "";
                                    el.removeClass('is-invalid').addClass('is-valid')
                                    button.disabled = false
                                } else if ("status" in response && response.status === false || "code" in response) {
                                    if (response.code === "taxpayer.status.service.limited.error") {
                                        err.innerHTML = "";
                                        //таймер обратного отсчета
                                        let time = 58
                                        let intervalId = setInterval(updateCountDown, 1000)

                                        function updateCountDown() {
                                            certificateField.setAttribute('style', 'background: url(http://www.xiconeditor.com/image/icons/loading.gif) no-repeat right center')
                                            certificateField.setAttribute('readonly', 'readonly')
                                            el.removeClass('is-valid').addClass('is-invalid')
                                            button.disabled = true
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
                                        button.disabled = true
                                        err.innerHTML = response.message
                                    }
                                }
                            },
                            error: function (error) {
                               console.log(error)
                                if(error.status === 500){
                                    err.innerHTML = "";
                                    el.removeClass('is-invalid')
                                    button.disabled = false
                                }

                            }
                        });
                    } else {
                        el.removeClass('is-valid').addClass('is-invalid')
                        err.innerHTML = "Введите 12 цифр"
                        button.disabled = true
                    }
                });
        })

    </script>

    <script>
        $("#bank_name-1").suggestions({
            token: "50e09e9a559d764a0dd75936e507e2469d53b34d",
            type: "BANK",
            /* Вызывается, когда пользователь выбирает одну из подсказок */
            onSelect: function (suggestion) {
                $('#bic-1').val(suggestion.data.bic);
                $('#correspondent_account-1').val(suggestion.data.correspondent_account);
                console.log(suggestion);
            }
        });

        $("#bank_name-2").suggestions({
            token: "50e09e9a559d764a0dd75936e507e2469d53b34d",
            type: "BANK",
            onSelect: function (suggestion) {
                $('#bic-2').val(suggestion.data.bic);
                $('#correspondent_account-2').val(suggestion.data.correspondent_account);
            }
        });
        $("#bank_name-3").suggestions({
            token: "50e09e9a559d764a0dd75936e507e2469d53b34d",
            type: "BANK",
            onSelect: function (suggestion) {
                $('#bic-3').val(suggestion.data.bic);
                $('#correspondent_account-3').val(suggestion.data.correspondent_account);
                console.log(suggestion);
            }
        });

        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
