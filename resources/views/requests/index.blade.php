@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('js/plugin/fSelect/fSelect.css') }}" type="text/css">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {!! $pageTitle !!}
            </h1>
            {!! Breadcrumb::render('requests') !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="alert alert-success none"></div>
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <a id="btn-add-request" class="btn btn-primary btn-sm pull-left" style="margin-top: 5px;margin-bottom: 5px" data-url="{!! route('requests.create') !!}">@lang('request.addNew')</a>
                            @can('requestAdmin', \App\Models\Request::class)
                            <a class="btn btn-primary btn-sm pull-left" style="margin-left: 5px;margin-top: 5px;margin-bottom: 5px" href="{!! $linkExport !!}">@lang('label.common.btn_export')</a>
                            @endcan
                            <div class="box-tools">
                                <form action="{{ route('requests.index') }}" method="get">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Form::select('status[]', $listStatusText, request()->status, [
                                                'id' => 'filter-user-by-status',
                                                'multiple' => 'multiple',
                                                'data-placeholder' => trans('label.common.lbl_status'),
                                                'data-overflowText' => trans('request.multiple_status_select.overflow_text'),
                                                'data-noResultsText' => trans('request.multiple_status_select.no_results_text'),
                                                'data-searchText' => trans('label.common.lbl_placeholder_search')
                                            ]) !!}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="searchData" value="{{ $searchData }}" class="form-control pull-right" placeholder="Search">
                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        @include('requests.table')
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
    <script type="text/javascript" src="{{ url('js/plugin/fSelect/fSelect.js') }}"></script>
    <script src="{{ url('js/request/request.js') }}"></script>
@endsection

