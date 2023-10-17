$(document).ready(function () {
    $('#random').click(function () {
        var randPassword = Array(14).fill("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!^&*()-_=+?").map(function (x) {
            return x[Math.floor(Math.random() * x.length)]
        }).join('');
        $('#password').val(randPassword);
    })
});

