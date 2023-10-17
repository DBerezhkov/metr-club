@extends('layouts.admin_layout')

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
                <div class="col-md-4">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        @if(isset($passwd))
                            <div class="p-3 m-1"><p>Создан новый пользователь!</p>

                                <p>Почта: {{ $new_mail }}</p>
                                <p>Пароль: {{ $passwd }}</p>
                                <p>Доступ в CRM: https://metr.club/partner</p>
                            </div>
                        @else
                        <form action="{{ route('users.store') }} " method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Имя</label>
                                    <div class="input-group">
                                        <input type="text" value="{{ old('name') }}" class="form-control col-10" id="name" name="name" placeholder="Введите имя пользователя" required>
                                    </div>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Фамилия</label>
                                    <div class="input-group">
                                        <input type="text" value="{{ old('fname') }}" class="form-control col-10" id="fname" name="fname" placeholder="Введите фaмилию пользователя" required>
                                    </div>
                                    @error('fname')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Логин</label>
                                    <div class="input-group mb-3">

                                        <input type="text" value="{{ old('login') }}" class="form-control col-7" id="login" name="login" placeholder="Введите логин" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">@metr.club</span>
                                        </div>
                                        @error('login')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Пароль</label>
                                    <input type="text" value="{{ old('password') }}" class="form-control col-10 mb-2" id="password" name="password" placeholder="Введите пароль" required>
                                    @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <a href="#" id="random">Сгенерировать пароль</a>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </form>
                        @endif
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
        const login = document.querySelector('#login')
        login.addEventListener('input', function(){
            console.log(login.value)

        })

        $(document).ready(function () {
            $('#random').click(function () {
                var randPassword = Array(16).fill("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()-_=+[]{};:,.<>?").map(function (x) {
                    return x[Math.floor(Math.random() * x.length)]
                }).join('');
                $('#password').val(randPassword);
                $('.content').effect( "bounce", 1000 );
            })
        });
    </script>
@endsection
