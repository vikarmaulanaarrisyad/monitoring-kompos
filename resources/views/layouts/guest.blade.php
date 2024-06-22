<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('adminlte') }}/dist/css/adminlte.min.css?v=3.2.0">
</head>

<body class="hold-transition login-page">
    @yield('content')
    <script src="{{ asset('adminlte') }}/plugins/jquery/jquery.min.js"></script>

    <script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    @stack('scripts_vendor')
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('AdminLTE') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('adminlte') }}/dist/js/adminlte.min.js?v=3.2.0"></script>
    @stack('scripts')

    <script>
        // Show password
        $('#customCheck1').on('click', function() {
            if ($(this).is(':checked')) {
                $('.password').attr('type', 'text');
            } else {
                $('.password').attr('type', 'password');
            }
        })
    </script>
</body>

</html>
