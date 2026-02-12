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

                            <li class="nav-header">مراسلة الخزينة العمومية </li>

                            <li
                                class="nav-item has-treeview {{ request()->is('manager/tresor/*') ? 'menu-open' : '' }} ">
                                <a href="#"
                                    class="nav-link {{ request()->is('manager/tresor/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        ملء بيانات الموظفين
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href={{ route('admin-tresor-list') }} class="nav-link ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p> قائمة الموظفين</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href={{ route('admin-tresor-stat') }} class="nav-link ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p> مراقبة العملية</p>
                                        </a>
                                    </li>

                                </ul>



                            </li>
                            @if (auth()->check() && auth()->user()->hasRole('manager'))
                                <li class="nav-header">الحزم</li>
                                <li
                                    class="nav-item has-treeview {{ request()->is('admin/megration/*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ request()->is('admin/megration/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            تسير الحزم
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('admin-megration-salary-index') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسير حزم الاجر الشهري</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-megration-rendement-index') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسير حزم المردودية </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-megration-rappel-index') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسير حزم المخلفات </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-megration-rappel-prime-index') }}
                                                class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسير حزم مخلفات المردودية </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-megration-tamadres-index') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسير حزم التمدرس </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-megration-employees-datas-index') }}
                                                class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تحديث بيانات الموظفين</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>




                                {{--  </ul>
                       
                              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                              data-accordion="false"> --}}

                                <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->

                                <li class="nav-header"> الحجز</li>
                                <li
                                    class="nav-item has-treeview {{ request()->is('manager/rendements/*') ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ request()->is('manager/rendements/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            تسير الحجز
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('admin-rendements') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> تسير حجز المردودية</p>
                                            </a>
                                        </li>
                                        {{-- <li class="nav-item">
                                        <a href={{ route('admin-rendement-create') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>إضافة شهر مردودية </p>
                                        </a>
                                    </li> --}}
                                        <li class="nav-item">
                                            <a href={{ route('admin-rappels') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> تسيير حجز المخلفات</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-tamadres') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسيير حجز التمدرس</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-absence') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسيير حجز الغياب</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('dir-admin-absence') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسيير حجز الغياب مدراء</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif



                            <li class="nav-header">الكشوف</li>

                            <li
                                class="nav-item has-treeview {{ request()->is('admin/salary/*') ? 'menu-open' : '' }} ">
                                <a href="#"
                                    class="nav-link {{ request()->is('admin/salary/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        كشف الراتب
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href={{ route('admin-salary-single-employees') }} class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>كشف الراتب الفردي</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <li
                                class="nav-item has-treeview {{ request()->is('admin/rendement/*') ? 'menu-open' : '' }} ">
                                <a href="#"
                                    class="nav-link {{ request()->is('admin/rendement/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        كشف المردودية
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href={{ route('admin-rendement-single-employees') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>كشف المردودية الفردي</p>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href={{ route('admin-rappel-rendement-single-employees') }}
                                            class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>كشف مخلف المردودية </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li
                                class="nav-item has-treeview {{ request()->is('admin/rappel/*') ? 'menu-open' : '' }} ">
                                <a href="#"
                                    class="nav-link {{ request()->is('admin/rappel/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        كشف المخلفات
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href={{ route('admin-rappel-single-employees') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>كشف المخلفات الفردي</p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <li
                                class="nav-item has-treeview {{ request()->is('admin/tamadres/*') ? 'menu-open' : '' }} ">
                                <a href="#"
                                    class="nav-link {{ request()->is('admin/tamadres/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        كشف التمدرس
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href={{ route('admin-tamadres-single-employees') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>كشف منحة التمدرس</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li
                                class="nav-item has-treeview {{ request()->is('admin/deduction/*') ? 'menu-open' : '' }} ">
                                <a href="#"
                                    class="nav-link {{ request()->is('admin/deduction/*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-dashboard"></i>
                                    <p>
                                        كشف الإقتطاعات
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href={{ route('admin-deduction-single-employees') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p> كشف الإقتطاعات الفردي </p>
                                        </a>
                                    </li>
                                  {{--   <li class="nav-item">
                                        <a href={{ route('admin-deduction-single-employees') }} class="nav-link  ">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p> كشف الإقتطاعات الجماعي </p>
                                        </a>
                                    </li> --}}

                                </ul>
                            </li>

                            @if (auth()->check() && auth()->user()->hasRole('manager'))
                                <li class="nav-header">العمل والأجر</li>
                                <li
                                    class="nav-item has-treeview {{ request()->is('admin/ats/*') ? 'menu-open' : '' }} ">
                                    <a href="#"
                                        class="nav-link {{ request()->is('admin/ats/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            كشف العمل و الأجر
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('admin-ats-single-employees') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف العمل والأجر الفردي</p>
                                            </a>
                                        </li>


                                    </ul>
                                </li>

                                <li class="nav-header">الحركة</li>
                                <li class="nav-item text-center mb-2">
                                    <form action="{{ route('admin-mouvement-period-toggle') }}" method="POST"
                                        onsubmit="return confirmAction(event)">
                                        @csrf
                                        {{-- احذف @method('PUT') --}}
                                        @if ($period_mouv == 1)
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-lock"></i> غلق الحركة
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-unlock"></i> فتح الحركة
                                            </button>
                                        @endif
                                    </form>
                                </li>

                                <li
                                    class="nav-item has-treeview {{ request()->is('admin/mouvement/*') ? 'menu-open' : '' }} ">
                                    <a href="#"
                                        class="nav-link {{ request()->is('admin/mouvement/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            إدارة الحركة
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('admin-mouvement-single-out-employees') }}
                                                class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                @if (isset($outMouvcountTotal) && $outMouvcountTotal > 0)
                                                    <p>
                                                        <span class="text">معالجة الطلبات الواردة</span>
                                                        <span
                                                            class="badge badge-danger mouv-title ">{{ $outMouvcountTotal }}</span>
                                                    </p>
                                                @else
                                                    <p>
                                                        <span class="text">معالجة الطلبات الواردة</span>
                                                        <span class="badge badge-danger mouv-title ">0</span>
                                                    </p>
                                                @endif
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-mouvement-single-print-list') }}
                                                class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>طباعة قوائم الحركة</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-mouvement-employees-list-release') }}
                                                class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> قائمة الموظفين المحررين</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="nav-header"> الغياب</li>
                                <li class="nav-item has-treeview {{ request()->is('absence/*') ? 'menu-open' : '' }}">
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
                                            <a href={{ route('admin-absence-single-employees') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف الغياب الفردي</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-header">لوحة التحكم</li>
                                <li class="nav-item has-treeview menu-open">
                                <li class="nav-item">
                                    <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            الإعدادت
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        {{--   <li class="nav-item">
                                        <a href="./index.html" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>تسيير المستخدمين</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="./index.html" class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>تسيير المؤسسات</p>
                                        </a>
                                    </li> --}}
                                        <li class="nav-item">
                                            <a href={{ route('admin-settings-notes') }} class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسيير الإعلانات</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('admin-settings-employee-list') }} class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسيير الموظفين</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin-settings-fonctions-index') }}" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسيير الوظائف</p>
                                            </a>
                                        </li>
                                        {{--  <li class="nav-item">
                                        <a href={{ route('admin-settings-grant-infos-list') }} class="nav-link">
                                            <i class="fa fa-circle-o nav-icon"></i>
                                            <p>تسيير المنح والإقتطاعات</p>
                                        </a>
                                    </li> --}}
                                    </ul>
                                </li>

                                {{--  @if (Auth::user()->google2fa_enabled && Auth::user()->google2fa_secret)
                                <li class="nav-item">
                                    <a href="#" class="nav-link"
                                        onclick="event.preventDefault(); document.getElementById('disable-2fa-form').submit();">
                                        <i class="fa fa-unlock-alt"></i>
                                        <p>تعطيل المصادقة الثنائية</p>
                                    </a>
                                    <form id="disable-2fa-form" action="{{ route('google2fa.disable') }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                              @else
                                <li class="nav-item">
                                    <a href="{{ route('google2fa.setup') }}" class="nav-link">
                                        <i class="fa fa-shield"></i>
                                        <p>تفعيل المصادقة الثنائية</p>
                                    </a>
                                </li>
                              @endif 
                                --}}
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> تسجيل الخروج
                                </a>
                                <form id="logout-form" action="{{ route('admin-logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
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
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
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

    <script>
        function confirmAction(event) {
            const button = event.target.querySelector('button');
            const action = button.classList.contains('btn-danger') ? 'غلق' : 'فتح';
            const confirmed = confirm(`هل أنت متأكد من ${action} الحركة؟`);
            if (!confirmed) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
