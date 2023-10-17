@extends('layouts.partner_layout')

@section('title', 'Главная')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новости компании Metr.Club</h1>
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
                    @foreach($news as $item)
                        <div class="card card-body col-6">
                            <div class="card-header">
                                <h3 class="card-title">{{$item->title}}</h3>
                            </div>
                            <div class="card-body">
                                {{$item->annotation}}
                                <div class="mt-3">{{$item->created_at}}<i class="far fa-eye ml-3"></i><span class="ml-1">{{$item->view_count}}</span></div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{route('partner_news', $item->id)}}">Читать далее</a>
                            </div>
                            <!-- /.card-footer-->
                        </div>
                    @endforeach
                        <div >
                            {{ $news->links('vendor.pagination.bootstrap-4') }}
                        </div>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    <!-- /.content -->
@endsection
@section('specialscripts')
            <!-- Yandex.Metrika counter -->
            <script type="text/javascript">
                (function (m, e, t, r, i, k, a) {
                    m[i] = m[i] || function () {
                        (m[i].a = m[i].a || []).push(arguments)
                    };
                    m[i].l = 1 * new Date();
                    for (var j = 0; j < document.scripts.length; j++) {
                        if (document.scripts[j].src === r) {
                            return;
                        }
                    }
                    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
                })
                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                ym(91125465, "init", {
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            </script>
@endsection

