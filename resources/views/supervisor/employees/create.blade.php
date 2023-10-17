@extends('layouts.partner_layout')

@section('title', 'Добавить агента')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавление агента</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if(isset($template))
                            <div class="p-3 m-1">
                                {!! $template !!}
                            </div>
                        @else
                        <form id="addAgentForm" action="{{ route('employees.store') }} " method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-3">
                                        <label>Имя</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name" placeholder="Введите имя пользователя" required>
                                        </div>
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6 mb-3">
                                        <label>Фамилия</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('surname') }}" class="form-control" id="surname" name="surname" placeholder="Введите фaмилию пользователя" required>
                                        </div>
                                        @error('surname')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-3">
                                        <label>E-mail</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('login') }}" class="form-control" id="login" name="login" placeholder="Введите e-mail" required data-inputmask-regex="^[A-Za-z0-9_@\.\-]+$" data-mask>
                                        </div>
                                        @error('login')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6 mb-3">
                                        <label>Телефон</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('telnumber') }}" class="form-control" id="telnumber" name="telnumber" placeholder="+7(___) ___ __ __" required  data-inputmask='"mask": "+7(999)999-99-99"' data-mask>
                                        </div>
                                        @error('telnumber')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label>Логин в Telegram (при наличии)</label>
                                        <div class="input-group">
                                            <input type="text" value="{{ old('tglogin') }}" class="form-control" id="tglogin" name="tglogin" placeholder="Введите логин" data-inputmask-regex="^@?[A-Za-z0-9_]+$" data-mask>
                                        </div>
                                        @error('tglogin')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button id="btnSubmit" type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <!-- Модальное окно -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Агент успешно добавлен!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Данные для входа в CRM отправлены агенту на электронную почту.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection
@section('specialscripts')
    <script>
        $(document).ready(function () {
            $('[data-mask]').inputmask();

            $('#tglogin').inputmask({"placeholder": ""});
            $('#login').inputmask({"placeholder": ""});
            $('#addAgentForm').submit(function(){
                document.getElementById("btnSubmit").disabled = true;
                $('#btnSubmit').html("Подождите...");
            })

        });

        @if(session('success'))
        $('#exampleModal').modal('show')
        @endif
    </script>
@endsection
