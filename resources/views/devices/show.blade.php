@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    
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
            @include('flash::message')
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row" style="padding-left: 20px">
                @include('devices.show_fields')
                <a href="{!! route('devices.index') !!}" class="btn btn-default">Back</a>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    
@endsection
