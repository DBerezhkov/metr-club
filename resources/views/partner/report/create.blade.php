@extends('layouts.partner_layout')

@section('title', 'Отчеты')
<script src="{{ asset('js/app.js') }}" defer></script>
@section('content')
    <section class="content">
        <div class="container-fluid">
                <div id="app">
                    <create-report-component></create-report-component>
                </div>
        </div>
    </section>
    <!-- /.content -->

@endsection
