<!-- left sidebar -->
<div class="col-md-2 left-sidebar">

    <!-- main-nav -->
    <nav class="main-nav">

        <ul class="main-menu">
            <li{% if iwp_controller == 'index' %} class="active"{% endif %}>
                <a href="{{ gen_url('index') }}">
                    <i class="fa fa-bars fa-fw"></i>
                    <span class="text">Сводная</span>
                </a>
            </li>
            <li{% if iwp_controller == 'user' %} class="active"{% endif %}>
                <a href="#" class="js-sub-menu-toggle">
                    <i class="fa fa-key fa-fw"></i>
                    <span class="text">Доступ</span>
                    <i class="toggle-icon fa fa-angle-left"></i>
                </a>
                <ul class="sub-menu"{% if iwp_controller == 'user' %} style="display: block"{% endif %}>
                    <li{% if iwp_controller == 'user' and iwp_action == 'edit' %} class="active"{% endif %}>
                        <a href="{{ gen_url('user', 'edit') }}">
                            <i class="fa fa-edit fa-fw"></i>
                            <span class="text">Новый доступ</span>
                        </a>
                    </li>
                    <li{% if iwp_controller == 'user' and iwp_action == 'index' %} class="active"{% endif %}>
                        <a href="{{ gen_url('user') }}">
                            <i class="fa fa-folder fa-fw"></i>
                            <span class="text">Список доступов</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /main-nav -->

    <div class="sidebar-minified js-toggle-minified">
        <i class="fa fa-angle-left"></i>
    </div>
    {% if iwp_user.level == 10 %}
        <!-- sidebar content -->
        <div class="sidebar-content">
            <h5 class="label label-default"><i class="fa fa-info-circle"></i> Информация о сервере</h5>
            <ul class="list-unstyled list-info-sidebar bottom-30px">
                <li class="data-row">
                    <div class="data-name">Жесткий диск</div>
                    <div class="data-value">
                        {{ iwp_server['disk']['used'] }} / {{ iwp_server['disk']['total'] }}
                        <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ iwp_server['disk']['percent'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ iwp_server['disk']['percent'] }}%">
                                <span class="sr-only">{{ iwp_server['disk']['percent'] }}%</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="data-row">
                    <span class="data-name">Базы данных</span>
                    <span class="data-value">{{ iwp_server['dbSize'] }}</span>
                </li>
                <li class="data-row">
                    <span class="data-name">Volt кэш</span>
                    <span class="data-value">
                        <span class="pull-left">{{ iwp_server['cacheSize'] }}</span>
                        <span class="pull-right"><a href="{{ gen_url('system', 'clearCache') }}">Очистить</a></span>
                    </span>
                </li>
                <li class="data-row">
                    <span class="data-name">Операциноная система</span>
                    <span class="data-value">{{ iwp_server['OSName'] }}</span>
                </li>
                <li class="data-row">
                    <span class="data-name">Версия Apache</span>
                    <span class="data-value">{{ iwp_server['apacheVersion'] }}</span>
                </li>
                <li class="data-row">
                    <span class="data-name">Версия PHP</span>
                    <span class="data-value">{{ iwp_server['phpVersion'] }}</span>
                </li>
                <li class="data-row">
                    <span class="data-name">Версия MySQL</span>
                    <span class="data-value">{{ iwp_server['sqlVersion'] }}</span>
                </li>
                <li class="data-row">
                    <span class="data-name">Архитектура</span>
                    <span class="data-value">{{ iwp_server['arch'] }}</span>
                </li>
            </ul>
        </div>
        <!-- end sidebar content -->
    {% endif %}
</div>
<!-- end left sidebar -->