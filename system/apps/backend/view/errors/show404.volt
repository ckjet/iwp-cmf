{% extends "errors.volt" %}
{% block content %}
<div class="jumbotron">
    <h1>Страница не найдена</h1>
    <p>Вы попали на страницу, которой не существует.</p>
    <p><a href="{{ gen_url('index') }}" class="btn btn-primary">Главная</a></p>
</div>
{% endblock %}