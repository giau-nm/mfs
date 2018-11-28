@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
        
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="height: 33px;">
            {!! Breadcrumb::render('devices') !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{!! $pageTitle !!}</h3>
                        </div>
                        <!-- /.box-header -->
                        {!! Form::model($device, ['route' => ['devices.update', $device->id], 'method' => 'patch']) !!}
                            @include('devices.fields')
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('label.devices.lbl_heading_history_request')</h3>
                                </div>
                                @if (!is_null($listRequests) && $listRequests->count() > 0)
                                    <div class="box-body table-responsive no-padding">
                                        <table class="table table-hover table-bordered table-sorter">
                                            <thead>
                                                <tr>
                                                    @can('requestAdmin', \App\Models\Request::class)
                                                    <th>@lang('request.lbl_column_username')</th>
                                                    @endcan
                                                    <th>@lang('request.lbl_column_project_name')</th>
                                                    <th>@lang('request.lbl_column_device_name')</th>
                                                    <th>@lang('request.lbl_column_status')</th>
                                                    <th>@lang('request.lbl_column_is_long_time')</th>
                                                    <th>@lang('request.lbl_column_start_time')</th>
                                                    <th>@lang('request.lbl_column_end_time')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($listRequests as $item)
                                                <tr>
                                                    @can('requestAdmin', \App\Models\Request::class)
                                                    <td><a href="{{ route('users.profile', $item->user_id) }}">{{ $item->userWithTrashed ? $item->userWithTrashed->name : null }}</a></td>
                                                    @endcan
                                                    <td>{{ $item->projectWithTrashed ? $item->projectWithTrashed->name : null}}</td>
                                                    <td>{{ $item->deviceWithTrashed ? $item->deviceWithTrashed->name : null }}</td>
                                                    <td data-name="status">{!! $item->getStatusText() !!}</td>
                                                    <td data-name="is_long_time">{!! $item->getLongTimeText() !!}</td>
                                                    <td>{!! $item->start_time->format('Y-m-d') !!}</td>
                                                    <td>{!! $item->end_time->format('Y-m-d') !!}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer clearfix">
                                        {!! $listRequests->links('pagging.default')!!}
                                    </div>
                                @else
                                    <div class="box-body table-responsive">
                                        <p>@lang('label.devices.not_found_history_requests')</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('label.devices.lbl_heading_history_report')</h3>
                                </div>
                                @if (!is_null($listReports) && $listReports->count() > 0)
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover table-bordered table-sorter">
                                        <thead>
                                            <tr>
                                                @can('reportAdmin', \App\Models\Report::class)
                                                <th>{{ trans('report.lbl_username') }}</th>
                                                @endcan
                                                <th>{{ trans('report.projectName') }}</th>
                                                <th>{{ trans('report.deviceName') }}</th>
                                                <th>{{ trans('report.content') }}</th>
                                                <th>{{ trans('report.status_title') }}</th>
                                                <th>{{ trans('report.date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($listReports as $report)
                                            <tr>
                                                @can('reportAdmin', \App\Models\Report::class)
                                                <td><a href="{{ route('users.profile', $report->user_id) }}">{!! $report->userName() !!}</a></td>
                                                @endcan
                                                <td>{!! $report->projectName() !!}</td>
                                                <td>{!! $report->deviceName() !!}</td>
                                                <td class="report_table-content">{!! $report->content !!}</td>
                                                <td>{!! $report->statusString() !!}</td>
                                                <td>{!! $report->created_at !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    {!! $listReports->links('pagging.default')!!}
                                </div>
                                @else
                                    <div class="box-body table-responsive">
                                        <p>@lang('label.devices.not_found_history_reports')</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    
@endsection