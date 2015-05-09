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
                        <div class="col-md-10">
                            <ul class="breadcrumb">
                                <li><i class="fa fa-bars"></i>
                                    <a href="{{ gen_url('index') }}">Сводная</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- main -->
                    <div class="content">
                        <div class="main-content">
                            <div class="col-md-10">
                                <div class="alert alert-info alert-dismissable">
                                    Сводная в разработке.
                                </div>
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