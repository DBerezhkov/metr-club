<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Metr.Club и IpotekaPro</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/css/styles.css" />
    <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico">
    <link type="image/png" sizes="16x16" rel="icon" href="/favicon-16x16.png">
    <link type="image/png" sizes="16x16" rel="icon" href="/favicon-32x32.png">
    <link type="image/png" sizes="192x192" rel="icon" href="/android-chrome-192x192.png">
    <link type="image/png" sizes="512x512" rel="icon" href="/android-chrome-512x512.png">
    <link sizes="180x180" rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/icons.json">
</head>
<body>
<main class="main">
    <div class="main__left">
        <div class="logos">
            <img src="/img/metr.club.png" alt="Metr.club" />
            <img src="/img/ipoteka.png" alt="Ipoteka" />
        </div>
    </div>
    <div class="main__right">
        @if (session('success'))
            <div class="alert alert-success" role="'alert">
                <h2><i class="icon fa fa-check"></i>{{ session('success') }}</h2>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="'danger">
                <h2><i class="icon fa fa-x"></i>{{ session('error') }}</h2>
            </div>
        @endif
        <form class="form" action="/ipotekapro/register" method="POST">
            @csrf
            <div class="form__item">
                <label for="firstname">Имя*</label>
                <input
                    id="firstname"
                    name="firstname"
                    type="text"
                    placeholder="Введите имя"
                    required
                />
            </div>

            <div class="form__item">
                <label for="surname">Фамилия*</label>
                <input
                    id="surname"
                    name="surname"
                    type="text"
                    placeholder="Введите фамилию"
                    required
                />
            </div>

            <div class="form__item">
                <label for="login">Логин*</label>

                <div class="email-input">
                    <input
                        id="login"
                        name="login"
                        type="text"
                        placeholder="Введите логин"
                        required
                    />
                    <div class="email-input__domen">@metr.club</div>
                </div>
            </div>

            <div class="form__item">
                <label for="phone">Телефон*</label>
                <input id="phone" name="phone" type="text" placeholder=""
                data-inputmask='"mask": "9 (999) 999-99-99"'
                data-mask/>
            </div>

            <div class="form__item">
                <label for="interaction-form">Форма взаимодействия*</label>

                <select
                    name="interactionform"
                    id="interaction-form"
                >
                    <option  disabled>Выберите форму взимодействия</option>
                    <option selected value="ООО">ООО</option>
                    <option value="ИП">ИП</option>
                    <option value="Самозанятый">Самозанятый</option>
                </select>


            </div>

            <div class="form__item">
                <label for="surname">Ваш логин Telegram (если есть)</label>
                <input
                    id="surname"
                    name="tglogin"
                    type="text"
                    placeholder="Введите логин"
                />
                <button class="submit-btn" type="submit">Отправить</button>
            </div>

            <div class="form__item">Поля со знаком * обязательны к заполнению</div>

        </form>
    </div>
</main>
<!-- jQuery -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- InputMask -->
<script src="/admin/plugins/inputmask/jquery.inputmask.min.js"></script>
<script>
    $('[data-mask]').inputmask()
</script>
</body>
</html>
