$(function () {
    $('form[role="form"]').submit(function (e) {
        e.preventDefault();
        $('.progress.active').not('hidden').addClass('hidden');
        $.ajax({
            url: '/user/logon.adm',
            type: 'POST',
            data: {
                'login': $('form[role="form"] input[name="login"]').val(),
                'password': $('form[role="form"] input[name="password"]').val()
            },
            success: function (data) {
                $('.progress.active').not('.hidden').addClass('hidden');
                $('.alert.alert-danger').not('.hidden').addClass('hidden');
                $('.alert.alert-success').not('.hidden').addClass('hidden');
                if (data.success) {
                    $('.alert.alert-success.hidden').removeClass('hidden');
                    $('.alert.alert-success .login-success').text('Авторизация прошла успешно');
                    document.location.href = data.url;
                } else {
                    $('.alert.alert-success').not('.hidden').addClass('hidden');
                    $('.alert.alert-danger.hidden').removeClass('hidden');
                    $('.alert.alert-danger .login-error').text(data.error);
                }
            }
        });
    });
});