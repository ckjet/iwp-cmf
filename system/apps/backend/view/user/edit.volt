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
                                    <li class="active">{{ bc_title }}</li>
                                </ul>
                            </div>
                        </div>
                        <form action="{{ gen_url('user', 'save') }}" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="span1">
                                        <strong>Логин пользователя</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <input name="login" value="{{ item.login }}" type="text" placeholder="Ведите название файла" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr class="inner-separator">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="span1">
                                        <strong>Пароль</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <input name="password" type="password" placeholder="Не заполнять, если не хотите изменять" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr class="inner-separator">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="span1">
                                        <strong>E-mail</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <input name="email" value="{{ item.email }}" type="text" placeholder="Ведите почтовый адрес" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr class="inner-separator">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="span1">
                                        <strong>Доступ</strong>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="multiselect" name="level">
                                            <option value="1"{% if item.level == 1 %} selected="selected"{% endif %}>Пользователь</option>
                                            <option value="10"{% if item.level == 10 %} selected="selected"{% endif %}>Администратор</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr class="inner-separator">
                            <div class="row">
                                <input type="hidden" name="item_id" value="{{ item.id }}" />
                                <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i> Сохранить</button>
                            </div>
                        </form>

                        <!-- main -->
                        <div class="content">
                            <div class="main-content">

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
{% endblock %}
{% block extraJS %}
    {{ javascript_include('js/backend/plugins/select2/select2.min.js') }}
    {{ javascript_include('js/backend/user/edit.js') }}
{% endblock %}