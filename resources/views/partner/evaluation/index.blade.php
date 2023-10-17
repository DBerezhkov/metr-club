@extends('layouts.partner_layout')

@section('title', 'Оценки')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Заявки на оценку</h1>
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
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 5%">
                                    #
                                </th>
                                <th style="width: 15%">
                                    Контакт
                                </th>
                                @if(auth()->user()->hasRole('supervisor'))
                                <th style="width: 15%">
                                    Сотрудник
                                </th>
                                @endif
                                <th style="width: 15%">
                                    Телефон
                                </th>
                                <th style="width: 15%">
                                    Дата
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($evaluations as $eval)

                                <tr>
                                    <td>
                                        {{ $eval['id'] }}
                                    </td>
                                    <td>
                                        {{ $eval['contact'] }}
                                    </td>
                                    @if(auth()->user()->hasRole('supervisor'))
                                    <td>
                                        @if($eval->agent)
                                        <a href="{{route('employees.show', $eval->agent_id)}}" target="_blank">{{$eval->agent->name}}</a>
                                        @elseif($eval->agent()->withTrashed()->get()->first() != null)
                                            <div>{{$eval->agent()->withTrashed()->get()->first()->name}}</div>
                                        @endif
                                    </td>
                                    @endif
                                    <td>
                                        {{ $eval['clientphone'] }}
                                    </td>
                                    <td>
                                        {{ $eval['created_at'] }}
                                    </td>
                                    <!--td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{route('evaluations.show', $eval->id)}}">
                                            <i class="fas fa-user-edit">
                                            </i>
                                            Открыть
                                        </a>
                                    </td-->
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

@section('specialscripts')
    <!-- Page specific script -->
    <script>
        $('[data-mask]').inputmask()
    </script>
@endsection
