@extends('layouts.admin_layout')

@section('title', 'Список банков')
@section('content')
    <script src="{{ mix('js/app.js') }}" defer></script>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список банков</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="app">
                <index-bank-component :url="'{{route('bank.index')}}'" :banks="{{ $banks }}"></index-bank-component>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
