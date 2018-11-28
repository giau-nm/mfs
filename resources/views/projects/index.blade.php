@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
<link rel="stylesheet" href="{{ url('bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{ $pageTitle }}</h1>
            {!! Breadcrumb::render('projects') !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            <div class="alert js alert-success none" role="alert"></div>
            <div class="alert js alert-danger none" role="alert"></div>
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <a id="btn-add-project" class="btn btn-primary pull-left" style="margin-top: 5px;margin-bottom: 5px" href="#" data-url="{!! route('projects.create') !!}">{{ trans('project.add_new') }}</a>
                        </div>
                        <!-- /.box-header -->
                        @include('projects.table')
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    <script src="{{ url('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ url('js/project/project.create.js') }}"></script>
@endsection
