<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>
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

        }

        .cent {
            text-align: center;
        }

        a.login:link, a.agreement_link {
            color: #0000EE;
        }

         p {
             margin: 0;
         }

    </style>
</head>
<body class="antialiased">
<table class="table_dark">
    <thead>
    <tr>
        <th style="width: 5%" class="cent">
            #
        </th>
        <th class="cent">
            Банки
        </th>
        <th class="cent" style="width: 30%">
            Размер комиссионного вознаграждения, выплачиваемого агентам компанией Metr.Club
        </th>
{{--                @hasanyrole('partner|admin')--}}
        <th class="cent" colspan="2" style="width: 5%">
            Данные для отправки заявок
        </th>
{{--                @endhasanyrole--}}
        <th class="cent">
            Дополнительная инфо/Инструкции
        </th>
        @hasanyrole('partner|admin')
        <th class="cent">
            Дата обновления
        </th>
        @endhasanyrole
    </tr>
    </thead>
    <tbody>
    @foreach($rewards as $bank)
        @if($bank['only_text'] == 1)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    <img src="/img/banks/{{ $bank['img'] }}" alt="" width="150">
                </td>

                <td>
                    {!! $bank['description'] !!}
                </td>
                @hasanyrole('partner|admin')
                @if(auth()->user()->agreement)
                <td colspan="2">
                    {!! $bank['text'] !!}
                </td>
                @else
                    <td class="cent" colspan="2"><a href="{{route('agree')}}" class="agreement_link"><b>Для просмотра примите условия
                                оферты</b></a></td>
                @endif
                @else
                    <td class="cent" colspan="2"><a href="{{route('login')}}" class="login"><b>Для просмотра авторизуйтесь</b></a></td>
                    @endhasanyrole
                    @hasanyrole('partner|admin')
                    @if(auth()->user()->agreement)
                    <td>
                        {!! $bank['advanced_description'] !!}
                    </td>
                    @else
                        <td class="cent"><a href="{{route('agree')}}" class="agreement_link"><b>Для просмотра примите условия
                                    оферты</b></a></td>
                    @endif
                    @else
                        <td class="cent" colspan="2" rowspan="{{$counter}}"><a href="{{route('login')}}" class="login"><b>Для просмотра авторизуйтесь</b></a></td>
                    @endhasanyrole
                    @hasanyrole('partner|admin')
                    <td>
                        {{ $bank->prettyDate() }}
                    </td>
                    @endhasanyrole
            </tr>
        @else
            @php
                $counter = 0;
                $mail_for_demands = false;
                $curator = false;
                $lk = false;
                $bank_contacts = false;
                $flag = ['mail_for_demands' => false,
                            'curator' => false,
                            'lk' => false,
                            'bank_contacts' => false
                            ];
                if (isset($bank['mail_for_demands'])) {
                    $counter++;
                    $mail_for_demands = true;
                }
                if (isset($bank['curator'])) {
                    $counter++;
                    $curator = true;
                }
                if (isset($bank['lk'])) {
                    $counter++;
                    $lk = true;
                }
                if (isset($bank['bank_contacts'])) {
                    $counter++;
                    $bank_contacts = true;
                }
                if (!Auth::check() || !auth()->user()->agreement) {
                    $counter = 1;
                }
            @endphp
            <tr>
                <td rowspan="{{ $counter }}">
                    {{ $loop->iteration }}
                </td>

                <td rowspan="{{ $counter }}">
                    <img src="/img/banks/{{ $bank['img'] }}" alt="" width="150">
                </td>

                <td rowspan="{{ $counter }}">
                    {!! $bank['description'] !!}
                </td>
                            @hasanyrole('partner|admin')
                @if(auth()->user()->agreement)
                @if(isset($bank['mail_for_demands']))
                    @php
                        $flag['mail_for_demands'] = true;
                    @endphp
                    <td class="cent">Почта для заявок</td>
                    <td>{!! $bank['mail_for_demands']  !!}</td>
                    @elseif(isset($bank['curator']))
                        @php
                            $flag['curator'] = true;
                        @endphp
                        <td class="cent">Куратор в банке</td>
                        <td>{!! $bank['curator']  !!}</td>
                        @elseif(isset($bank['$lk']))
                            @php
                                $flag['lk'] = true;
                            @endphp
                            <td class="cent">Личный кабинет</td>
                            <td><a href="{{ $bank['lk']  }}">{!! $bank['lk']  !!}</a></td>
                            @elseif(isset($bank['bank_contacts']))
                                @php
                                    $flag['bank_contacts'] = true;
                                @endphp
                                <td class="cent">Контакты банка по заявке</td>
                                <td>{!! $bank['bank_contacts'] !!}</td>
                            @endif
                @else
                    <td class="cent" colspan="2" rowspan="{{ $counter }}"><a href="{{route('agree')}}" class="agreement_link"><b>Для просмотра примите условия
                                оферты</b></a></td>
                @endif
                @else
                    <td class="cent" colspan="2" rowspan="{{$counter}}"><a href="{{route('login')}}" class="login"><b>Для просмотра авторизуйтесь</b></a></td>
                    @endhasanyrole
                    @hasanyrole('partner|admin')
                    @if(auth()->user()->agreement)
                    <td rowspan="{{ $counter }}">
                                {!! $bank['advanced_description']  !!}
                            </td>
                    @else
                        <td class="cent"><a href="{{route('agree')}}" class="agreement_link"><b>Для просмотра примите условия
                                    оферты</b></a></td>
                    @endif
                    @else
                        <td class="cent" colspan="2" rowspan="{{$counter}}"><a href="{{route('login')}}" class="login"><b>Для просмотра авторизуйтесь</b></a></td>
                    @endhasanyrole
                    @hasanyrole('partner|admin')
                            <td rowspan="{{ $counter }}">
                                {{ $bank->prettyDate() }}
                            </td>
                    @endhasanyrole
            </tr>
                        @hasanyrole('partner|admin')
            @if(auth()->user()->agreement)
                @if((isset($bank['mail_for_demands']) && ($mail_for_demands)) && (!$flag['mail_for_demands']))
                <tr>
                    <td class="cent">Почта для заявок</td>
                    <td>{!! $bank['mail_for_demands']  !!}</td>
                </tr>
            @endif

            @if((isset($bank['curator'])) && ($curator) && (!$flag['curator']))
                <tr>
                    <td class="cent">Куратор в банке</td>
                    <td>{!! $bank['curator']  !!}</td>
                </tr>
            @endif

            @if((isset($bank['lk'])) && ($lk) && (!$flag['lk']))
                <tr>
                    <td class="cent">Личный кабинет</td>
                    <td><a href="{{ $bank['lk']  }}">{!! $bank['lk']  !!}</a></td>
                </tr>
            @endif

            @if((isset($bank['bank_contacts'])) && ($bank_contacts) && (!$flag['bank_contacts']))
                <tr>
                    <td class="cent">Контакты банка по заявке</td>
                    <td>{!! $bank['bank_contacts'] !!}</td>
                </tr>
            @endif
            @endif
                        @endhasanyrole
        @endif
    @endforeach
    </tbody>
</table>
</body>
</html>
