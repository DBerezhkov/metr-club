@extends('layouts.admin_layout')

@section('title', 'Программы кредитования')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Настройка программ кредитования</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div><!-- /.container-fluid -->

    </div>

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-5">
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
                <a class="btn btn-success mb-4" href="{{route('credit_programs.create')}}">Добавить программу кредитования</a>
                <div class="card card-primary">
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Наименование
                                </th>
                                <th>
                                    Ипотека
                                </th>
                                <th>
                                    Кредит
                                </th>
                                <th>
                                    Управление
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($credit_programs as $item)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $item['title'] }}
                                    </td>
                                    <td>
                                        <span class="{{$item['enabled_demands'] ? 'text-success':'text-danger'}}">{{$item['enabled_demands'] ? 'Да':'Нет'}}</span>
                                    </td>
                                    <td>
                                        <span class="{{$item['enabled_credits'] ? 'text-success':'text-danger'}}">{{$item['enabled_credits'] ? 'Да':'Нет'}}</span>
                                    </td>
                                    <td style="display: flex;">
                                        <a class="btn btn-success btn-sm" href="{{route('credit_programs.edit', $item['id'])}}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @if($item['id'] != 1)
                                            <form method="POST" action="{{route('credit_programs.destroy', $item->id)}}" class="ml-3">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

