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
                        {% block breadcrumb %}{% endblock %}

                        <!-- main -->
                        <div class="content">
                            <div class="main-content">
                                {% block child_content %}{% endblock %}
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