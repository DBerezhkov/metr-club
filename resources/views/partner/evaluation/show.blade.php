@extends('layouts.partner_layout')

@section('title', 'Данные заявки')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Данные заявки</h1>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputPassword1">ФИО клиента</label>
                            <input type="text" class="form-control" id="clientname" name="clientname" value="{{ $demand['name'] }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Мобильный телефон</label>
                            <input type="text" class="form-control" id="email-copy-bank" name="clientphone" value="{{ $demand['contact_phone'] }}" disabled>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Тип недвижимости</label>
                                    <div class="icheck-primary">
                                        <input type="radio" id="estate-type-1" name="estatetype" value="1" disabled>
                                        <label for="estate-type-1">Первичка</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="estate-type-2" name="estatetype" value="2" disabled>
                                        <label for="estate-type-2">Вторичка</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="estate-type-3" name="estatetype" value="3" disabled>
                                        <label for="estate-type-3">Загородная</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Программа кредитования</label>
                                    <div class="icheck-primary">
                                        <input type="radio" id="credit-program-1" name="creditprogram" value="1" disabled>
                                        <label for="credit-program-1">Стандарт</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="credit-program-2" name="creditprogram" value="2" disabled>
                                        <label for="credit-program-2">Семейная ипотека</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="credit-program-3" name="creditprogram" value="3" disabled>
                                        <label for="credit-program-3">Господдержка</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="credit-program-4" name="creditprogram" value="4" disabled>
                                        <label for="credit-program-4">По двум документам</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="radio" id="credit-program-5" name="creditprogram" value="5" disabled>
                                        <label for="credit-program-5">Рефинансирование</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group" id="refinparams" style="display: none;">
                            <label for="exampleInputPassword1">Параметры текущего кредита:</label>
                            <div class="row">

                                <div class="col-sm-4">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">

                                        <label for="exampleInputPassword1">Ставка</label>
                                        <input type="text" class="form-control" id="refinpercent" name="refinpercent" placeholder="Введите текущую ставку">

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">

                                        <label for="exampleInputPassword1">Дата окончания</label>
                                        <input type="text" class="form-control" id="refindate" name="refindate" placeholder="Введите дату">

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">

                                        <label for="exampleInputPassword1">Остаток задолженности</label>
                                        <input type="text" class="form-control" id="refinbalance" name="refinbalance" placeholder="Введите остаток задолженности">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <label for="exampleInputPassword1">Тип недвижимости</label>
                                <select size="1" name="type" disabled>
                                    <option selected value="Квартира">{{ $demand['type'] }}</option>
                                    <option value="Дом">Дом</option>
                                    <option value="Земельный участок">Земельный участок</option>
                                    <option value="Дом+земельный участок">Дом+земельный участок</option>
                                    <option value="Таунхаус">Таунхаус</option>
                                    <option value="Машиноместо">Машиноместо</option>
                                    <option value="Коммерция">Коммерция</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <label for="exampleInputPassword1">Возраст клиента</label>
                                <input type="text" class="form-control" id="email-copy-bank" value="{{ $demand['age'] }}" name="clientage" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <label for="exampleInputPassword1">Стоимость</label>
                                <input type="text" class="form-control" id="email-copy-bank" value="{{ $demand['estate_summ'] }}" name="estatesumm" disabled>
                            </div>
                            <div class="col-sm-5">
                                <label for="exampleInputPassword1">Первый взнос</label>
                                <input type="text" class="form-control" id="email-copy-bank" value="{{ $demand['first_pay_summ'] }}" name="firstpaysumm" disabled>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="exampleInputPassword1">Заявка отправлена в банки:</label>
                            <div class="row">
                                @foreach($banks as $bank)
                                    <div class="col-sm-4">
                                        <!-- checkbox -->
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxBank-{{ $bank['id'] }}" name="{{ $bank['id'] }}" value="{{ $bank['id'] }}" disabled>
                                                <label for="checkboxBank-{{ $bank['id'] }}">
                                                    {{ $bank['name'] }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Файлы</label>
                            <div class="form-group">
                                <button type="button" id="downloadBtn" class="btn btn-success" onclick="">Скачать все файлы архивом</button>
                            </div>
                            @foreach(json_decode($demand['files']) as $file)
                                <div class="form-group clearfix">
                                    <a href="/clients/{{ $demand['uid'] . '/' . $file }}" target="_blank" class="mr-4"><i class="fas fa-file mr-1"></i>{{$file}}</a>
                                </div>
                            @endforeach

                        </div>

                        <!-- /.card-body -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
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
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        @endsection

        @section('specialscripts')
            <script>
                $('[data-mask]').inputmask()
                document.getElementById('estate-type-{{ $demand['estatetype'] }}').checked = true
                document.getElementById('credit-program-{{ $demand['creditprogram'] }}').checked = true
                result = {!! $demand['banks_list'] !!}
                for(var k in result) {
                    console.log(k, result[k]);
                    document.getElementById('checkboxBank-'+result[k]).checked = true
                }
                $('#downloadBtn').click(function() {
                    var serializeFormData = $('#form').serialize();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '/download',
                        data: { _token:"{{ csrf_token() }}", clientname: "{{ $demand['name'] }}", uid: "{{ $demand['uid'] }}" },
                        success: function(response){
                            window.location = response;
                        },
                        error:  function(data){
                            console.log('Внимание! произошла ошибка:' + data);
                        }
                    });
                });
            </script>
@endsection
