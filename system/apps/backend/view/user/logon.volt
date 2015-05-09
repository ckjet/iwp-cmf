{% extends "index.volt" %}
{% block content %}
    <div class="wrapper full-page-wrapper page-login text-center">
        <div class="inner-page">
            <div class="login-box center-block">
                <div class="progress progress-striped active hidden">
                    <div data-transitiongoal="60" class="progress-bar progress-bar-info" style="width: 100%;" aria-valuenow="100">Выполняется авторизация</div>
                </div>
                <div class="alert alert-danger alert-dismissable hidden" style="padding: 8px;">
                    <strong>Ошибка!</strong> <span class="login-error"></span>
                </div>
                <div class="alert alert-success hidden" style="padding: 8px;">
                    <strong>Поздравляем!</strong> <span class="login-success"></span>
                </div>
                <form class="form-horizontal" role="form">
                    <p class="title">Авторизация</p>
                    <div class="form-group">
                        <label for="login" class="control-label sr-only">Логин</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" placeholder="Ваш логин" id="login" class="form-control" name="login" />
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            </div>
                        </div>
                    </div>
                    <label for="password" class="control-label sr-only">Пароль</label>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="password" placeholder="Пароль" id="password" class="form-control" name="password" />
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-custom-primary btn-lg btn-block btn-login"><i class="fa fa-arrow-circle-o-right"></i> Войти</button>
                </form>
            </div>
        </div>
        <div class="push-sticky-footer"></div>
    </div>
{% endblock %}
{% block extraJS %}
    {{ javascript_include('js/backend/logon.js') }}
{% endblock %}