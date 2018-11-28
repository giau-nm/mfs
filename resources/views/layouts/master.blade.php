<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADM | @yield('page_title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('bower_components/admin-lte/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ url('bower_components/select2/dist/css/select2.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('extents_css')
    <link rel="stylesheet" href="{{ url('css/styles.css') }}">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        @include('layouts.header')
        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->

        @yield('content')

        <!-- /.content-wrapper -->
        @include('layouts.footer')
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

        <div id="modal-ajax" class="modal fade"></div>

        <div id="modal-waiting" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">
            <div class="modal-dialog modal-m">
                <div class="modal-content">
                    <div class="modal-header"><h3 style="margin:0;" id="modal-waiting-content"></h3></div>
                    <div class="modal-body">
                        <div class="progress progress-striped active" style="margin-bottom:0;">
                            <div class="progress-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('label.common.lbl_delete_heading')</h4>
                    </div>
                    <div class="modal-body">
                        <p>@lang('label.common.confirm_delete')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('label.common.btn_close')</button>
                        <button type="button" class="btn btn-danger" method="DELETE" id="btn-confirm-delete">@lang('label.common.btn_delete')</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ url('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ url('bower_components/multiselect/dist/js/multiselect.min.js') }}"></script>
    <script src="{{ url('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ url('js/common.js') }}"></script>
    <script src="{{ url('js/scripts.js') }}"></script>
    <script>
        var loadingText = '{!! trans('label.common.lbl_loading') !!}';
        var updatingText = '{!! trans('label.common.lbl_updating') !!}';
        var errorReloadPageText = '{!! trans('label.common.lbl_error_reload_page') !!}';
        var maxRequestDate = {{ MAX_REQUEST_DATE }};
    </script>
    @yield('extents_js')
</body>

</html>