<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Кабинет партнера - @yield('title')</title>

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
    <link type="image/x-icon" rel="shortcut icon" href="/favicon.ico">
    <link type="image/png" sizes="16x16" rel="icon" href="/favicon-16x16.png">
    <link type="image/png" sizes="16x16" rel="icon" href="/favicon-32x32.png">
    <link type="image/png" sizes="192x192" rel="icon" href="/android-chrome-192x192.png">
    <link type="image/png" sizes="512x512" rel="icon" href="/android-chrome-512x512.png">
    <link sizes="180x180" rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/icons.json" crossorigin="use-credentials">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<style>
    @media (max-width: 426px) {
        .navbar {
            height: 60px;
        }
        .myfont{
            font-size: 13px;
        }
        .mynav{
            padding-top: 0;
        }
    }
</style>
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('profile.index') }}" class="nav-link">Профиль</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        @if(isset(Auth::user()->region_id))
        <ul class="navbar-nav ml-auto">
            <li class="nav-link mynav">
                <div style="display: flex;">
                    <div><i class="fas fa-map-marker-alt"></i></div>
                    <div class="ml-2"><a class="nav-link m-0 p-0 myfont" href="{{ route('profile.index') }}#regions_selector">{{Auth::user()->region->title}}</a></div>
                </div>
            </li>
        </ul>
        @endif
    </nav>


    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('homePartner') }}" class="brand-link">
            <img src="/admin/dist/img/logo-160x160.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Metr.club</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img style="width:34px;height:34px;object-fit: cover;" src="{{Auth::user()->profile_photo_src ? Auth::user()->profile_photo_src : '/profile-photos/no-photo.png'}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('profile.index') }}" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="{{ route('homePartner') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Главная
                            </p>
                        </a>
                    </li>
                    @if(auth()->user()->hasRole('supervisor'))
                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Агенты
                                </p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Заявки на ипотеку
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->hasRole('supervisor'))
                                <li class="nav-item">
                                    <a href="{{route('supervisor_demands.index')}}" class="nav-link">
                                        <p>Все заявки</p>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('demands.index') }}" class="nav-link">
                                        <p>Все заявки</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('demands.create') }}" class="nav-link">
                                    <p>Создать заявку</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Заявки на потребы
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Auth::user()->hasRole('supervisor'))
                                <li class="nav-item">
                                    <a href="{{ route('supervisor_credits.index') }}" class="nav-link">
                                        <p>Все заявки</p>
                                    </a>
                                </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ route('credits.index') }}" class="nav-link">
                                    <p>Все заявки</p>
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('credits.create') }}" class="nav-link">
                                    <p>Создать заявку</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @role('admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Страховые полисы
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('insurances.index') }}" class="nav-link">
                                    <p>Все полисы</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('insurances.create') }}" class="nav-link">
                                    <p>Новый полис</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Оценочный альбом
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('evaluations.index') }}" class="nav-link">
                                    <p>Мои оценки</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('evaluations.create') }}" class="nav-link">
                                    <p>Отправить заявку</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @can('picasso')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>
                                Пикассо
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('picasso.index') }}" class="nav-link">
                                    <p>Мои зарисовки</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('picasso.create') }}" class="nav-link">
                                    <p>Отправить зарисовку</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-coins"></i>
                            <p>
                                Комиссия и контакты
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('reward')}}" target="_blank" class="nav-link">
                                    <p>Ипотека</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/insurance" target="_blank" class="nav-link">
                                    <p>Страхование</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/reward_credits" target="_blank" class="nav-link">
                                    <p>Потреб. кредиты</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/knowledge_metr" target="_blank" class="nav-link">
                            <i class="nav-icon fas fa-archive"></i>
                            <p>
                                Метр знаний
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/partner/page/support" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-medical"></i>
                            <p>
                                Поддержка
                            </p>
                        </a>
                    </li>
                    @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('homeAdmin') }}" class="nav-link">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>
                                    В админку
                                </p>
                            </a>
                        </li>
                    @endrole
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
            <div class="form-group">
                <!--div class="form-group clearfix"><a href="">Техподдержка</a></div>
                <div class="form-group clearfix"><a href=""></a></div-->
            </div>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
{{--        <a class="nav-link hidden-lg-up" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>--}}
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
@yield('specialscripts')
</body>
</html>
