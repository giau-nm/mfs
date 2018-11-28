@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    <link rel="stylesheet" href="{{ url('bower_components/select2/dist/css/select2.min.css') }}">

@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ trans('report.title.create') }}</h1>
            {!! Breadcrumb::render('reports') !!}
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            {!! Form::open(['route' => 'reports.store']) !!}
                            @include('reports.fields')
                            {!! Form::close() !!}
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->

                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    <script src="{{ url('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ url('js/report/report.create.js') }}"></script>
@endsection
