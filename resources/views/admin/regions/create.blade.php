@extends('layouts.admin_layout')

@section('title', 'Обновление региона')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новый регион</h1>
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
                        <form action="{{ route('regions.store') }} " method="POST" id='formSnd'>
                            @csrf
                            <div class="card-body">

                                    <div class="form-group col-4 pl-0">
                                        <label for="exampleInputPassword1">Наименование региона</label>
                                        <input type="text" value="{{ old('name') }}" class="form-control" id="title" name="title" required>
                                        @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                <button type="submit" id="btnSubmit" class="btn btn-success">Добавить регион</button>
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

