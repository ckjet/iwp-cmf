{% extends "errors.volt" %}
{% block content %}
    <div class="jumbotron">
        {% if exception['debug'] %}
            <p>Отладочная информация:</p>
            <p>
                Сообщение: <small>{{ exception['message'] }}</small><br/>
                Код: <small>{{ exception['code'] }}</small><br/>
                Файл: <small>{{ exception['file'] }}:{{ exception['line'] }}</small><br/>
                Трассировка: 
            <pre>
{{ exception['trace'] }}
            </pre>
        </p>
    {% else %}
        <h1>Внутрення ошибка</h1>
        <p>Что-то сломалось. Если ошибка повторится свяжитесь с нами.</p>
    {% endif %}
    <p><a href="{{ gen_url('index') }}" class="btn btn-primary">Главная</a></p>
</div>
{% endblock %}