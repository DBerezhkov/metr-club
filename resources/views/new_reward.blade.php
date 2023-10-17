 <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <link rel="stylesheet" href="/css/reward/style.css">
    <title>Комиссионное вознаграждение - Metr.Club</title>
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
</head>
<body>
<script src="{{ mix('js/app.js') }}" defer></script>
<div id="app">
    <reward-component :user="{{$user}}" agree="{{route('agree')}}" main="{{route('mainPage')}}"></reward-component>
</div>
<script src="/admin/plugins/jquery/jquery.min.js"></script>
</body>
</html>
