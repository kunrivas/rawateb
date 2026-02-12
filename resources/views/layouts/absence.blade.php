<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- yield to instance the title and change it in child view  --}}
    <title>@yield('title', 'تطبيق الرواتب')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- cairo font link online --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin3/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin3/dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin3/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/admin3/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/admin3/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/admin3/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin3/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/admin3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="/admin3/dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="/admin3/dist/css/custom-style.css">
    @yield('css')
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">الرئيسية</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">إتصل بنا</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="ابحث هنا"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav mr-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-comments-o"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="/admin3/dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 ml-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        علي عوادي
                                        <span class="float-left text-sm text-danger"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">السلام عليكم</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> قبل 4 ساعات</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="/admin3/dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle ml-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        أنور فايزي
                                        <span class="float-left text-sm text-muted"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">وعليكم السلام</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> قبل 4 ساعات</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="/admin3/dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle ml-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        مروة عسيري
                                        <span class="float-left text-sm text-warning"><i
                                                class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">ما الجديد </p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>قبل 4 ساعات</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">مشاهدة كل المحادثات</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                        <span class="dropdown-item dropdown-header">15 تنبيه</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-envelope ml-2"></i> 4 رسائل جديدة
                            <span class="float-left text-muted text-sm">3 دقیقه</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-users ml-2"></i> 8 طلبات صداقة
                            <span class="float-left text-muted text-sm">12 ساعة</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fa fa-file ml-2"></i> 3 تقارير جديدة
                            <span class="float-left text-muted text-sm">2 روز</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">مشاهدة كل التنبيهات</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                            class="fa fa-th-large"></i></a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">

                <div class="brand-text font-weight-light text-center">منصة الرواتب</div>
            </a>

            <!-- Sidebar -->
            <div class="sidebar" style="direction: ltr">
                <div style="direction: rtl">
                    <!-- Sidebar user panel (optional) -->
                    {{--      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="/admin3/dist/img/user1-128x128.jpg" class="img-circle elevation-2"
                                alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">محمدرضا عطوان</a>
                        </div>
                    </div> --}}

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->





                            {{--  </ul>

                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false"> --}}

                            <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->

                            <li class="nav-header"> الغياب</li>
                            <li
                                class="nav-item has-treeview {{ request()->is('absence/*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is('absence/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        تسيير الغيابات
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href={{ route('absence-reservation') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>تسيير حجز الغياب</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href={{ route('absence-single-employees') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>كشف الغياب الفردي</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @yield('content-title')
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-left">
                                @yield('breadcrumb')
                            </ol>
                        </div><!-- /.col -->

                    </div><!-- /.row -->

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('contents')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>جميع الحقوق محفوظة &copy; 2023 <a href="https://deeloued.education.dz/">مديرية التربية لولاية
                    الوادي</a>.</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>


    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/admin3/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/admin3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="/admin3/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="/admin3/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="/admin3/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/admin3/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/admin3/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="/admin3/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/admin3/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/admin3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="/admin3/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="/admin3/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin3/dist/js/adminlte.js"></script>
    @yield('js')

</body>

</html>
