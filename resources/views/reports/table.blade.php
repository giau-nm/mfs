<table class="table table-responsive" id="reports_table">
    <thead>
        <tr>
            @can('reportAdmin', \App\Models\Report::class)
            <th><a href="{!! $sortLinks['users.name']['url'] !!}" class="sort {!! $sortLinks['users.name']['class'] !!}">{{ trans('report.lbl_username') }}</a></th>
            @endcan
            <th><a href="{!! $sortLinks['projects.name']['url'] !!}" class="sort {!! $sortLinks['projects.name']['class'] !!}">{{ trans('report.projectName') }}</a></th>
            <th><a href="{!! $sortLinks['devices.name']['url'] !!}" class="sort {!! $sortLinks['devices.name']['class'] !!}">{{ trans('report.deviceName') }}</a></th>
            <th>{{ trans('report.content') }}</th>
            <th>{{ trans('report.status_title') }}</th>
            <th><a href="{!! $sortLinks['created_at']['url'] !!}" class="sort {!! $sortLinks['created_at']['class'] !!}">{{ trans('report.date') }}</a></th>
            <th>{{ trans('report.action') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($reports as $report)
        <tr>
            @can('reportAdmin', \App\Models\Report::class)
            <td><a href="{{ route('users.profile', $report->user_id) }}">{!! $report->userName() !!}</a></td>
            @endcan
            <td>{!! $report->projectName() !!}</td>
            <td data-deviceid="{{$report->device_id}}" class="device-name">{!! $report->deviceName() !!}</td>
            <td class="report_table-content">{!! $report->content !!}</td>
            <td>{!! $report->statusString() !!}</td>
            <td>{!! $report->created_at !!}</td>
            <td>
                <div class='btn-group'>
                    {!! Form::open(['route' => ['reports.destroy', $report->id], 'method' => 'delete']) !!}
                    <a href="{!! route('reports.show', [$report->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @can('reportAdmin', \App\Models\Report::class)
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('" . trans('report.confirm_delete') . "')"]) !!}
                    @endcan
                    @cannot('reportAdmin', \App\Models\Report::class)
                        @if ($report->status == STATUS_REPORT_NEW)
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('" . trans('report.confirm_delete') . "')"]) !!}
                        @endif
                    @endcannot
                    {!! Form::close() !!}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="box-footer clearfix">
    {!! $reports->links('pagging.default')!!}
</div>

@include('common.modal_device_detail')
