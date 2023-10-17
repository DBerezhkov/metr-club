@extends('layouts.admin_layout')

@section('title', 'Заявки на потребы')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Просмотр заявки на кредит</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Тип кредита</label>
                                    <select class="form-control" name="type" id="credit-type" disabled>
                                        <option data-iconurl="tinkoff">@if($credit->creditprogram)
                                                {{ $credit->creditprogram['title'] }}
                                            @endif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="exampleInputPassword1">ФИО клиента</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" value="{{ $credit['name']  }}" class="form-control" id="name" name="name" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="exampleInputPassword1">Мобильный телефон</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        </div>
                                        <input type="text" value="{{ $credit['phone'] }}" class="form-control" id="phone" name="phone" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="exampleInputPassword1">Сумма кредита</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                        </div>
                                        <input type="text" value="{{ $credit['price'] }}" class="form-control" id="first_payment" name="first_payment" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

@endsection

