@extends('layouts.admin_layout')

@section('title', 'Данные заявки')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <h1 class="m-0">Данные заявки</h1>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="exampleInputPassword1">ФИО клиента</label>
                                <input type="text" class="form-control" id="clientname" name="clientname" value="{{ $demand['name'] }}" disabled>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="exampleInputPassword1">Мобильный телефон</label>
                                <input type="text" class="form-control" id="email-copy-bank" name="clientphone" value="{{ $demand['contact_phone'] }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label for="exampleInputPassword1">Стоимость объекта</label>
                                <input type="text" class="form-control" id="email-copy-bank" value="{{ $demand['estate_summ'] }}" name="estatesumm" disabled>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="exampleInputPassword1">Первый взнос</label>
                                <input type="text" class="form-control" id="email-copy-bank" value="{{ $demand['first_pay_summ'] }}" name="firstpaysumm" disabled>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label for="exampleInputPassword1">Тип недвижимости</label>
                                <select class="custom-select" disabled>
                                    <option selected>{{$demand['type']}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mb-3">
                                <label for="exampleInputPassword1">Цель кредитования</label>
                                <select disabled class="custom-select">
                                    <option  @if($demand['estatetype']==1 )selected @endif>Первичка</option>
                                    <option  @if($demand['estatetype']==2) selected @endif>Вторичка</option>
                                    <option  @if($demand['estatetype']==3) selected @endif>Загородная</option>
                                </select>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="exampleInputPassword1">Программа кредитования</label>
                                <select disabled class="custom-select">
                                    <option @if($demand['creditprogram'] == 1) selected @endif>Стандарт</option>
                                    <option @if($demand['creditprogram'] == 2) selected @endif>Семейная ипотека</option>
                                    <option @if($demand['creditprogram'] == 3) selected @endif>Господдержка</option>
                                    <option @if($demand['creditprogram'] == 4) selected @endif>По двум документам</option>
                                    <option @if($demand['creditprogram'] == 5) selected @endif>Рефинансирование</option>
                                    <option @if($demand['creditprogram'] == 6) selected @endif>IT-ипотека</option>
                                    <option @if($demand['creditprogram'] == 7) selected @endif>Под залог недвижимости</option>
                                    <option @if($demand['creditprogram'] == 8) selected @endif>Военная ипотека</option>
                                </select>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="exampleInputPassword1">Регион залога</label>
                                <select disabled class="custom-select">
                                    <option selected>{{$pledges_region}}</option>
                                </select>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <label for="exampleInputPassword1">Регион сделки</label>
                                <select disabled class="custom-select">
                                    <option selected>{{$deals_region}}</option>
                                </select>
                            </div>
                        </div>
                        @if($demand['creditprogram'] == 5)
                            <div class="form-group" id="refinparams">
                                <label for="exampleInputPassword1">Параметры текущего кредита:</label>
                                <div class="row">

                                    <div class="col-sm-4 mb-3">
                                        <div class="form-group clearfix">

                                            <label for="exampleInputPassword1">Ставка</label>
                                            <input type="text" class="form-control" id="refinpercent" name="refinpercent" disabled value="{{$demand['refin_percent']}}">

                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <div class="form-group clearfix">

                                            <label for="exampleInputPassword1">Дата окончания</label>
                                            <input type="text" class="form-control" id="refindate" name="refindate"  disabled value="{{$demand['refin_date']}}">

                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <div class="form-group clearfix">

                                            <label for="exampleInputPassword1">Остаток задолженности</label>
                                            <input type="text" class="form-control" id="refinbalance" name="refinbalance" disabled value="{{$demand['refin_balance']}}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Комментарий к заявке:</label>
                            <textarea id="commentary" name="commentary" class="form-control" rows="3" disabled>@if($demand['commentary']) {{$demand['commentary']}}@endif</textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label for="exampleInputPassword1">Заявка отправлена в банки:</label>
                            <div class="row">
                                @foreach($banks as $bank)
                                    <div class="col-sm-3">
                                        <!-- checkbox -->
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxBank-{{ $bank['id'] }}" name="{{ $bank['id'] }}" disabled @if(in_array($bank['id'], $banks_list)) checked @endif>
                                                <label for="checkboxBank-{{ $bank['id'] }}">
                                                    {{ $bank['name'] }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if(isset($demand->offices_list) && json_decode($demand->offices_list) != null)
                            <div class="form-group">
                        <label for="exampleInputPassword1">Офисы банков:</label>
                        <div class="row">
                            @foreach($offices as $office)
                                @if($office['banks_name'] != '' && $office['office_name'] != '')
                                <div class="col-sm-3">
                                    <div class="form-group clearfix">
                                        <label for="exampleInputPassword1">{{$office['banks_name']}}</label>
                                        <select class="custom-select" size="1" disabled>
                                            <option>{{$office['office_name']}}</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                            </div>
                        @endif
                        @if(isset($demand->rate_list) && json_decode($demand->rate_list) != null)
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ставка для клиента:</label>
                                <div class="row">
                                    @foreach(json_decode($demand->rate_list, true) as $item)
                                        @foreach(json_decode($item) as $key => $rate)
                                        @if($key != '' && $rate != '')
                                            <div class="col-sm-3">
                                                <div class="form-group clearfix">
                                                    <label for="exampleInputPassword1">{{$banks->toArray()[array_search($key, array_column($banks->toArray(), 'id'))]['name']}}</label>
                                                    <select class="custom-select" size="1" disabled>
                                                        <option>{{$rate}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                        <div class="col-sm-4 mb-3 pl-0">
                            <label for="exampleInputPassword1">UID:</label>
                            <input type="text" class="form-control" id="email-copy-bank" value="{{ $demand['uid'] }}" disabled>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Файлы</label>
                            <div class="form-group row">
                                <button type="button" id="downloadBtn" class="btn btn-success" onclick="">Скачать все файлы архивом</button>
                                <button type="button" class="btn btn-danger ml-4" data-toggle="modal" data-target="#exampleModal">
                                    Удалить заявку
                                </button>
                            </div>
                            @foreach(json_decode($demand['files']) as $file)
                                <div class="form-group clearfix">
                                    <a href="/clients/{{ $demand['uid'] . '/' . $file }}" target="_blank" class="mr-4"><i class="fas fa-file mr-1"></i>{{$file}}</a>
                                </div>
                            @endforeach
                        </div>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Подтвердите действие</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Вы действительно хотите удалить заявку?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Оставить</button>
                                        <form action="{{route('demand.destroy', $demand)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger ml-3">Удалить заявку</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
