{% extends "index.volt" %}
{% block content %}
    <!-- WRAPPER -->
    <div class="wrapper">
        {{ partial('global/_header') }}
        <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
        <div class="bottom">
            <div class="container">
                <div class="row">
                    {{ partial('global/_menu') }}
                    <!-- content-wrapper -->
                    <div class="col-md-10 content-wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="breadcrumb">
                                    <li>
                                        <i class="fa fa-key"></i>
                                        Доступ
                                    </li>
                                    <li class="active">Список доступов</li>
                                </ul>
                            </div>
                        </div>
                        <!-- main -->
                        <div class="content">
                            <div class="main-content">
                                <div class="row">
                                    <table class="table table-bordered table-striped table-dark-header">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Логин</th>
                                                <th>Доступ</th>
                                                <th>Контакты</th>
                                                <th style="width: 300px;">Управление</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {% if pager.total_items %}
                                                {% for item in pager.items %}
                                                <tr>
                                                    <td>{{ item.id }}</td>
                                                    <td>
                                                        {{ item.login }}
                                                    </td>
                                                    <td>
                                                        {% if item.level == 10 %}
                                                            Администратор
                                                        {% else %}
                                                            Пользователь
                                                        {% endif %}
                                                    </td>
                                                    <td>
                                                        <div>{{ item.email }}</div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ gen_url('user', 'edit') }}?_id={{ item.id }}" class="btn btn-primary">
                                                            <i class="fa fa-edit"></i> Изменить
                                                        </a>
                                                        <a href="{{ gen_url('user', 'rm') }}?_id={{ item.id }}" class="btn btn-danger pull-right" onclick="return confirm('Вы действительно хотите удалить этот доступ?');">
                                                            <i class="fa fa-trash-o"></i> Удалить
                                                        </a>
                                                    </td>
                                                </tr>
                                                {% endfor %}
                                            {% else %}
                                                <tr>
                                                    <td colspan="5">Записей не найдено</td>
                                                </tr>
                                            {% endif %}
                                        </tbody>
                                    </table>
                                    {{ partial('global/_pager') }}
                                </div>
                            </div>
                            <!-- /main-content -->
                        </div>
                        <!-- /main -->
                    </div>
                    <!-- /content-wrapper -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
        <div class="push-sticky-footer"></div>
    </div>
    <!-- /wrapper -->
    <div class="modal preloader modal-zi" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Загрузка...</h3>
                    <div class="progress progress-striped active">
                        <div class="progress-bar" style="width: 100%;" data-transition="100" areavaluenow="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{% endblock %}