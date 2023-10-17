@extends('layouts.admin_layout')

@section('title', 'Новый шаблон')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новый шаблон письма</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-times"></i>{{ session('error') }}</h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="row justify-content-start">
                                <div class="col-md-5">
                        <form action="{{ route('demands_templates.store') }} " method="POST" id='formSnd'>
                            @csrf
                            <div class="card-body">
                                <div class="mb-3"><b>Чтобы указать в теме или в теле письма данные заявки, клиента или агента, воспользуйтесь таблицей меток</b></div>
                                    <div class="form-group col-md-10 pl-0">
                                        <label for="exampleInputPassword1">Наименование шаблона</label>
                                        <input type="text" value="{{old('name') ?? $default_template->name }}" class="form-control" id="name" name="name" required>
                                        @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                <div class="form-group col-md-10 pl-0">
                                    <label for="exampleInputPassword1">Тема</label>
                                    <input type="text" value="{{old('subject') ?? $default_template->subject }}" class="form-control" id="subject" name="subject" required>
                                    @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-10 pl-0">
                                    <label for="body">Тело</label>
                                    <textarea name="body" id="body" class="form-control tinyMCE" rows="10" required>{!! old('body') ?? $default_template->body !!}</textarea>
                                    @error('body')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-10 pl-0">
                                    <label for="body">Тело письма при рефинансировании</label>
                                    <textarea name="refin_body" id="refin_body" class="form-control tinyMCE" rows="10">{!! old('refin_body') ?? $default_template->refin_body !!}</textarea>
                                    @error('refin_body')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="enabled" name="enabled" value="1" checked>
                                        <label for="enabled">
                                            Включен
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" id="btnSubmit" class="btn btn-success">Добавить шаблон</button>
                            </div>


                            <!-- /.card-body -->

                        </form>
                    </div>
                                <div class="col-md-4 ml-n5" style="margin-top: 98px;">
                                    <h4>Для ипотеки</h4>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Тип данных</th>
                                            <th scope="col">Значение</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">ФИО агента</th>
                                            <td>user_name</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Телефон агента</th>
                                            <td>user_telnumber</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">E-mail агента</th>
                                            <td>user_email</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Рефинансирование ипотеки</th>
                                            <td>demand_refin</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Текущая процентная ставка</th>
                                            <td>refin_percent</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Дата окончания ипотеки</th>
                                            <td>refin_date</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Сколько осталось выплатить</th>
                                            <td>refin_balance</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Продукт ипотека</th>
                                            <td>productipoteka</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Программа кредитования</th>
                                            <td>credit_program</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Тип недвижимости</th>
                                            <td>demand_type</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Приблизительная стоимость</th>
                                            <td>demand_estate_summ</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Первоначальный взнос</th>
                                            <td>demand_first_pay_summ</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ФИО заёмщика</th>
                                            <td>demand_name</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Телефон заемщика</th>
                                            <td>demand_contact_phone</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Наименование банка</th>
                                            <td>demand_bank_name</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Тип объекта (первичка, вторичка, загородная)</th>
                                            <td>demand_estate_type</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ID агента</th>
                                            <td>agent_id</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Идентификатор заявки</th>
                                            <td>demand_uid</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Регион залога</th>
                                            <td>pledges_region</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Регион сделки</th>
                                            <td>deals_region</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Комментарий</th>
                                            <td>demand_commentary</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Ссылка регистрации агента</th>
                                            <td>url_registration</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Выбранная ставка</th>
                                            <td>variants_rate</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-3" style="margin-top: 98px;">
                                    <h4>Для кредитов</h4>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Тип данных</th>
                                            <th scope="col">Значение</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">ФИО агента</th>
                                            <td>user_name</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Телефон агента</th>
                                            <td>user_telnumber</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">E-mail агента</th>
                                            <td>user_email</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Программа кредитования</th>
                                            <td>credit_program</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Сумма кредита</th>
                                            <td>credit_summ</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ФИО заёмщика</th>
                                            <td>credit_name</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Телефон заемщика</th>
                                            <td>credit_contact_phone</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Наименование банка</th>
                                            <td>credit_bank_name</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ID агента</th>
                                            <td>agent_id</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Идентификатор заявки</th>
                                            <td>credit_uid</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Комментарий</th>
                                            <td>credit_commentary</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Ссылка регистрации агента</th>
                                            <td>url_registration</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                                </div>
                                </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <style>
        .tox .tox-promotion {
            display: none;
        }
    </style>

@endsection

@section('specialscripts')
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: 'textarea.tinyMCE',
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
            });
    </script>
@endsection



