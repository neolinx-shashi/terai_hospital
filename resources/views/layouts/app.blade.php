<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Terai Hospital and Research Centre|| Birgunj</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/bootstrap/css/custom.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/plugins/iCheck/square/blue.css')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{URL::asset('custom-images/faviconlogo.jpg')}}">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

<body class="hold-transition login-page">


@yield('content')
<script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
