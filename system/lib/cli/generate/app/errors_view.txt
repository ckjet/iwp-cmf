<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('css/backend/bootstrap.min.css') }}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        {% block content %}
        {% endblock %}
    </body>
</html>