<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Terai Hospital and Research Centre || Birgunj
    </title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{URL::asset('custom-images/faviconlogo.jpg')}}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!--  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->

    <link rel="stylesheet" href="{{URL::asset('backendtheme/plugins/datatables/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/customcss/gallery.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/customfile/css/lightbox.min.css') }}">
    <link href="/css/treeview.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('daterangepicker/css/daterangepicker.css')}}"/>

    <link rel="stylesheet" href="{{URL::asset('backendtheme/bootstrap/css/calendarview.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('backendtheme/bootstrap/css/custom.css')}}">

    <link rel="stylesheet" href="{{URL::asset('backendtheme/bootstrap/fontawesome/css/font-awesome.min.css')}}">


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @yield('headercontent')
    @yield('leftmenucontent')

    <div class="content-wrapper" id="container-fluid">
    @yield('flashmessage')

    @yield('userscontent')
    <!-- Main content -->

    </div>
    <!-- /.content-wrapper -->
<!--  @section('js')
    -->    @yield('footercontent')


</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{URL::asset('backendtheme/plugins/jQuery/jquery-3.2.1.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/bootstrap/js/bootstrap.min.js')}}"></script>

<script src="{{URL::asset('backendtheme/customValidation/validatefile/jquery.validate.js')}}"></script>

<script src="{{URL::asset('backendtheme/plugins/fastclick/fastclick.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/dist/js/app.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/customjs/gallery.js')}}"></script>
<script src="{{URL::asset('backendtheme/bootstrap/js/custom.js')}}"></script>
<script src="{{URL::asset('digitalclock/js/script.js')}}"></script>
<script src="{{URL::asset('js/treeview.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('daterangepicker/js/moment.min.js')}}"></script>
<script src="{{URL::asset('digitalclock/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('timepicker/bootstrap-datetimepicker.js')}}"></script>
<link rel="stylesheet" href="{{URL::asset('timepicker/datetimepicker.min.css')}}"/>
<script type="text/javascript" src="{{URL::asset('timepicker/daterangepicker.js')}}"></script>


{{--<script>
    $(function () {
        $("#example1").DataTable({
            "paging": false,
            "lengthChange": false,
            //"searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
        $('#example2').DataTable({
            "paging": false,
            "lengthChange": false,
            //"searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>--}}
<script src="{{URL::asset('backendtheme/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/plugins/iCheck/icheck.min.js')}}"></script>
<script src="{{URL::asset('backendtheme/bootstrap/js/passwordcheck.js')}}"></script>
<script src="{{URL::asset('backendtheme/lib/nepali.datepicker.v2/nepali.datepicker.v2.min.js')}}"></script>

@yield('footerscripts')
</body>
</html>
