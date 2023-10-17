<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="/css/registration/style.css">
    <link rel="stylesheet" href="/css/registration/dadata.css">
    <title>Регистрация</title>
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
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/91125465" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>
<body>
<div class="wrapper">
    <div class="index">
        <div class="index__container">
            <div class="index__content">
                <div class="content__brand-names">
                    <div class="brand__names-metr">metr.<span>club</span></div>
                </div>
                <div class="content__text">
                    <img src="img/registration/Line 12.svg" alt="">
                    <p class="text__main">Подавайте заявки в банки и страховые компании с нашей помощью</p>
                    <div class="text__body">
                        <div style="margin-bottom: 15px;">Работайте с банками и страховыми компаниями напрямую и зарабатывайте самое высокое комиссионное вознаграждение:</div>
                        <div>- по ипотеке <span>до 2 %</span></div>
                        <div>- по потребам <span>до 0,4 %</span></div>
                        <div>- по страховым <span>до 60 %</span></div>
                       </div>
                </div>
                <div class="content__logotypes">
                    <div class="logotypes__metr">
                        <img src="img/registration/metr-club.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="index__footer">
                <div class="footer_copyright">2022 © ООО "Метр.Клаб", <span>ИНН 7735193697</span></div>
            </div>
        </div>
    </div>
    <div class="registration">
        <div class="registration__container">
            <div class="registration__content">
                <div class="registration__text">
                    <div class="text__title">Зарегистрироваться - просто!</div>
                    <div class="text_after-title">После завершения регистрации вы получите информацию по работе в системе на ваш e-mail. Не забудьте проверить папку "Спам"
                    </div>
                    <div class="text__description-form">Поля отмеченные ( * ) необходимы для заполнения</div>
                </div>
                <form id="form" name="form">
                    @csrf
                    <div class="content__form">
                        <div class="content_row1">
                            <div class="row1__column1">
                                <div class="labels"><label for="name">Имя</label></div>
                                <div class="field"><input type="text" id="name" name="name" placeholder="Введите имя"
                                                          class="input__name" required></div>
                            </div>

                            <div class="row2__column1">
                                <div class="labels"><label for="surname">Фамилия</label></div>
                                <div class="field"><input type="text" id="surname" name="surname"
                                                          placeholder="Введите фамилию" required></div>
                            </div>

                        </div>
                        <div class="content_row2">
                            <div class="row1__column2">
                                <div class="labels"><label for="login">Ваш e-mail</label></div>
                                <div class="field field-with_icon">
                                    <input type="text" id="login" name="login" placeholder="Введите e-mail" required
                                           data-inputmask-regex="^[A-Za-z0-9_@\.\-]+$" data-mask>
                                </div>
                            </div>
                            <div class="row2__column2">
                                <div class="labels"><label for="telnumber">Телефон</label></div>
                                <div class="field"><input type="text" id="telnumber" name="telnumber"
                                                          placeholder="+7(___) ___ __ __" required
                                                          data-inputmask='"mask": "+7(999)999-99-99"' data-mask></div>
                            </div>
                        </div>
                        <div class="content_row3">
                            <div class="form-group">
                                <div class="dropdown">
                                    <div class="labels"><label for="form-of-interaction">Форма взаимодействия</label>
                                    </div>
                                    <div id="labelsSelector"></div>
                                    <button id="form-of-interaction" class="dropdown__button" onclick="return false">
                                        Выберите из списка
                                    </button>
                                    <ul class="dropdown__list">
                                        <li class="dropdown__list-item" data-value="ООО">ООО</li>
                                        <li class="dropdown__list-item" data-value="ИП">ИП</li>
                                        <li class="dropdown__list-item" data-value="Самозанятый">Самозанятый</li>
                                    </ul>
                                    <input type="text" name="form_of_interaction" value=""
                                           class="dropdown__input-hidden" id="selectorsInput" required>
                                </div>
                            </div>

                            <div class="row2__column3">
                                <div class="labels no-required"><label for="tglogin">Ваш логин Telegram (при
                                        наличии)</label></div>
                                <div class="field"><input type="text" id="tglogin" name="tglogin"
                                                          placeholder="Введите логин"
                                                          data-inputmask-regex="^@?[A-Za-z0-9_]+$" data-mask></div>
                            </div>

                        </div>

                        <div class="content_row4">
                            <div class="labels"><label for="howKnowAboutUs">Откуда вы о нас узнали?</label></div>
                            <div class="field"><input type="text" id="howKnowAboutUs" name="how_know_about_us"
                                                      placeholder="Напишите здесь" class="input__name" required></div>
                        </div>
                        <div class="form__agreement">
                            <div class="checkbox">
                                <div class="checkbox__input"><input type="checkbox" id="agreement" name="agreement"
                                                                    value="" required></div>
                                <div class="checkbox__label"><label for="agreement">
                                        Настоящим даю <a href="{{route('sopd')}}" class="text-underline">согласие на передачу и обработку моих вышеуказанных персональных
                                        данных</a> ООО "Метр.Клаб"</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="line-registration"><img src="img/registration/line-registration.svg" alt=""></div>
                    <div class="content__button">
                        <input type="submit"
                               id="btnSubmit"
                               value="Отправить"
                               class="popup-link button-submit g-recaptcha"
                               data-sitekey="6Lc1pgYjAAAAADJ8mmpUqB8mg8RG3pAZ4r9I-vDa"
                               data-callback='onSubmit'
                               data-action='submit'>
                    </div>

                    @php
                        $utms = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
                        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $url = explode('?', $url);
                        $url = $url[0];
                    @endphp
                    @foreach($utms as $utm)
                        <input type="hidden" name="{{$utm}}" value="{{$_GET[$utm] ?? 'none'}}">
                    @endforeach
                        <input type="hidden" name="url" value="{{$url}}">
                </form>
            </div>
            <div class="registration__footer">
                <div class="footer__subscribe">Подпишитесь на наши новости :</div>
                <div class="footer__icons">
                    <a href="https://www.facebook.com/profile.php?id=100067640635425"><img
                            src="img/registration/icons/fb.svg" alt="" class="facebook"></a>
                    <a href="https://t.me/metrclub"><img src="img/registration/icons/telegram.svg" alt=""
                                                         class="telegram"></a>
                    <a href="https://www.instagram.com/metr.club/"><img src="img/registration/icons/instagram.svg"
                                                                        alt="" class="instagram"></a>
                    <a href="https://vk.com/metr.club"><img src="img/registration/icons/vk.svg" alt="" class="vk"></a>
                    <a href="https://ok.ru/group/58794082369539"><img src="img/registration/icons/classmate.svg" alt=""
                                                                      class="classmate"></a>
                </div>
                <div class="footer_copyright mobile-footer">2022 © ООО "Метр.Клаб", <span>ИНН 7735193697</span></div>
            </div>
        </div>
    </div>

    <div id="popup" class="popup">
        <div class="popup__body">
            <div class="popup__content">
                <div class="popup__icon" id="popupIcon">
                    <img src="img/registration/icons/popup-icon.svg" alt="" id="registrationIcon">
                    <img src="img/registration/preloader.png" alt="" id="preloader" style="margin-bottom: 100px">
                </div>
                <div class="popup__title" id="popupTitle">
                    <div id="title1">Ваша заявка</div>
                    <div id="title2">успешно отправлена</div>
                </div>
                <div class="popup__text" id="popupText">
                    <div id="successRegistrationText">На ваш e-mail отправлена информация с регистрационными данными.
                    </div>
                </div>
                <a href="{{ route('registration.form') }}" class="popup__close close-popup" id="popupButton">Принято!</a>
            </div>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="{{asset("/admin/plugins/jquery/jquery.min.js")}}"></script>
<script src="{{asset("/admin/plugins/inputmask/jquery.inputmask.min.js")}}"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
<script src="js/registration/selector.js"></script>
<script src="js/registration/popup.js"></script>
<script>
    $(document).ready(function () {
        $('[data-mask]').inputmask();

        $('#tglogin').inputmask({"placeholder": ""});
        $('#login').inputmask({"placeholder": ""});
    });


    $(document).ready(function () {
//CHECKBOX

        if ($('.checkbox__input').find('input').prop('checked') === true) {
            $('.checkbox__input').addClass('active');
        }
        $(document).on('click', '.checkbox__input', function (event) {
            if ($(this).hasClass('active')) {
                $(this).find('input').prop('checked', false);
            } else {
                $(this).find('input').prop('checked', true);
            }
            $(this).toggleClass('active');
        });


    });

    //CAPTCHA
    function onSubmit(token) {
        sendData();
    }


</script>
</body>
</html>
