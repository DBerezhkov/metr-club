@extends('layouts.partner_layout')

@section('title', 'Добавить заявку')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новая заявка на оценку недвижимости</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="'alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="'danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('error') }}</h4>
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
                        <form action="{{ route('evaluations.store') }} " method="POST" id='formSnd' enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Ваше имя</label>
                                    <input type="text" value="{{ $name }}" class="form-control" id="name" name="name" required>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Телефон для связи с агентом</label>
                                    <input type="text" value="{{ old('clientphone') }}" class="form-control" id="email-copy-bank" name="clientphone" required data-inputmask='"mask": "9 (999) 999-99-99"' data-mask>
                                    @error('clientphone')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Контакт человека, который будет показывать объект</label>
                                    <input type="text" value="{{ old('contact') }}" class="form-control" id="email-copy-bank" name="contact" required>
                                    @error('contact')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Желаемая стоимость объекта</label>
                                    <input type="text" value="{{ old('price') }}" class="form-control" id="email-copy-bank" name="price" required>
                                    @error('price')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <p class="font-weight-bold">Комментарий</p>
                                    <textarea name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
                                    @error('comment')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">

                                    <p class="font-weight-bold">Банк</p>
                                    <select size="1" name="bank">
                                        <option disabled>Выберите Банк</option>
                                        <option selected value="Сбер">Сбер</option>
                                        <option value="Газпром">Газпром</option>
                                        <option value="ЮКБ">ЮКБ</option>
                                        <option value="Акбарс">Акбарс</option>
                                        <option value="Левобережный">Левобережный</option>
                                        <option value="Росбанк">Росбанк</option>
                                        <option value="Финсервис">Финсервис</option>
                                        <option value="Сибсоцбанк">Сибсоцбанк</option>
                                        <option value="Открытие">Открытие</option>
                                        <option value="Транскапиталбанк">Транскапиталбанк</option>
                                        <option value="Азиатскотихоокеанский">Азиатскотихоокеанский</option>
                                        <option value="Альфа">Альфа</option>
                                        <option value="Совкомбанк">Совкомбанк</option>
                                        <option value="Уральский банк реконструкции и развития">Уральский банк реконструкции и развития</option>
                                        <option value="Всероссийский Банк Развития Регионов">Всероссийский Банк Развития Регионов</option>
                                        <option value="Промсвязьбанк">Промсвязьбанк</option>
                                        <option value="Алтайкапиталбанк">Алтайкапиталбанк</option>
                                        <option value="ДОМрф">ДОМрф</option>
                                        <option value="Уралсиб">Уралсиб</option>
                                        <option value="Райффазен">Райффазен</option>
                                        <option value="Российский капитал">Российский капитал</option>
                                        <option value="Московский Индустриальный Банк">Московский Индустриальный Банк</option>
                                        <option value="Банк Санкт-Петербург">Банк Санкт-Петербург</option>
                                        <option value="Новикомбанк">Новикомбанк</option>
                                        <option value="Россия">Россия</option>
                                        <option value="Акцепт">Акцепт</option>
                                        <option value="Металлинвестбанк">Металлинвестбанк</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Прикрепите сканы документов</label>
                                    <p class="text-danger">Необходимые документы: паспорт собственника; егрн; технический паспорт; паспорт покупателя.</p>
                                    <input type="file" class="form-control-file mb-2" name="scanfiles[]" id="scanfiles" multiple>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">

                                <button type="submit" id="btnSubmit" class="btn btn-primary">Отправить заявку</button>
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $('[data-mask]').inputmask()
        $(document).ready(function() {
            $("input[name$='creditprogram']").click(function() {
                var param = $(this).val();

                if (param == 5) {
                    $("#refinparams").show("slow");
                    $("#refinparams :input").each(function(){$(this).prop("required", true)});
                }
                else {
                    $("#refinparams").hide("slow");
                    $("#refinparams :input").each(function(){$(this).prop("required", false)});
                }
            });
            $("#formSnd").submit(function (e) {
                $("#btnSubmit").attr("disabled", true);
                $("#btnSubmit").html('Подождите...');
            });
        });
        $('input[type="file"]').on('change', function() { $(this).after('<input type="file" class="form-control-file mb-2" name="scanfiles[]" id="scanfiles" multiple="">') });

        const checkboxpsb = document.getElementById('checkboxBank-8')
        checkboxpsb.disabled = true
        $("#creditprogramcheckboxes").on("click", "input[type=radio]", clickCB);
        function clickCB(e) {
            const target = e.target
            if (target.id === 'credit-program-5') {
                checkboxpsb.disabled = false
            }
            else {
                checkboxpsb.disabled = true
                checkboxpsb.checked = false
            }
        }
    </script>

@endsection
