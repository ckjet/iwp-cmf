{% extends "error.volt" %}
{% block content %}
<div class="jumbotron">
    <h1>Доступ ограничен</h1>
    <p>У Вас нет доступа к этой странице.</p>
    <p><a href="{{ gen_url('index') }}" class="btn btn-primary">Главная</a></p>
</div>
{%  endblock %}