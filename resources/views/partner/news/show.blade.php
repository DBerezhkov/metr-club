@extends('layouts.partner_layout')

@section('title', 'Главная')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$news->title}}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="activity">
                        <div class="card card-body col-6">
                            <div class="card-body">
                                {!! $news->article_text !!}
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div>{{$news->created_at}}<i class="far fa-eye ml-3"></i><span class="ml-1">{{$news->view_count}}</span></div>
                            </div>
                            <!-- /.card-footer-->
                        </div>
                </div>
                <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
        </div>
    <!-- /.content -->

        <style>
            p {
                margin: 0;
            }
        </style>
@endsection
