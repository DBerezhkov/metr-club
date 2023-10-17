@extends('layouts.partner_layout')

@section('title', 'Добавить заявку')
@section('content')
    <script src="{{ mix('js/app.js') }}" defer></script>
    <div class="content-wrapper ml-0" style="display: table; width: 100%">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="ml-2">Новая заявка на кредит</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div id="app">
                    <create-credit-component></create-credit-component>
                </div>
            </div>
        </section>
    </div>


@endsection

