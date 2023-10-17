@extends('layouts.admin_layout')

@section('title', 'Добавить банк')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать банк</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (!$errors->isEmpty())
                <div class="alert alert-danger" role="danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-times"></i>Возникла ошибка, проверьте, что все поля корректно заполнены!</h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('bank.update', $bank->id) }} " method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h2 class="mb-4">Настройки ипотеки</h2>
                                <div class="form-group">
                                    <label>Название</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-university"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name-bank" name="name"
                                               value="{{ $bank->name }}">
                                    </div>
                                </div>
                                <div class="form-group d-flex">
                                    <div style="margin-right: 20px;">
                                        <label for="banksLogo">Логотип банка</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input mb-2" id="banksLogo" name="banks_logo">
                                            <label class="custom-file-label" for="validatedCustomFile"
                                                   data-browse="Выбрать файл">Выбрать файл...</label>
                                            <p>Рекомендуемый размер 264x156px</p>
                                            @error('banks_logo')
                                            <div class="text-danger">Необходимо загрузить логотип банка.</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if($bank->banks_logo)
                                        <div class="d-flex align-center">
                                            <img src="{{'/img/banks/'.$bank->id.'/'.$bank->banks_logo}}" alt="" class="border" style="height: 101px;">
                                        </div>
                                    @else
                                        <div class="d-flex align-center">
                                            <img src="/img/no_image_no_background.png" alt="" class="border" style="height: 101px;">
                                        </div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для отправки заявок (МСК)</label>
                                    <input type="email" class="form-control" id="email-bank" name="email"
                                           value="{{ $bank->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для копии (МСК)</label>
                                    <input type="text" class="form-control" id="email-copy-bank" name="email_copy"
                                           value="{{ $bank->email_copy }}"
                                           placeholder="введите любое количество e-mail через запятую">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для программы под залог
                                        недвижимости</label>
                                    <input type="text" class="form-control" id="emails_for_different_programs"
                                           name="emails_for_different_programs"
                                           value="{{ $bank->emails_for_different_programs }}"
                                           placeholder="введите любое количество e-mail через запятую">
                                </div>
                                <div class="form-group">
                                    <label for="demand_template">Копия заявки для процессинга</label>
                                    <select class="custom-select" id="variant_copy_for_processing" name="variant_copy_for_processing"
                                            aria-label="Default select example">
                                                <option value="1" @if($bank->variant_copy_for_processing == 1) selected @endif>На email</option>
                                                <option value="2" @if($bank->variant_copy_for_processing == 2) selected @endif>В Google</option>
                                                <option value="3" @if($bank->variant_copy_for_processing == 3) selected @endif>Никуда</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Контактное лицо в банке</label>
                                    <input type="text" class="form-control" id="contact-bank" name="contact"
                                           value="{{ $bank->contact }}">
                                </div>
                                <div class="form-group">
                                    <label>Телефон контактного лица</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="contact-phone-bank"
                                               name="contact_phone" value="{{ $bank->contact_phone }}"
                                               data-inputmask='"mask": "(999) 999-99-99"' data-mask>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Всплывающая подсказка</label>
                                    <input type="text" class="form-control" id="alt-contact-bank" name="alt_contact"
                                           value="{{ $bank->alt_contact }}">
                                </div>
                                <div class="form-group">
                                    <label for="demand_template">Шаблон письма для отправки заявки</label>
                                    <select class="custom-select" id="demand_template" name="demand_template_id"
                                            aria-label="Default select example">
                                        <option disabled="disabled" value=""
                                                @if ($bank->demand_template_id == null) selected @endif>Выберите шаблон
                                            письма
                                        </option>
                                        @foreach($demand_templates as $template)
                                            @if($template -> enabled == 1)
                                                <option value="{{$template->id}}"
                                                        @if ($template == $bank->demandTemplate) selected @endif>{{$template->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="attribute_for_sending_to_regions">Признак отправки в регионы</label>
                                    <select class="custom-select" id="attribute_for_sending_to_regions"
                                            name="attribute_for_sending_to_regions"
                                            aria-label="Default select example">
                                        <option value="agents_region"
                                                @if ('agents_region' == $bank->attribute_for_sending_to_regions) selected @endif>
                                            Регион агента
                                        </option>
                                        <option value="pledges_region"
                                                @if ('pledges_region' == $bank->attribute_for_sending_to_regions) selected @endif>
                                            Регион залога
                                        </option>
                                        <option value="deals_region"
                                                @if ('deals_region' == $bank->attribute_for_sending_to_regions) selected @endif>
                                            Регион сделки
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Максимальный размер вложений в МБ</label>
                                    <input type="text" class="form-control" id="max_files_size" name="max_files_size"
                                           placeholder="Введите максимальный размер"
                                           @if(isset($bank->max_files_size))value="{{old($bank->max_files_size) ?? $bank->max_files_size}}"@endif>
                                    @error('max_files_size')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="variantsRateEnable" name="variants_rate_enable"
                                               value="1"{{ $bank->variants_rate_enable == 1 ? 'checked' : '' }}>
                                        <label for="variantsRateEnable">
                                            Варианты ставок
                                        </label>
                                    </div>
                                    <input type="text" class="form-control mt-3" id="variantsRate" name="variants_rate"
                                           placeholder="Укажите варианты ставок через точку с запятой" value="{{old('variants_rate') ?? $bank->variants_rate}}">
                                </div>
                                <div class="form-group">
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h2>
                                                    <button id="btnAccordion"
                                                            class="btn btn-link btn-block text-left collapsed"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseTwo" aria-expanded="false"
                                                            aria-controls="collapseTwo" style="color: #819090">
                                                        Показать email для отправки по регионам
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseTwo" class="collapse pt-3" aria-labelledby="headingTwo"
                                                 data-parent="#accordionExample">
                                                @foreach($regions as $region)
                                                    <div class="form-group col-md-auto">
                                                        <label for="region">E-mail для отправки по
                                                            региону: {{$region->title}}</label>
                                                        <input type="text" class="form-control" id="region"
                                                               name="region_emails[]"
                                                               value="@if(isset($region_emails[$region->id]['region_emails'])){{$region_emails[$region->id]['region_emails']}}@endif"
                                                               placeholder="введите любое количество e-mail через запятую">
                                                        <input type="hidden" name="region_id[]" value="{{$region->id}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <p>Выберите программы</p>
                                    <div class="d-flex flex-wrap">
                                    @foreach($credit_programs as $credit_program)
                                        @if($credit_program->enabled_demands)
                                            <div class="icheck-primary mr-3">
                                                <input
                                                    @if ((isset($bank->programs_demand)) && (in_array($credit_program->id, json_decode($bank->programs_demand, true) ?? []))) checked
                                                    @endif type="checkbox" class="form-control"
                                                    id="credit_program_{{$credit_program->id}}_{{$loop->iteration}}" name="programs_demand[]"
                                                    value="{{$credit_program->id}}">
                                                <label for="credit_program_{{$credit_program->id}}_{{$loop->iteration}}">
                                                    {{$credit_program->title}}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="enabled" name="enabled"
                                               value="1" {{ $bank->enabled == 1 ? 'checked' : '' }}>
                                        <label for="enabled">
                                            Включен
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <input type="hidden" name="demand_submit" value="1">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('bank.update', $bank->id) }} " method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h2 class="mb-4">Настройки кредитов</h2>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для отправки заявок</label>
                                    <input type="email" class="form-control" id="email-bank" name="email_credit"
                                           value="{{ $bank->email_credit }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для копии</label>
                                    <input type="text" class="form-control" id="email-copy-bank"
                                           name="email_copy_credit" value="{{ $bank->email_copy_credit }}"
                                           placeholder="введите любое количество e-mail через запятую">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Всплывающая подсказка</label>
                                    <input type="text" class="form-control" id="alt-contact-bank"
                                           name="alt_contact_credit" value="{{ $bank->alt_contact_credit }}">
                                </div>
                                <div class="form-group">
                                    <label for="demand_template">Шаблон письма для отправки заявки</label>
                                    <select class="custom-select" id="demand_template" name="demand_template_credit_id"
                                            aria-label="Default select example">
                                        <option disabled="disabled" value=""
                                                @if ($bank->demand_template_credit_id == null) selected @endif>Выберите
                                            шаблон письма
                                        </option>
                                        @foreach($demand_templates as $template)
                                            @if($template -> enabled == 1)
                                                <option value="{{$template->id}}"
                                                        @if ($template == $bank->demandTemplateCredit) selected @endif>{{$template->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group clearfix">
                                    <p>Выберите программы</p>
                                    @foreach($credit_programs as $credit_program)
                                        @if($credit_program->enabled_credits)
                                            <div class="icheck-primary d-inline">
                                                <input
                                                    @if ((isset($bank->programs_credit)) && (in_array($credit_program->id, json_decode($bank->programs_credit, true) ?? []))) checked
                                                    @endif type="checkbox" class="form-control"
                                                    id="credit_program_{{$credit_program->id}}" name="programs_credit[]"
                                                    value="{{$credit_program->id}}">
                                                <label for="credit_program_{{$credit_program->id}}">
                                                    {{$credit_program->title}}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="enabled_credit"
                                               name="enabled_credit"
                                               value="1" {{ $bank->enabled_credit == 1 ? 'checked' : '' }}>
                                        <label for="enabled_credit">
                                            Включен
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <input type="hidden" name="credit_submit" value="1">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('bank.update', $bank->id) }} " method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h2 class="mb-4">Добавить офис для банка</h2>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Название офиса</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Введите название офиса" value="{{old('name')}}">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail</label>
                                    <input type="text" class="form-control" id="emails"
                                           name="emails"
                                           placeholder="Введите любое количество e-mail через запятую" value="{{old('emails')}}">
                                    @error('emails')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <input type="hidden" name="banks_office" value="1">
                            <input type="hidden" name="create_office" value="1">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </form>
                    </div>
                    @if($bank->offices && count(json_decode($bank->offices, true)) > 0)
                    <div class="card card-primary">
                        <div class="card-body">
                            <h2 class="mb-4">Текущие офисы</h2>
                            @foreach(json_decode($bank->offices, true) as $office)
                                <div id="card-{{$office['id']}}" class="card">
                                    <div class="card-body p-0">
                                        <table class="table table-sm">
                                            <tbody>
                                            <tr>
                                                <td class="my-td"><input id="office-name-{{$office['id']}}" type="text" class="form-control" name="office_name-{{$office['id']}}"
                                                                         placeholder="Введите название офиса" value="{{old('name')?? $office['name']}}">
                                                </td>
                                                <td class="my-td"><input id="office-emails-{{$office['id']}}" type="text" class="form-control" name="office_emails-{{$office['id']}}"
                                                                         placeholder="Введите любое количество e-mail через запятую"
                                                                         value="{{old('emails')?? $office['emails']}}"></td>
                                                <td class="my-td text-nowrap" style="width: 15%;">
                                                    <input type="hidden" name="delete_office" value="1">
                                                    <input type="hidden" name="update_office" value="1">
                                                    <input id="office_id_{{$office['id']}}" type="hidden" name="office_id" value="{{$office['id']}}">
                                                    <button id="update-office-{{$office['id']}}" type="submit" class="btn btn-success btn-sm mr-4" onclick="updateOffice('{{$office['id']}}')">
                                                        <i class="far fa-save"></i></button>
                                                        <button id="delete-office-{{$office['id']}}" type="submit" class="btn btn-danger btn-sm" onclick="deleteOffice('{{$office['id']}}')">
                                                            <i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('bank.update', $bank->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <h2 class="mb-4">Настройки комиссионного вознаграждения</h2>
                                <div class="form-group">
                                    <label for="isHasReward">Комиссионное вознаграждение</label>
                                    <select class="custom-select" id="isHasReward" name="is_has_reward"
                                            aria-label="Default select example">
                                        <option value="" selected>Выберите вариант</option>
                                        <option value="1"
                                                @if(old('is_has_reward') == "1" || (isset($bank->is_has_reward) && $bank->is_has_reward == 1)) selected @endif>
                                            Есть
                                        </option>
                                        <option value="0"
                                                @if(old('is_has_reward') == "0" || (isset($bank->is_has_reward) && $bank->is_has_reward == 0)) selected @endif>
                                            Нет
                                        </option>
                                    </select>
                                    @error('is_has_reward')
                                    <div class="text-danger">Укажите, выплачивает ли банк комиссионное вознаграждение.
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="typePercent">Тип ставки</label>
                                    <select class="custom-select" id="typePercent" name="type_percent"
                                            aria-label="Default select example">
                                        <option value="" selected>Выберите вариант</option>
                                        <option value="Базовая ставка"
                                                @if(old('type_percent') == "Базовая ставка" || (isset($bank->type_percent) && $bank->type_percent == "Базовая ставка")) selected @endif>
                                            Базовая ставка
                                        </option>
                                        <option value="Надбавка к ставке"
                                                @if(old('type_percent') == "Надбавка к ставке" || (isset($bank->type_percent) && $bank->type_percent == "Надбавка к ставке")) selected @endif>
                                            Надбавка к ставке
                                        </option>
                                        <option value="Скидка к ставке"
                                                @if(old('type_percent') == "Скидка к ставке" || (isset($bank->type_percent) && $bank->type_percent == "Скидка к ставке")) selected @endif>
                                            Скидка к ставке
                                        </option>
                                    </select>
                                    @error('type_percent')
                                    <div class="text-danger">Выберите тип ставки.</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="maxSizeReward">Максимальный размер комиссии в % (если банк выплачивает
                                        комиссию)</label>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="form-control" name="reward_is_integer" id="checkboxinteger" value="1"
                                                   @if(old('reward_is_integer') == 1 || (isset($bank->reward_is_integer) && $bank->reward_is_integer == 1)) checked @endif>
                                            <label for="checkboxinteger">
                                                Целое число
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control"
                                           placeholder="Введите максимальный размер комиссии" id="maxSizeReward"
                                           name="max_size_reward"
                                           value="{{old('max_size_reward') ?? $bank->max_size_reward}}">
                                    @error('max_size_reward')
                                    <div class="text-danger">Здесь должно быть число</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="article_text">Список программ по которым выплачивается комиссия. Если выплата по всем программам указать "Комиссионное вознаграждение выплачивается по всем программам"</label>
                                    <textarea name="short_list_programs" id="article_text"
                                              class="form-control">{{old('short_list_programs') ?? $bank->short_list_programs}}</textarea>
                                    @error('short_list_programs')
                                    <div class="text-danger">Заполните данное поле.</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Полный список программ банка (в конце указать тип ставки с размером).</label>
                                    <textarea name="full_list_programs" id="article_text"
                                              class="form-control">{{old('full_list_programs') ?? $bank->full_list_programs}}</textarea>
                                    @error('full_list_programs')
                                    <div class="text-danger">Заполните данное поле.</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="article_text">Дополнительные условия</label>
                                    <textarea name="extra_conditions" id="article_text"
                                              class="form-control">{{old('extra_conditions') ?? $bank->extra_conditions}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Файлы</label>
                                    <div class="custom-file mb-5">
                                        <input type="file" class="custom-file-input mb-3" name="banksFiles[]"
                                               id="banksFiles" multiple>
                                        <label class="custom-file-label" for="validatedCustomFile"
                                               data-browse="Выбрать файл">Выберите один или несколько файлов...</label>
                                    </div>
                                </div>

                                <h4 class="mb-4">Добавить карточку контакта</h4>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">ФИО</label>
                                    <input type="text" class="form-control" name="contacts_name"
                                           placeholder="Введите ФИО" value="{{old('contacts_name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Телефон</label>
                                    <input type="text" class="form-control" name="contacts_phone"
                                           placeholder="+7 ___ ___-__-__" data-inputmask='"mask": "+7 999 999-99-99"'
                                           data-mask value="{{old('contacts_phone')}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail</label>
                                    <input type="text" class="form-control" name="contacts_email"
                                           placeholder="Введите e-mail" value="{{old('contacts_email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Город</label>
                                    <input type="text" class="form-control" name="contacts_city"
                                           placeholder="Введите город" value="{{old('contacts_city')}}">
                                </div>
                                <div class="form-group">
                                    <label for="colors">Выделить контакт цветом</label>
                                    <select class="custom-select" id="colors" name="is_contact_has_color"
                                            aria-label="Default select example">
                                        <option value="" selected>Выберите вариант</option>
                                        <option value="1" @if(old('is_contact_has_color') == "1") selected @endif>Да
                                        </option>
                                        <option value="0" @if(old('is_contact_has_color') == "0") selected @endif>Нет
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="enabled_reward"
                                               name="enabled_reward" value="1"
                                               @if(old('enabled_reward') == 1 || (isset($bank->enabled_reward) && $bank->enabled_reward == 1)) checked @endif>
                                        <label for="enabled_reward">
                                            Включен
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <input type="hidden" name="reward_submit" value="1">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-5">
                    @if($bank->files && count(json_decode($bank->files, true)) > 0)
                        <div class="card card-primary">
                            <div class="card-body">
                                <h2 class="mb-4">Текущие файлы</h2>
                                @foreach(json_decode($bank->files, true) as $key => $file)
                                    <div
                                        class="form-group clearfix mb-0 d-flex align-items-center justify-content-between">
                                        <div>
                                            <a href="{{'/files/banks/' . $bank->id . '/' . $file}}" target="_blank">
                                                <div class="file-preview file-image-preview">
                                                    <div class="file-image">
                                                        <img id="{{$file.$key}}"
                                                             src="{{'/files/banks/' . $bank->id . '/' . $file}}" alt=""
                                                             style="height: 100%; width: 100%; object-fit: cover;"
                                                             onerror="this.src='/img/dropzone/default.png'">
                                                    </div>
                                                    <div class="file-details">
                                                        <div class="file-filename">
                                                            <div class="file-filename__name">{{$file}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div>
                                            <form method="POST" action="{{ route('bank.update', $bank->id) }}"
                                                  class="ml-3">
                                                @method('PUT')
                                                @csrf
                                                <input type="hidden" name="reward_submit" value="1">
                                                <input type="hidden" name="delete_file_from_reward" value="1">
                                                <input type="hidden" name="file_name" value="{{$file}}">
                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($bank->contacts && count(json_decode($bank->contacts, true)) > 0)
                        <div class="card card-primary">
                            <div class="card-body">
                                <h2 class="mb-4">Текущие контакты</h2>
                                @foreach(json_decode($bank->contacts, true) as $contact)
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <table class="table table-sm">
                                                <input type="hidden" name="reward_submit" value="1">
                                                <input type="hidden" name="update_contact_to_reward" value="1">
                                                <input type="hidden" name="contact_id" value="{{$contact['id']}}">
                                                <tbody>
                                                <tr>
                                                    <td class="my-td"><input type="text" class="form-control" name="contacts_name{{'-'.$contact['id']}}"
                                                                             placeholder="Введите ФИО" value="{{old('contacts_name') ?? $contact['contacts_name']}}">
                                                    </td>
                                                    <td class="my-td"><input type="text" class="form-control " name="contacts_phone{{'-'.$contact['id']}}"
                                                                             placeholder="+7 ___ ___-__-__" data-inputmask='"mask": "+7 999 999-99-99"'
                                                                             data-mask value="{{old('contacts_phone') ?? $contact['contacts_phone']}}"></td>
                                                </tr>
                                                <tr>
                                                    <td class="my-td"><input type="text" class="form-control " name="contacts_email{{'-'.$contact['id']}}"
                                                                             placeholder="Введите e-mail" value="{{old('contacts_email') ?? $contact['contacts_email']}}"></td>
                                                    <td class="my-td">
                                                        <input type="text" class="form-control " name="contacts_city{{'-'.$contact['id']}}"
                                                               placeholder="Введите город" value="{{old('contacts_city') ?? $contact['contacts_city']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="my-td">
                                                        <div class="custom-control custom-switch custom-switch-lg">
                                                            <input type="checkbox" class="custom-control-input"  id="customSwitch{{$loop->iteration}}" name="is_contact_has_color{{'-'.$contact['id']}}"  @if($contact['is_contact_has_color'] == "1") checked @endif>
                                                            <label class="custom-control-label" for="customSwitch{{$loop->iteration}}" style="white-space: nowrap;">Выделить цветом</label>
                                                        </div>
                                                    </td>
                                                    <td class="my-td">
                                                        <div class="position-relative">
                                                            <form method="POST" action="{{ route('bank.update', $bank->id) }}" class="ml-3" style="text-align: right">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="reward_submit" value="1">
                                                                <input type="hidden" name="delete_contact_from_reward" value="1">
                                                                <input type="hidden" name="contact_id" value="{{$contact['id']}}">
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="fas fa-trash-alt"></i></button>
                                                            </form>
                                                            <button id="{{$contact['id']}}" type="submit" class="btn btn-success btn-sm position-absolute" style="right: 55px;top: 0px;" onclick="updateContact('{{$contact['id']}}')">
                                                                <i class="far fa-save"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <style>
        .tox .tox-promotion {
            display: none;
        }
        .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #28a745;
            border-color: green;
        }

        .custom-switch.custom-switch-lg .custom-control-label {
            padding-top: 3px;
            padding-left: 1rem;
        }

        .custom-switch.custom-switch-lg .custom-control-label::before {
            height: 1.5rem;
            width: calc(2.5rem + 0.25rem);
            border-radius: 4rem;
        }


        .custom-switch.custom-switch-lg .custom-control-label::after {
            width: calc(1.5rem - 3.5px);
            height: calc(1.5rem - 3.5px);
            border-radius: calc(2.5rem - (1.5rem / 1.5));
        }

        .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(calc(1.5rem - 0.25rem));
        }

        .my-td {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }

    </style>

@endsection

@section('specialscripts')
    <!-- Page specific script -->
    <script>

        $('[data-mask]').inputmask()

        $(document).ready(function () {
            $('#collapseTwo').on('show.bs.collapse', function () {
                document.getElementById('btnAccordion').innerText = 'Скрыть email для отправки по регионам'
            });

            $('#collapseTwo').on('hidden.bs.collapse', function () {
                document.getElementById('btnAccordion').innerText = 'Показать email для отправки по регионам'
            });
        })

        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        tinymce.init({
            selector: 'textarea#article_text',
            language: 'ru',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'autoresize', 'emoticons'
            ],
            menubar: 'edit view tools help',
            toolbar: 'undo redo | fontsize blocks | ' +
                'forecolor bold italic underline backcolor emoticons| alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat',
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap'); body { font-family:Nunito,sans-serif; font-size:16px } p { margin: 0 }",
            font_size_formats: "8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt",
            resize: true,
            image_description: false,
            paste_as_text: true,
            forced_root_block : 'div'
        });
        @if($bank->files)
            @foreach(json_decode($bank->files, true) as $key => $file)
        if ("{{$file}}".toLowerCase().includes('.pdf'.toLowerCase())) {
            $(document).ready(function () {
                document.getElementById("{{$file}}" + "{{$key}}").src = "/img/dropzone/PDF.png";
            })
        } else if ("{{$file}}".toLowerCase().includes('.xlsx'.toLowerCase()) ||
            "{{$file}}".toLowerCase().includes('.xls'.toLowerCase())) {
            $(document).ready(function () {
                document.getElementById("{{$file}}" + "{{$key}}").src = "/img/dropzone/EXCEL_2.png";
            })
        } else if ("{{$file}}".toLowerCase().includes('.zip'.toLowerCase()) || "{{$file}}".toLowerCase().includes('.rar'.toLowerCase())) {
            $(document).ready(function () {
                document.getElementById("{{$file}}" + "{{$key}}").src = "/img/dropzone/ARCHIVE.png";
            })
        } else if ("{{$file}}".toLowerCase().includes('.doc'.toLowerCase()) ||
            "{{$file}}".toLowerCase().includes('.docx'.toLowerCase())) {
            $(document).ready(function () {
                document.getElementById("{{$file}}" + "{{$key}}").src = "/img/dropzone/WORD.png";
            })
        } else {
            if (!"{{$file}}".toLowerCase().includes('.jpg'.toLowerCase()) &&
                !"{{$file}}".toLowerCase().includes('.jpeg'.toLowerCase()) &&
                !"{{$file}}".toLowerCase().includes('.png'.toLowerCase())) {
                $(document).ready(function () {
                    document.getElementById("{{$file}}" + "{{$key}}").src = "/img/dropzone/default.png";
                })
            }
        }
        @endforeach
        @endif

        function updateContact(contact_id) {


            const elements = document.querySelectorAll('.is-invalid');
            const smalls = document.querySelectorAll('.invalid-feedback');

            elements.forEach((element) => {
                element.classList.remove('is-invalid');
            });

            smalls.forEach((element) => {
                element.remove('invalid-feedback');
            });

            document.getElementById(contact_id).disabled = true;

            let data = {};
            data['reward_submit'] = $("input[name=reward_submit]").val();
            data['update_contact_to_reward'] = $("input[name=update_contact_to_reward]").val();
            data['contact_id'] = contact_id;
            data["contacts_name-"+contact_id] = $("input[name=contacts_name-" +contact_id +"]").val();
            data["contacts_phone-"+contact_id] = $("input[name=contacts_phone-" +contact_id +"]").val();
            data["contacts_email-"+contact_id] = $("input[name=contacts_email-" +contact_id +"]").val();
            data["contacts_city-"+contact_id] = $("input[name=contacts_city-" +contact_id +"]").val();
            data['is_contact_has_color-'+contact_id] = $("input[name=is_contact_has_color-" +contact_id +"]").prop('checked');

            console.log(data)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            $.ajax({
                type: 'PUT',
                url: "{{ route('bank.update', $bank->id) }}",
                data: data,
                success: function (data) {
                    console.log(data)
                    console.log('успех')
                    document.getElementById(contact_id).disabled = false;

                },
                error: function (error) {
                    console.log(error)
                    if (422 === error.status) {
                        for(input_name in error.responseJSON.errors){
                            console.log(input_name);
                            let input = $("input[name=" + input_name +"]");
                            if(!input.hasClass('is-invalid')){
                                input.addClass('is-invalid');
                                input.after("<small class='invalid-feedback'>Поле не должно быть пустым</small>")
                            }
                        }
                    }
                    document.getElementById(contact_id).disabled = false;
                }
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function deleteOffice(id) {
            let data = {};
            let name = $("#office-name-" + id);
            let emails = $("#office-emails-" + id);
            let button = $("#delete-office-" + id);
            data['office_id'] = $("#office_id_"+id).val();
            data['name'] = name.val();
            data['emails'] = emails.val();
            data['delete_office'] = $("input[name=delete_office]").val();
            data['banks_office'] = $("input[name=banks_office]").val();
            console.log(data)
            name.prop('disabled', true);
            emails.prop('disabled', true);
            button.prop('disabled', true);

            $.ajax({
                type: 'PUT',
                url: "{{ route('bank.update', $bank->id) }}",
                data: data,
                success: function (data) {
                    console.log(data)
                    $('#card-' + id).remove();
                },
                error: function (error) {
                    name.prop('disabled', false);
                    emails.prop('disabled', false);
                    button.prop('disabled', false);
                    console.log(error)
                }
            });
        }

        function updateOffice(id) {
            const elements = document.querySelectorAll('.is-invalid');
            const smalls = document.querySelectorAll('.invalid-feedback');
            elements.forEach((element) => {
                element.classList.remove('is-invalid');
            });

            smalls.forEach((element) => {
                element.remove('invalid-feedback');
            });

            let name = $("#office-name-" + id);
            let emails = $("#office-emails-" + id);
            let button = $("#update-office-" + id);
            let data = {};
            data['office_name-'+id] = name.val();
            data['office_emails-'+id] = emails.val();
            data['update_office'] = $("input[name=update_office]").val();
            data['banks_office'] = $("input[name=banks_office]").val();
            data['office_id'] = $("#office_id_"+id).val()
            console.log(data)
            name.prop('disabled', true);
            emails.prop('disabled', true);
            button.prop('disabled', true);
            $.ajax({
                type: 'PUT',
                url: "{{ route('bank.update', $bank->id) }}",
                data: data,
                success: function (data) {
                    console.log(data)
                    name.prop('disabled', false);
                    emails.prop('disabled', false);
                    button.prop('disabled', false);
                },
                error: function (error) {
                    name.prop('disabled', false);
                    emails.prop('disabled', false);
                    button.prop('disabled', false);
                    console.log(error)
                    if (422 === error.status) {
                        for (input_name in error.responseJSON.errors) {
                            console.log(input_name);
                            let input = $("input[name=" + input_name + "]");
                            if (!input.hasClass('is-invalid')) {
                                input.addClass('is-invalid');
                                input.after("<small class='invalid-feedback'>Поле не должно быть пустым</small>")
                            }
                        }
                    }

                }
            });
        }



    </script>
@endsection
