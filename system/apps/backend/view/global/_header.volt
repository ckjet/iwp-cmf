<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <!-- logo -->
            <div class="col-md-2 logo">
                <h4>
                    <a href="{{ gen_url('index') }}">mydomain.com</a>
                </h4>
                <h1 class="sr-only">iwpsystem.com Panel</h1>
            </div>
            <!-- end logo -->
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <!-- search box -->
                        <div id="tour-searchbox" class="input-group searchbox">
                            <input type="search" class="form-control" placeholder="Поиск по контенту...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <!-- end search box -->
                    </div>
                    <div class="col-md-9">
                        <div class="top-bar-right">
                            <!-- responsive menu bar icon -->
                            <a href="#" class="hidden-md hidden-lg main-nav-toggle"><i class="fa fa-bars"></i></a>
                            <!-- end responsive menu bar icon -->
                            <!-- logged user and the menu -->
                            <div class="logged-user">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                        <span class="name">{{ iwp_user.login }}</span>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-cog"></i>
                                                <span class="text">Настройки</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ gen_url('user', 'logout') }}">
                                                <i class="fa fa-power-off"></i>
                                                <span class="text">Выход</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end logged user and the menu -->
                        </div>
                        <!-- /top-bar-right -->
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /top -->