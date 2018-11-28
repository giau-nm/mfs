@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
            <div class="alert js alert-success none" role="alert"></div>
            <div class="alert js alert-danger none" role="alert"></div>
            @include('flash::message')
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header" style="min-height: 95px;">
                            @can('deviceAdmin', \App\Models\Device::class)
                            <a class="btn btn-primary btn-sm pull-left" style="margin-top: 5px;margin-bottom: 5px" href="{!! route('devices.create') !!}">{{ trans('label.common.btn_add_new') }}</a>
                            <a class="btn btn-primary btn-sm pull-left" style="margin-left: 5px; margin-top: 5px;margin-bottom: 5px" href="{{ $linkExport }}">{{ trans('label.common.btn_export') }}</a>

                            <a href="{!! route('devices.import') !!}" class="btn btn-success btn-sm pull-left" style="margin-left: 5px; margin-top: 5px;margin-bottom: 5px">{{ trans('label.common.btn_import_csv') }}</a>
                            <input type="file" id="file-import-csv-devices" data-href="{!! route('devices.import') !!}" style="display: none" />
                            <div class="lds-css ng-scope" id="loading">
                                <div class="lds-spinner" style="height:100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                </div>
                            @endcan
                            <div class="box-tools">
                                <form action="" method="GET">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="q" value="{{ app('request')->input('q') }}" class="form-control pull-right" placeholder="{{ trans('label.common.lbl_placeholder_search') }}">

                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                            <a class="pull-left" style="margin-top: 5px;margin-bottom: 5px" href="{{ url('Filename.csv') }}">{{ trans('label.common.href_sample_csv') }}</a>
                        </div>
                        <!-- /.box-header -->
                        @include('devices.table')
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    <script src="{{ url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/device/devices.js') }}"></script>
@endsection