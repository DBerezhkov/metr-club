@extends('layouts.partner_layout')

@section('title', 'Данные заявки')

@section('content')
    <script src="{{ mix('js/app.js') }}" defer></script>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <h1 class="m-0">Данные заявки</h1>
                    <div class="card-body">
                        <div id="app">
                            <show-demand-component :demand="{{ $demand }}" pledges_region="{{$pledges_region}}" deals_region="{{$deals_region}}"></show-demand-component>
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
            </script>
@endsection
