@extends('layouts.partner_layout')

@section('title', 'Отчеты')
<script src="{{ asset('js/app.js') }}" defer></script>
@section('content')
    <section class="content">
        <div class="container-fluid">
            <h1>Отчеты</h1>
                <div id="app">
                    <index-report-component></index-report-component>
                </div>
        </div>
    </section>
    <!-- /.content -->

@endsection
