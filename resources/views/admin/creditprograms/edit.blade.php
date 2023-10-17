@extends('layouts.admin_layout')

@section('title', 'Редактировать кредитную программу')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать кредитную программу</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('error'))
                <div class="alert alert-danger" role="'danger">
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
                        <form action="{{ route('credit_programs.update', $credit_program) }} " method="POST" id='formSnd'>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group col-4">
                                    <label for="exampleInputPassword1">Наименование программы кредитования</label>
                                    <input type="text" value="{{ $credit_program->title }}" class="form-control" id="title" name="title" required>
                                    @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                </div>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="enabled_demands" name="enabled_demands"
                                               value="1" {{$credit_program->enabled_demands == 1 ? 'checked' : ''}}
                                               @if($credit_program->id == 1) disabled @endif>
                                        <label for="enabled_demands">
                                            Включен для ипотеки
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="form-control" id="enabled_credits" name="enabled_credits"
                                               value="1" {{$credit_program->enabled_credits == 1 ? 'checked' : ''}}>
                                        <label for="enabled_credits">
                                            Включен для кредитов
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" id="btnSubmit" class="btn btn-success">Сохранить изменения</button>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

