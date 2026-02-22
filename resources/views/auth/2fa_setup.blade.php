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
</head>

<body>
    <div class="container">
        <h2>Setup Google 2FA</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <p>Scan the QR code below with your Google Authenticator app, then enter the generated code to enable 2FA.</p>

        <div class="mb-3">
            <!-- Display QR Code using an external API -->
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($qrCodeUrl) }}&size=200x200"
                alt="QR Code">
        </div>

        <p>Your secret key: <strong>{{ $secret }}</strong></p>

        <form method="POST" action="{{ route('google2fa.enable') }}">
            @csrf
            <div class="form-group">
                <label for="one_time_password">Enter Code from App:</label>
                <input type="text" name="one_time_password" id="one_time_password" class="form-control" required>
                @error('one_time_password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-2">Enable 2FA</button>
        </form>
    </div>
</body>

</html>
