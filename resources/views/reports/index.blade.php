@extends('layouts.master')
@section('page_title')
@section('extents_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">

@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{ trans('report.add_new') }}</h1>
            {!! Breadcrumb::render('reports') !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <a class="btn btn-primary btn-sm pull-left" style="margin-top: 5px;margin-bottom: 5px" href="{!! route('reports.create') !!}">{{ trans('report.add_new') }}</a>
                            <br />
                            <div class="clearfix"></div>
                            <div class="col-md-1" style="padding-left: 0px"><label style="padding-top:3px">{{ trans('report.status_title') }}</label></div>
                            <div class="col-md-2">
                                {!! Form::select('status', $listStatus, (isset($request['status'])? $request['status'] : array_keys($listStatus)[0]), [
                                            'class' => 'form-control pull-right',
                                            'id' => 'report_search_status',
                                            'data-url' => route('reports.index')
                                ]) !!}
                            </div>

                            <div class="col-md-3 col-md-offset-0">
                                <div class="input-group">
                                    {!! Form::text('search', (isset($request['find'])? $request['find'] : ''), [
                                            'class' => 'form-control pull-right',
                                            'id' => 'report_search-input',
                                            'placeholder' => 'Search',
                                            'data-url' => route('reports.index')
                                    ]) !!}

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default" id="report_search-btn"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        @include('reports.table')
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    <script src="{{ url('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ url('js/report/report.js') }}"></script>
@endsection
