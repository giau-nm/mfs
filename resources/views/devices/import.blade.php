@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.5.3/css/tabulator.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $pageTitle }}
            </h1>
            {!! Breadcrumb::render('devices.import') !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            <div class="alert js alert-success none" role="alert"></div>
            <div class="alert js alert-danger none" role="alert"></div>
            @include('adminlte-templates::common.errors')
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"></h3>
                            <button data-href="{{ route('devices.save-data-csv') }}" disabled="disabled" class="btn btn-primary pull-right" id="set-data">Save</button>
                        </div>
                        <div id="csv-table" data-file-csv="{{$fileCsv}}"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.5.3/js/tabulator.min.js"></script>
    <script type="text/javascript" src="{{ url('js/device/devices.js') }}"></script>
@endsection