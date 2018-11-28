<tr>
    @can('requestAdmin', \App\Models\Request::class)
        @if($request->userWithTrashed)
            <td><a href="{{ route('users.profile', $request->userWithTrashed->id) }}">{{ $request->userWithTrashed->name }}</a></td>
        @else
            <td></td>
        @endif
    @endcan
    <td>{{ $request->projectWithTrashed ? $request->projectWithTrashed->name : null}}</td>
    <td data-deviceid="{{ $request->device_id }}" class="device-name">{{ $request->deviceWithTrashed ? $request->deviceWithTrashed->name : null }}</td>
    <td data-name="is_long_time">{!! $request->getLongTimeText() !!}</td>
    <td>{!! $request->start_time->format('Y-m-d') !!}</td>
    <td>{!! $request->end_time->format('Y-m-d') !!}</td>
    <td data-name="status">{!! $request->getStatusText(false) !!}</td>
    @can('requestAdmin', \App\Models\Request::class)
        <td>
        @if ($request->status == STATUS_REQUEST_NEW)
            <a data-status="{!! $request->status !!}" data-url="{!! route('requests.update', $request->id) !!}" class="btn btn-default btn-xs request-href-change-status" data-toggle="modal" data-target="#request-modal-change-status"><span class="text-green">@lang('label.devices.lbl_approve')</span> | <span class="text-red">@lang('label.devices.lbl_reject')</span></a>
        @endif
        @if ($request->status == STATUS_REQUEST_ACCEPT)
            <a data-status="{!! $request->status !!}" data-url="{!! route('requests.update', $request->id) !!}" class="btn btn-default btn-xs request-href-change-status" data-toggle="modal" data-target="#request-modal-change-status"><span class="text-blue">@lang('label.devices.lbl_paid')</span></a>
        @endif
        </td>
    @endcan
    <td>
        {!! Form::open(['route' => ['requests.destroy', $request->id], 'method' => 'delete', 'id' => 'form-delete-' .  $request->id]) !!}
        <div class='btn-group'>
            <a data-url="{{ route('requests.show', $request->id) }}" class='btn btn-default btn-xs btn-view'><i class="glyphicon glyphicon-eye-open"></i></a>
            @can('requestAdmin', \App\Models\Request::class)
                <a data-url="{{ route('requests.edit', $request->id) }}" class='btn btn-default btn-xs btn-edit'><i class="glyphicon glyphicon-edit"></i></a>
                <a href="#" data-toggle="modal" data-target="#modal-delete" class="btn btn-danger btn-xs btn-delete"  data-request-id="{{ $request->id }}"><i class="glyphicon glyphicon-trash"></i></a>
            @endcan
            @cannot('requestAdmin', \App\Models\Request::class)
                @if($request->status == STATUS_REQUEST_NEW)
                    <a href="#" data-toggle="modal" data-target="#modal-delete" class="btn btn-danger btn-xs btn-delete"  data-request-id="{{ $request->id }}"><i class="glyphicon glyphicon-trash"></i></a>
                @endif
            @endcannot
        </div>
        {!! Form::close() !!}
        <!-- /.modal -->
    </td>
</tr>

<script>
    var listRequestStatus = {
        statusNew: parseInt('{!! STATUS_REQUEST_NEW !!}'),
        statusAccept: parseInt('{!! STATUS_REQUEST_ACCEPT !!}'),
        statusReject: parseInt('{!! STATUS_REQUEST_REJECT !!}'),
    };
</script>