@extends('layouts.admin_layout')

@section('title', 'Добавить банк')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавить банк</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="'alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
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
                        <form action="{{ route('bank.store') }} " method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Название</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-university"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name-bank" name="namebank" placeholder="Введите название Банка" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для отправки заявок (МСК)</label>
                                    <input type="email" class="form-control" id="email-bank" name="emailbank" placeholder="Введите e-mail" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для копии (МСК)</label>
                                    <input type="text" class="form-control" id="email-copy-bank" name="emailcopybank" placeholder="введите любое количество e-mail через запятую">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">E-mail для программы под залог недвижимости</label>
                                    <input type="text" class="form-control" id="emails_for_different_programs" name="emails_for_different_programs" placeholder="введите любое количество e-mail через запятую">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Контактное лицо в банке</label>
                                    <input type="text" class="form-control" id="contact-bank" name="contactbank" placeholder="Введите ФИО" required>
                                </div>
                                <div class="form-group">
                                    <label>Телефон контактного лица</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="contact-phone-bank" name="contactphonebank" data-inputmask='"mask": "(999) 999-99-99"' data-mask required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Всплывающая подсказка</label>
                                    <input type="text" class="form-control" id="alt-contact-bank" name="altcontactbank" placeholder="Введите данные" required>
                                </div>
                                <div class="form-group">
                                    <label for="demand_template">Шаблон письма для отправки заявки</label>
                                    <select class="custom-select" id="demand_template" name="demand_template_id"
                                            aria-label="Default select example">
                                        <option disabled="disabled" value="" selected>Выберите шаблон письма
                                        </option>
                                        @foreach($demand_templates as $template)
                                            @if($template -> enabled == 1)
                                            <option value="{{$template->id}}">{{$template->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="attribute_for_sending_to_regions">Признак отправки в регионы</label>
                                    <select class="custom-select" id="attribute_for_sending_to_regions" name="attribute_for_sending_to_regions"
                                            aria-label="Default select example">
                                                <option value="agents_region" selected>Регион агента</option>
                                                <option value="pledges_region">Регион залога</option>
                                                <option value="deals_region">Регион сделки</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Максимальный размер вложений в МБ</label>
                                    <input type="text" class="form-control" id="max_files_size" name="max_files_size" placeholder="Введите максимальный размер">
                                    @error('max_files_size')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h2>
                                                <button id="btnAccordion" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: #819090">
                                                    Показать email для отправки по регионам
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse pt-3" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                @foreach($regions as $region)
                                                    <div class="form-group col-md-auto">
                                                        <label for="region">E-mail для отправки по региону: {{$region->title}}</label>
                                                        <input type="text" class="form-control" id="region" name="region_emails[]" placeholder="введите любое количество e-mail через запятую">
                                                        <input type="hidden" name="region_id[]" value="{{$region->id}}">
                                                    </div>
                                                @endforeach
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="enabled" name="enabled" value="1" checked>
                                        <label for="enabled">
                                            Включен
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </form>
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
            $(document).ready(function () {
                $('#collapseTwo').on('show.bs.collapse', function () {
                    document.getElementById('btnAccordion').innerText = 'Скрыть email для отправки по регионам'
                });

                $('#collapseTwo').on('hidden.bs.collapse', function () {
                    document.getElementById('btnAccordion').innerText = 'Показать email для отправки по регионам'
                });
            })
    </script>
@endsection
