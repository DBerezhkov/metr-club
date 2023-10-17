    const tok = "50e09e9a559d764a0dd75936e507e2469d53b34d"
    const hnt = "Возможно, вы имели ввиду:"
    $("#name").suggestions({
        token: tok,
        type: "NAME",
        minChars: 3,
        hint: hnt,
    });

    $("#surname").suggestions({
        token: tok,
        type: "NAME",
        minChars: 3,
        hint: hnt,
    });

    $("#login").suggestions({
        token: tok,
        type: "EMAIL",
        suggest_local: false,
        hint: hnt,
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function sendData() {
        if (document.body.contains(document.getElementById('preloadText'))) {
            document.getElementById('preloadText').remove();
        }
        const popupTitle = document.createElement('div');
        popupTitle.setAttribute("id", "preloadText");
        popupTitle.innerText = 'Подождите...';

        //e.preventDefault();
            let name = $("input[name=name]").val();
            let surname = $("input[name=surname]").val();
            let login = $("input[name=login]").val();
            let telnumber = $("input[name=telnumber]").val();
            let form_of_interaction = $("input[name=form_of_interaction]").val();
            let tglogin = $("input[name=tglogin]").val();
            let how_know_about_us = $("input[name=how_know_about_us]").val();
            let url = $("input[name=url]").val();
            let agreement = $("input[name=agreement]").prop('checked');
            let utm_source = $("input[name=utm_source]").val();
            let utm_medium = $("input[name=utm_medium]").val();
            let utm_campaign = $("input[name=utm_campaign]").val();
            let utm_content = $("input[name=utm_content]").val();
            let utm_term = $("input[name=utm_term]").val();



            let formReq = document.querySelectorAll('input[required]');

            for (let formReqElement of formReq) {
                if (formReqElement.getAttribute("type") === "checkbox" && $("input[name=agreement]").prop('checked') === true) {
                    $('.checkbox').removeClass('error_checkbox');
                }
                if (formReqElement.value !== '') {
                    formReqElement.parentElement.classList.remove('error');
                    formReqElement.classList.remove('error');
                }
                if (document.getElementById('selectorsInput').value !== '') {
                    document.getElementById('form-of-interaction').classList.remove('error');
                    document.getElementById('labelsSelector').classList.remove('error_selector');

                }
            }
        $(document).ready(function () {
            $('#btnSubmit').prop('disabled', true);
            document.getElementById('btnSubmit').style.cssText  = 'background-color: #e2e9f0';
            document.getElementById('btnSubmit').value  = 'Подождите';
            document.getElementById('title1').style.display = "none";
            document.getElementById('title2').style.display = "none";
            document.getElementById('popupButton').style.display = "none";
            document.getElementById('registrationIcon').style.display = "none";
            document.getElementById('successRegistrationText').style.display = "none";
            document.querySelector('#popupTitle').appendChild(popupTitle);
            $('.popup').fadeIn();
        })

            $.ajax({
                type: 'POST',
                url: "/registration",
                data: {
                    name: name,
                    surname: surname,
                    login: login,
                    telnumber: telnumber,
                    form_of_interaction: form_of_interaction,
                    tglogin: tglogin,
                    agreement: agreement,
                    how_know_about_us: how_know_about_us,
                    url: url,
                    utm_source:utm_source,
                    utm_medium:utm_medium,
                    utm_campaign:utm_campaign,
                    utm_content:utm_content,
                    utm_term:utm_term,
                },
                success: function (data) {
                    if ("error" in data) {
                        console.log(data)
                        document.getElementById('login').parentElement.classList.add('error__email');
                        document.getElementById('login').classList.add('error__email');
                        document.getElementById('login').addEventListener("click", function () {
                            document.getElementById('login').parentElement.classList.remove('error__email');
                            document.getElementById('login').classList.remove('error__email');
                        });
                        $('.popup').fadeOut();
                        $('#btnSubmit').prop('disabled', false);
                        document.getElementById('btnSubmit').style.cssText  = 'background-color: #F4F9FF';
                        document.getElementById('btnSubmit').value  = 'Отправить';

                    } else if ("error_number" in data) {
                        console.log(data);
                        document.getElementById('telnumber').parentElement.classList.add('error');
                        document.getElementById('telnumber').classList.add('error');
                        document.getElementById('telnumber').addEventListener("click", function () {
                            document.getElementById('telnumber').parentElement.classList.remove('error');
                            document.getElementById('telnumber').classList.remove('error');
                        });
                        $('.popup').fadeOut();
                        $('#btnSubmit').prop('disabled', false);
                        document.getElementById('btnSubmit').style.cssText  = 'background-color: #F4F9FF';
                        document.getElementById('btnSubmit').value  = 'Отправить';
                    } else {
                        $('#preloader').detach();
                        document.getElementById('title1').style.display = "block";
                        document.getElementById('title2').style.display = "block";
                        document.getElementById('popupButton').style.display = "block";
                        document.getElementById('registrationIcon').style.display = "block";
                        document.getElementById('successRegistrationText').style.display = "block";
                        $('.popup').fadeIn();
                        $(this).find('input').val('');
                        $('#form').trigger('reset');
                        document.querySelector('#popupTitle').removeChild(popupTitle);
                    }
                    $(document).ready(function () {
                        $('#btnSubmit').prop('disabled', false);
                        document.getElementById('btnSubmit').style.cssText  = 'background-color: #F4F9FF';
                        document.getElementById('btnSubmit').value  = 'Отправить';
                    })
                },
                error: function (error) {
                    console.log(error)
                    $('.popup').fadeOut();
                    $('#btnSubmit').prop('disabled', false);
                    document.getElementById('btnSubmit').style.cssText  = 'background-color: #F4F9FF';
                    document.getElementById('btnSubmit').value  = 'Отправить';
                    if (422 === error.status) {
                        for (let formReqElement of formReq) {
                            if (formReqElement.getAttribute("type") === "checkbox" && $("input[name=agreement]").prop('checked') === false) {
                                $('.checkbox').addClass('error_checkbox');
                                $('.checkbox').on('click', function (e) {
                                    $('.checkbox').removeClass('error_checkbox');
                                });
                            } else {
                                if (formReqElement.value === '') {
                                    formReqElement.parentElement.classList.add('error');
                                    formReqElement.classList.add('error');
                                }
                            }

                            if (document.getElementById('selectorsInput').value === '') {
                                document.getElementById('form-of-interaction').classList.add('error');
                                document.getElementById('labelsSelector').classList.add('error_selector');
                            }

                            formReqElement.addEventListener('click', function (e) {
                                formReqElement.parentElement.classList.remove('error');
                                formReqElement.classList.remove('error');
                            });
                            document.getElementById('form-of-interaction').addEventListener("click", function (e) {
                                document.getElementById('form-of-interaction').classList.remove('error');
                                document.getElementById('labelsSelector').classList.remove('error_selector');
                            });

                            if(error.responseText.includes("login")){
                                document.getElementById('login').parentElement.classList.add('error__email');
                                document.getElementById('login').classList.add('error__email');
                            }

                        }
                        console.log("Не заполнены все поля")
                        document.getElementById('login').addEventListener("click", function () {
                            document.getElementById('login').parentElement.classList.remove('error__email');
                            document.getElementById('login').classList.remove('error__email');
                        });
                    }
                    $(document).ready(function () {
                        $('#btnSubmit').prop('disabled', false);
                        document.getElementById('btnSubmit').style.cssText  = 'background-color: #F4F9FF';
                        document.getElementById('btnSubmit').value  = 'Отправить';
                    })
                }
            });
    }




// Закрыть попап
$('.popup__close').click(function () { // по клику на кнопку
    $('.popup').fadeOut();
});

$('.popup').on('click', function (e) { // по клику вне попапа
    if (!e.target.closest('.popup__content')) {
        e.target.closest('.popup');
        $('.popup').fadeOut();
    }
});



document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        $('.popup').fadeOut();
    }
});

//Полифилы
(function () {
    //проверяем поддержку
    if (!Element.prototype.closest) {
        Element.prototype.closest = function (css) {
            var node = this;
            while (node) {
                if (node.matches(css)) return node;
                else node = node.parentElement;
            }
            return null;
        };
    }
})();

(function () {
        if (!Element.prototype.matches) {
            Element.prototype.matches = Element.prototype.matchesSelector ||
                Element.prototype.webkitMatchesSelector ||
                Element.prototype.mozMatchesSelector ||
                Element.prototype.msMatchesSelector;
        }
    }
)();

