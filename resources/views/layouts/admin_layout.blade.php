<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Админ-панель - @yield('title')</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/css/emoji/emoji.css">
    <link rel="stylesheet" href="/css/bank/style.css">


    <link type="image/x-icon" rel="shortcut icon" href="/admin/favicon/favicon.ico">
    <link type="image/png" sizes="16x16" rel="icon" href="/admin/favicon/favicon-16x16.png">
    <link type="image/png" sizes="16x16" rel="icon" href="/admin/favicon/favicon-32x32.png">
    <link type="image/png" sizes="192x192" rel="icon" href="/admin/favicon/android-chrome-192x192.png">
    <link type="image/png" sizes="512x512" rel="icon" href="/admin/favicon/android-chrome-512x512.png">
    <link sizes="180x180" rel="apple-touch-icon" href="/admin/favicon/apple-touch-icon.png">
    <link rel="manifest" href="/admin/favicon/icons.json" crossorigin="use-credentials">
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('homeAdmin') }}" class="nav-link">Главная</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Профиль</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            @if(isset(Auth::user()->region_id))
            <li class="nav-link">
                <div style="display: flex;">
                    <div><i class="fas fa-map-marker-alt"></i></div>
                    <div class="ml-2">{{Auth::user()->region->title}}</div>

                </div>
            </li>
            @endif
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Не работает =)" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="/admin/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="/admin/dist/img/user4-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="/admin/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('homeAdmin') }}" class="brand-link">
            <img src="/admin/dist/img/logo-160x160.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Metr.club</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="{{ route('homeAdmin') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Главная
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Заявки
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                        <a href="{{ route('demand.index') }}" class="nav-link">
                            <p>
                                Все заявки (ипотека)
                            </p>
                        </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('credit.index') }}" class="nav-link">
                                    <p>
                                        Все заявки (потребы)
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                Банки
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('bank.index') }}" class="nav-link">
                                    <p>Все банки</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('bank.create') }}" class="nav-link">
                                    <p>Добавить банк</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-people-arrows"></i>
                            <p>
                                Лиды
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('lead.index') }}" class="nav-link">
                                    <p>Все лиды</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('lead.create') }}" class="nav-link">
                                    <p>Добавить лид</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reward.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-ruble-sign"></i>
                            <p>
                                Таблица КВ
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('insurance.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-house-damage"></i>
                            <p>
                                Страховые
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reward_credits.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-house-damage"></i>
                            <p>
                                Кредиты
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Агенты
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('news.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                Новости
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pages.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p>
                                Страницы
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('landings.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p>
                                Лендинги
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p>
                                Настройки
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('settings.index') }}" class="nav-link">
                                    <p>Основные настройки</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('regions.index') }}" class="nav-link">
                                    <p>Регионы</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('credit_programs.index') }}" class="nav-link">
                                    <p>Пр-мы кредитования</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('demands_templates.index') }}" class="nav-link">
                                    <p>Шаблоны писем</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('setting_files.index') }}" class="nav-link">
                                    <p>Файлы заявок</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('homePartner') }}" class="nav-link">
                            <i class="nav-icon fas fa-hippo"></i>
                            <p>
                                Притвориться партнёром
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin_panel/log-viewer" class="nav-link" target="_blank">
                            <i class="nav-icon fas fa-mail-bulk"></i>
                            <p>
                                Логи
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Выход
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!--a class="nav-link hidden-lg-up" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a-->
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<!-- jQuery -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/admin/plugins/moment/moment.min.js"></script>
<script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- InputMask -->
<script src="/admin/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/adminlte.js"></script>
<script src="/admin/admin.js"></script>
<script src="/admin/plugins/select2/js/select2.min.js"></script>
<script src="/admin/plugins/select2/js/i18n/ru.js"></script>
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@yield('specialscripts')
</body>
</html>
