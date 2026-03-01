<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- yield to instance the title and change it in child view  --}}
    <title>تسجيل الدخول</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- cairo font link online --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Font Awesome -->
    <link rel="stylesheet" href="/rawateb/public/admin3/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/rawateb/public/admin3/dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/rawateb/public/admin3/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/rawateb/public/admin3/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/rawateb/public/admin3/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/rawateb/public/admin3/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/rawateb/public/admin3/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/rawateb/public/admin3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="/rawateb/public/admin3/dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="/rawateb/public/admin3/dist/css/custom-style.css">


</head>

<body class="hold-transition sidebar-mini">

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>منصة تسير نفقات المستخدمين</b></a>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"> صفحة تسجيل الدخول</p>
                <form action="{{ route('admin-login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="إسم المستخدم">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="كلمة المرور">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="social-auth-links text-center mb-3">
                        <button type="submit" class="btn btn-block btn-primary">
                            تسجيل الدخول
                        </button>

                    </div>
                </form>



            </div>

        </div>
    </div>


     <!-- ./wrapper -->
 <!-- jQuery -->
    <script src="/rawateb/public/admin3/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/rawateb/public/admin3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="/rawateb/public/admin3/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="/rawateb/public/admin3/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="/rawateb/public/admin3/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/rawateb/public/admin3/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/rawateb/public/admin3/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="/rawateb/public/admin3/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/rawateb/public/admin3/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/rawateb/public/admin3/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="/rawateb/public/admin3/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="/rawateb/public/admin3/plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="/rawateb/public/admin3/dist/js/adminlte.js"></script>
</body>

</html>
