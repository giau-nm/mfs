@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $pageTitle }}
            </h1>
            {!! Breadcrumb::render('home') !!}
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
                            <h3 class="box-title">{{ $pageTitle }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {!! Form::open(['route' => 'devices.store', 'role' => 'form']) !!}
                            @include('devices.fields')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    
@endsection