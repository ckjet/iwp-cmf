<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('css/backend/bootstrap.min.css') }}
        {{ stylesheet_link('css/backend/font-awesome.min.css') }}
        {{ stylesheet_link('css/backend/main.css') }}
        {% block extraCSS %}{% endblock %}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        {% block content %}
        {% endblock %}
        {{ partial('global/_footer') }}
        {{ javascript_include('js/backend/jquery/jquery-2.1.0.min.js') }}
        {{ javascript_include('js/backend/bootstrap/bootstrap.js') }}
        {{ javascript_include('js/backend/plugins/modernizr/modernizr.js') }}
        {{ javascript_include('js/backend/nav.js') }}
        {% block extraJS %}{% endblock %}
    </body>
</html>