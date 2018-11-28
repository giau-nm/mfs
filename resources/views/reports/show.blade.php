@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    <link rel="stylesheet" href="{{ url('bower_components/select2/dist/css/select2.min.css') }}">

@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ $pageTitle }}</h1>
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
                            <div class="row">
                             <!-- Project Id Field -->
                             <div class="form-group col-sm-6">
                                     {!! Form::label('project_id', trans('report.projectName')) !!}
                                     {!! Form::text('project_id', $report->projectName(), ['class' => 'form-control', 'readonly' => 'true']) !!}
                             </div>

                             <!-- Device Id Field -->
                             <div class="form-group col-sm-6">
                                     {!! Form::label('device_id', trans('report.deviceName')) !!}
                                     {!! Form::text('device_id', $report->deviceName(0), ['class' => 'form-control', 'readonly' => 'true']) !!}
                             </div>

                             <!-- Content Field -->
                             <div class="form-group col-sm-12 col-lg-12">
                                     {!! Form::label('content', trans('report.content')) !!}
                                     {!! Form::textarea('content', $report->content, ['class' => 'form-control', 'readonly' => 'true']) !!}
                             </div>

                             <div class="form-group col-sm-6 col-lg-6">
                                     {!! Form::label('content', trans('report.date')) !!}
                                     {!! Form::text('time', $report->created_at, ['class' => 'form-control', 'readonly' => 'true']) !!}
                             </div>

                             <div class="form-group col-sm-6 col-lg-6">
                                     {!! Form::label('content', trans('report.status_title')) !!}<br \>
                                     {!! $report->statusString() !!}
                             </div>
                     </div>
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
@endsection