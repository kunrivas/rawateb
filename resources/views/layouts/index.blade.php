<!DOCTYPE html>
<html>

<<head>
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
    <link rel="stylesheet" href="{{ asset('admin3/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin3/dist/css/adminlte.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin3/plugins/iCheck/flat/blue.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('admin3/plugins/morris/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('admin3/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('admin3/plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin3/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('admin3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ asset('admin3/dist/css/bootstrap-rtl.min.css') }}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ asset('admin3/dist/css/custom-style.css') }}">
    @yield('css')
    <style>
        .news-banner {
            background-color: white;
            color: black;
            font-weight: bold;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 5px;
            margin: 10px 5%;
            border: 1px solid lightgray;
            width: 90%;

        }

        .news-banner .good {
            color: green
        }

        .news-banner .bad {
            color: red
        }

        .news-banner .warning {
            color: orange
        }


        /* Apply the animation to the title */
        .grand-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;

        }



        /* Style for the counter */
        .mouv-in-counter {
            display: inline-block;
            /* Display as a block in the same line */
            background-color: rgb(2, 83, 40);
            /* Background color for the counter */
            color: #fff;
            /* Text color for the counter */
            padding: 5px 10px;
            padding: 5px 10px;
            /* Add padding for spacing */
            border-radius: 5px;
            /* Add rounded corners */
            margin-left: 5px;
            margin-right: 5px;
            margin-left: 5px;
            margin-right: 5px;
            /* Add margin to separate from the text */
            font-size: 18px;
            /* Adjust font size as needed */
            font-weight: bold;
        }

        .mouv-out-counter {
            display: inline-block;
            /* Display as a block in the same line */
            background-color: rgb(199, 13, 13);
            /* Background color for the counter */
            color: #fff;
            /* Text color for the counter */
            padding: 5px 10px;
            padding: 5px 10px;
            /* Add padding for spacing */
            border-radius: 5px;
            /* Add rounded corners */
            margin-left: 5px;
            margin-right: 5px;
            margin-left: 5px;
            margin-right: 5px;
            /* Add margin to separate from the text */
            font-size: 18px;
            /* Adjust font size as needed */
            font-weight: bold;
        }


        /* Title styling */
        .mouv-title {
            font-size: 16px;
            margin-left: 5px;
            margin-right: 5px;
            margin-left: 5px;
            margin-right: 5px;
            /* Adjust font size as needed */
            font-weight: bold;
            /* Make text bold */

            /*  margin: 0;  */
            /* Remove default margin */
        }
    </style>
    </head>

    <body class="hold-transition sidebar-mini">

        <div class="wrapper">

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand  bg-white navbar-light border-bottom ">
                <!-- Left navbar links -->
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                    </li>

                    {{--
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}

                @php
                session(['variableName' => 'variableValue']);
                @endphp

                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('تسجيل الخروج') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                </li>
                --}}
                    <li class="nav-item d-none d-sm-inline-block">
                        <a class="nav-link">الرئيسية</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">
                            إتصل بنا</a>
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
                <h4>{{ session()->get('establishment')->estab_type ?? '' }} :
                    {{ session()->get('establishment')->estab_ar_name ?? '' }}
                </h4>
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
                                {{-- <div class="media">
                                <img src="{{ asset('admin3/dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 ml-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        علي عوادي
                                        <span class="float-left text-sm text-danger"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">السلام عليكم</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> قبل 4 ساعات</p>
                                </div>
                            </div> --}}
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                {{-- <div class="media">
                                <img src="{{ asset('admin3/dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle ml-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        أنور فايزي
                                        <span class="float-left text-sm text-muted"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">وعليكم السلام</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> قبل 4 ساعات</p>
                                </div>
                            </div> --}}
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                {{-- <div class="media">
                                <img src="{{ asset('admin3/dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle ml-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        أنور فايزي
                                        <span class="float-left text-sm text-muted"><i class="fa fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">وعليكم السلام</p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> قبل 4 ساعات</p>
                                </div>
                            </div> --}}
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
            <aside class="main-sidebar sidebar-dark-primary  elevation-4">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link">

                    <div class="brand-text font-weight-light text-center">منصة الرواتب</div>
                </a>

                <!-- Sidebar -->
                <div class="sidebar" style="direction: ltr">
                    <div style="direction: rtl">
                        <!-- Sidebar user panel (optional) -->
                        <!--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('admin3/dist/img/user1-128x128.jpg') }}" class="img-circle elevation-2"
                                alt="User Image">
                        </div>


                        <div class="info">
                            <a href="#" class="d-block"> </a>
                        </div>
                    </div>-->

                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                data-accordion="false">
                                <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                                <li class="nav-header">مراسلة الخزينة العمومية </li>

                                <li class="nav-item has-treeview {{ request()->is('tresor/*') ? 'menu-open' : '' }} ">
                                    <a href="#"
                                        class="nav-link {{ request()->is('tresor/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            ملء بيانات الموظفين
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('tresor-list') }} class="nav-link ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> قائمة الموظفين</p>
                                            </a>
                                        </li>


                                    </ul>
                                </li>


                                <li class="nav-header">تسير نفقات المستخدمين</li>

                                <li class="nav-item has-treeview {{ request()->is('salary/*') ? 'menu-open' : '' }} ">
                                    <a href="#"
                                        class="nav-link {{ request()->is('salary/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            كشف الراتب
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('salary-single-employees') }} class="nav-link ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف الراتب الفردي</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('salary-global-megration-list') }}" class="nav-link ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف الراتب الجماعي</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>


                                <li
                                    class="nav-item has-treeview {{ request()->is('rendement/*') ? 'menu-open' : '' }} ">
                                    <a href="#"
                                        class="nav-link {{ request()->is('rendement/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            كشف المردودية
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('rendement-single-employees') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف المردودية الفردي</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href={{ route('rendement-global-megration-list') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف المردودية الجماعي</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href={{ route('rappel-rendement-single-employees') }}
                                                class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف مخلف المردودية </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('rendements-reservation') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> حجز المردودية </p>
                                            </a>
                                        </li>


                                    </ul>
                                </li>
                                <li class="nav-item has-treeview {{ request()->is('rappel/*') ? 'menu-open' : '' }} ">
                                    <a href="#"
                                        class="nav-link {{ request()->is('rappel/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            كشف المخلفات
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('rappel-single-employees') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف المخلفات الفردي</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href={{ route('rappel-global-list') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف المخلفات الجماعي</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href={{ route('rappel-reservation') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> حجز المخلفات </p>
                                            </a>
                                        </li>


                                    </ul>
                                </li>
                                <li
                                    class="nav-item has-treeview {{ request()->is('tamadres/*') ? 'menu-open' : '' }} ">
                                    <a href="#"
                                        class="nav-link {{ request()->is('tamadres/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            إدارة التمدرس
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('tamadres-single-employees') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف منحة التمدرس</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href={{ route('tamadres-global-megration-list') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف التمدرس الجماعي</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href={{ route('tamadres-reservation') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> حجز منحة التمدرس </p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-header">العمل والأجر</li>
                                <li class="nav-item has-treeview {{ request()->is('ats/*') ? 'menu-open' : '' }} ">
                                    <a href="#" class="nav-link {{ request()->is('ats/*') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            كشف العمل و الأجر
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href={{ route('ats-single-employees') }} class="nav-link  ">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>كشف العمل والأجر الفردي</p>
                                            </a>
                                        </li>


                                    </ul>
                                </li>



                                <li class="nav-header">الحركة</li>
                                @if ($period_mouv == 1)
                                    {{-- ✅ Movement period is OPEN --}}
                                    <li
                                        class="nav-item has-treeview {{ request()->is('mouvement/*') ? 'menu-open' : '' }} ">
                                        <a href="#"
                                            class="nav-link {{ request()->is('mouvement/*') ? 'active' : '' }}">
                                            <i class="nav-icon fa fa-dashboard"></i>
                                            <p>
                                                إدارة الحركة
                                                <i class="right fa fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href={{ route('mouvement-single-employees') }} class="nav-link  ">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p>طلب تحويل موظف</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href={{ route('mouvement-single-in-employees') }}
                                                    class="nav-link  ">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    @if (isset($inMouvcount) && $inMouvcount > 0)
                                                        <!-- There are rows that match the conditions -->
                                                        <!-- You can use $inMouvcount here -->
                                                        <p>
                                                            <span class="text">معالجة الطلبات المرسلة</span>
                                                            <span
                                                                class="  badge badge-success mouv-title">{{ $inMouvcount }}</span>
                                                        </p>
                                                    @else
                                                        <p>
                                                            <span class="text">معالجة الطلبات المرسلة</span>
                                                            <span class=" badge badge-success mouv-title ">0</span>
                                                        </p>
                                                    @endif
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href={{ route('mouvement-single-out-employees') }}
                                                    class="nav-link  ">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    @if (isset($outMouvcount) && $outMouvcount > 0)
                                                        <p>
                                                            <span class="text">معالجة الطلبات الواردة</span>
                                                            <span
                                                                class="badge badge-danger mouv-title ">{{ $outMouvcount }}</span>
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
                                                <a href={{ route('mouvement-employees-list-release') }}
                                                    class="nav-link  ">
                                                    <i class="fa fa-circle-o nav-icon"></i>
                                                    <p> تحرير موظف</p>
                                                </a>
                                            </li>


                                        </ul>
                                    </li>
                                @else
                                    {{-- 🚫 Movement period is CLOSED --}}
                                    <li class="nav-header text-danger">
                                        <h6 class="text-center ">🚫 الحركة مغلقة حاليا</h6>
                                    </li>
                                @endif



                                <li class="nav-header">لوحة التحكم</li>
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-dashboard"></i>
                                        <p>
                                            الإعدادت
                                            <i class="right fa fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href={{ route('settings-employee-list') }} class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p> تسيير الموظفين</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" class="nav-link">
                                                <i class="fa fa-circle-o nav-icon"></i>
                                                <p>تسيير المؤسسات</p>
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
                <div>
                    @if (isset($notes) && $notes->count() > 0)
                        <marquee direction="left" class="news-banner" loop="" scrollamount="5"
                            {{--   onmouseover="this.stop();" onmouseout="this.start();" --}}>
                            <span class="d-flex" id="news-banner" dir="ltr">
                                @foreach ($notes as $note)
                                    <div class="{{ $note->type == 1 ? 'good' : '' }} {{ $note->type == 2 ? 'bad' : '' }} {{ $note->type == 3 ? 'warning' : '' }}"
                                        style="direction: ltr; {{ !$loop->first ? 'margin-left: 20px;' : '' }}">
                                        {{ $note->text }}
                                    </div>
                                    @if (!$loop->last)
                                        <div style="margin-left: 20px;">--</div>
                                    @endif
                                @endforeach
                            </span>
                        </marquee>
                    @endif


                </div>
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
                    </div>
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
        <script src="{{ asset('admin3/plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('admin3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{ asset('admin3/plugins/morris/morris.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('admin3/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <!-- jvectormap -->
        <script src="{{ asset('admin3/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('admin3/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ asset('admin3/plugins/knob/jquery.knob.js') }}"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="{{ asset('admin3/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- datepicker -->
        <script src="{{ asset('admin3/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ asset('admin3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <!-- Slimscroll -->
        <script src="{{ asset('admin3/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('admin3/plugins/fastclick/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('admin3/dist/js/adminlte.js') }}"></script>

        <script></script>
        @yield('js')

    </body>

</html>
