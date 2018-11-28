@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    <link rel="stylesheet" href="{{ url('js/plugin/jexcel/dist/css/jquery.jexcel.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('js/plugin/jexcel/dist/css/jquery.jcalendar.css') }}" type="text/css" />
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {!! $pageTitle !!}
            </h1>
            {!! Breadcrumb::render('devices') !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            <div class="alert alert-danger alert-dismissible" id="div-error-display" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <div class="row" id="div-error-display-content">
                </div>
            </div>
            @include('flash::message')
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            @can('deviceAdmin', \App\Models\Device::class)
                                <a data-url="{!! route('devices.save-data-csv') !!}" method="POST" class="btn btn-primary btn-sm pull-left glyphicon glyphicon-plus" id="btn-device-excel-add-row" style="margin-top: 5px;margin-bottom: 5px; margin-right: 10px"></a>
                                <a data-url="{!! route('devices.save-data-csv') !!}" method="POST" class="btn btn-primary btn-sm pull-left glyphicon glyphicon-minus" id="btn-device-excel-delete-row" style="margin-top: 5px;margin-bottom: 5px"></a>
                                <a data-url="{!! route('devices.save-data-csv') !!}" method="POST" class="btn btn-primary btn-sm pull-right" id="btn-device-excel-save" style="margin-top: 5px;margin-bottom: 5px">{{ trans('label.common.btn_save') }}</a>
                            @endcan
                        </div>
                        <div id="my"></div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    <script type="text/javascript" src="{{ url('js/plugin/jexcel/dist/js/jquery.jcalendar.js') }}"></script>
    <script type="text/javascript" src="{{ url('bower_components/jquery-csv/src/jquery.csv.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/plugin/jexcel/dist/js/jquery.jexcel.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/device/jexcelImport.js') }}"></script>

    <script type="text/javascript">
        var csvLink = '{!! route('devices.index', ['export' => 1]) !!}';
    </script>
@endsection