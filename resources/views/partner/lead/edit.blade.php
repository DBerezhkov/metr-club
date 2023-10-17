@extends('layouts.partner_layout')

@section('title', 'Лиды')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <form action="{{ route('leads.update', $lead->id) }} " method="POST" id='formSnd' enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <p>Автор: {{ $lead->manager['name'] }}</p>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">ФИО клиента</label>
                                    <input type="text" class="form-control" id="clientname" name="name" value="{{$lead->name}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Мобильный телефон</label>
                                    <input type="text" class="form-control" id="email-copy-bank" name="phone" value="{{$lead->phone}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Комментарий</label>
                                    <input type="text" class="form-control" id="email-copy-bank" name="comment" value="{{$lead->comment}}" disabled>
                                </div>
                                <div class="form-group">
                                    <p>Комментарий сотрудника:</p>
                                    <textarea name="user_comment" id="" cols="50" rows="5">{{$lead->user_comment}}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="exampleInputPassword1">Статус</label>
                                        <select size="1" name="status" id="select">
                                            <option disabled>Выберите Тип</option>
                                            <option selected value="0">Новый</option>
                                            <option value="4">В работе</option>
                                            <option value="1">Хороший</option>
                                            <option value="2">Плохой</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" id='btnSubmit' class="btn btn-primary ">Сохранить</button>
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
        const select = document.querySelector('#select').getElementsByTagName('option');
        i = {{$lead->status}} + 1;
        select[i].selected = true;
    </script>
@endsection
