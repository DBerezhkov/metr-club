<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Оферта</title>

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
            text-align: center;
        }
        .my-link {
            border: 1px solid #c3e6cb;
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            margin-top: 21px;
            font-size: 30px;
            border-radius: 5px;

            color: #383d41;
            background-color: #e2e3e5;
            border-color: #d6d8db;

        }
        input{
            cursor: pointer;
        }
        label{
            cursor:pointer;
        }
        .mylinkagree{
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            cursor:pointer;
        }
    </style>
</head>
<body class="antialiased">
@hasanyrole('partner|admin')

<h1>ОФЕРТА</h1>
<p>Внимание! Для продолжения работы с сервисом, Вам необходимо согласиться с договором-офертой.</p>
<p>Пожалуйста, ознакомьтесь с приведенными ниже документами и нажмите кнопку "Даю согласие" внизу страницы.</p>
<div>
<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=https://metr.club/agreements_1.docx' width='960px' height='500px' frameborder='0'>Договор оферта 1</iframe>
    <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=https://metr.club/agreements_2.docx' width='960px' height='500px' frameborder='0'>Договор оферта 2</iframe>
</div>
<div>
    <div>
        <input type="checkbox" id="am"  name="am" value="a2"><label for="am">Соглашаюсь с офертой ООО «АМ ГРУПП»</label><Br>
        <input type="checkbox" id="metr" name="metr" value="a3"><label for="metr">Соглашаюсь с офертой ООО «МЕТР.КЛАБ»</label><Br>
        <button disabled id="my-link" class="my-link" href="/agreement/accept">Продолжить</button>
    </div>
    <script>
        function hasClass(ele,cls) {
            return !!ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
        }

        function addClass(ele,cls) {
            if (!hasClass(ele,cls)) ele.className += " "+cls;
        }

        function removeClass(ele,cls) {
            if (hasClass(ele,cls)) {
                var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
                ele.className=ele.className.replace(reg,' ');
            }
        }

        var checkbox1 = document.querySelector('#am')
        var checkbox2 = document.querySelector('#metr')
        var mylink = document.querySelector('#my-link')

        window.ischk1 = false;
        window.ischk2 = false;

        checkbox1.addEventListener('change', function() {
            window.ischk1 = checkbox1.checked;

            if (window.ischk1 && window.ischk2) {
                mylink.disabled = false;
                addClass(mylink,'mylinkagree');
            }else{
                mylink.disabled = true;

                removeClass(mylink,'mylinkagree');
            }
        });

        checkbox2.addEventListener('change', function() {
            window.ischk2 = checkbox2.checked;
            if (window.ischk1 && window.ischk2) {
                mylink.disabled = false;
                addClass(mylink,'mylinkagree');
            }else{
                mylink.disabled = true;

                removeClass(mylink,'mylinkagree');
            }
        });
        mylink.addEventListener('click', function(e) {
            e.preventDefault();
            location.href = '/agreement/accept';
            return false;
        });

    </script>
</div>

@endhasanyrole
</body>
</html>
