<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Страховые</title>
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

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link type="image/x-icon" rel="shortcut icon" href="favicon.ico">
    <link type="image/png" sizes="16x16" rel="icon" href="favicon-16x16.png">
    <link type="image/png" sizes="16x16" rel="icon" href="favicon-32x32.png">
    <link type="image/png" sizes="192x192" rel="icon" href="android-chrome-192x192.png">
    <link type="image/png" sizes="512x512" rel="icon" href="android-chrome-512x512.png">
    <link sizes="180x180" rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="manifest" href="icons.json">
    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .table_dark {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
            font-size: 14px;
            text-align: left;
            border-collapse: collapse;
            background: #ffffff;
        }

        .table_dark th {
            color: #8e0d50;
            border-bottom: 1px solid #37B5A5;
            padding: 12px 17px;
            border: 1px solid #37B5A5;
            border-left: none;

        }

        .table_dark td {
            color: #000000;
            border-bottom: 1px solid #37B5A5;
            border-right: 1px solid #37B5A5;
            padding: 7px 17px;
            -moz-hyphens: auto;
            -webkit-hyphens: auto;
            -ms-hyphens: auto;
            text-align: center;
        }
        .cent {
            text-align: center;
        }
        .cd-block {
            display: flex;
            flex-direction: column;
            margin: 5px 0;
            align-items: center;
        }

        .cd-block span {
            border: 1px solid;
            border-radius: 5px;
            padding: 5px;
            color: #055160;
            background-color: #cff4fc;
            border-color: #b6effb;
        }

    </style>
</head>
<body class="antialiased">
<div class="cd-block"><span>Компания Metr.Club удерживает 20% от суммы получаемого от страховой компании комиссионного вознаграждения.</span></div>
<table class="table_dark">
    <thead>
    <tr>
        <th style="width: 5%" class="cent">
            #
        </th>
        @foreach($insurances as $insurance)
        <th class="cent">
            {{$insurance['name']}}
        </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @hasanyrole('partner|admin')
    <tr>
        <td>Контакты</td>
    @foreach($insurances as $insurance)
        <td>{!! $insurance['contacts'] !!}</td>
    @endforeach
    </tr>
    @endhasanyrole
    @foreach($banks as $bank)

        <tr class="border">
            <td><img src="/img/banks/{{ $bank['img'] }}" alt="" width="150"></td>
            @foreach($insurances as $insurance)
                @php
                    $r = (array) json_decode($insurance['percents']);
                @endphp
                <td class="text-center border">
                    @if(isset($r[$bank['id']])){{ $r[$bank['id']] }} @endif</td>
            @endforeach
        </tr>

        @endforeach
    </tbody>
</table>
<div class="cd-block"><span>Компания Metr.Club удерживает 20% от суммы получаемого от страховой компании комиссионного вознаграждения.</span></div>
</body>
</html>
