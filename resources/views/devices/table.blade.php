<div class="box-body table-responsive no-padding">
    <table class="table table-hover table-bordered table-sorter">
        <thead>
            <tr>
                <th><a href="#" data-url="{{ $sortLinks['id']['url'] }}" class="sort {{ $sortLinks['id']['class'] }}">{{ trans('label.devices.lbl_column_id') }}</a></th>
                <th><a href="#" data-url="{{ $sortLinks['name']['url'] }}" class="sort {{ $sortLinks['name']['class'] }}">{{ trans('label.devices.lbl_column_name') }}</a></th>
                <th>{{ trans('label.devices.lbl_column_code') }}</th>
                <th>{{ trans('label.devices.lbl_column_screen_size') }}</th>
                <th><a href="#" data-url="{{ $sortLinks['manufacture']['url'] }}" class="sort {{ $sortLinks['manufacture']['class'] }}">@lang('label.devices.lbl_column_manufacture')</a></th>
                <th><a href="#" data-url="{{ $sortLinks['os']['url'] }}" class="sort {{ $sortLinks['os']['class'] }}">@lang('label.devices.lbl_column_os')</a></th>
                <th><a href="#" data-url="{{ $sortLinks['imei']['url'] }}" class="sort {{ $sortLinks['imei']['class'] }}">@lang('label.devices.lbl_column_imei')</a></th>
                <th><a href="#" data-url="{{ $sortLinks['udid']['url'] }}" class="sort {{ $sortLinks['udid']['class'] }}">@lang('label.devices.lbl_column_udid')</a></th>
                <th><a href="#" data-url="{{ $sortLinks['status']['url'] }}" class="sort {{ $sortLinks['status']['class'] }}">@lang('label.common.lbl_status')</a></th>
                <th colspan="3">@lang('label.common.lbl_action')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
            <tr data-id="{{ $device->id }}">
                <td>{!! $device->id !!}</td>
                <td data-deviceid="{{ $device->id }}" class="device-name">{!! $device->name !!}</td>
                <td>{!! $device->code !!}</td>
                <td>{!! $device->screen_size !!}</td>
                <td>{!! $device->manufacture !!}</td>
                <td>{!! $device->os !!}</td>
                <td>{!! $device->imei !!}</td>
                <td>{!! $device->udid !!}</td>
                <td>{!! $device->getStatusText() !!}</td>
                <td>
                    <div class='btn-group'>
                        @can('deviceAdmin', \App\Models\Device::class)
                        <a href="{!! route('devices.change-status', [$device->id]) !!}" data-status="{!! $device->status !!}" class='btn btn-default btn-xs btn-change-status'><i class="glyphicon glyphicon-random"></i></a>
                        <a href="{!! route('devices.edit', [$device->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        <a href="{!! route('devices.destroy', [$device->id]) !!}" class='btn btn-danger btn-xs btn-delete-item'><i class="glyphicon glyphicon-trash"></i></a>
                        @endcan
                        @cannot('deviceAdmin', \App\Models\Device::class)
                            @if($device->status == STATUS_DEVICES_AVAIABLE)
                                 <a data-device-id="{{ $device->id }}" class='btn btn-xs btn-success btn-add-request' data-url="{!! route('requests.create', ['device_id' => $device->id]) !!}"><i class="fa fa-book"></i> {{ trans('label.devices.btn_request') }}</a>
                            @endif
                        @endcannot
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" id="url_get_user_request" value="{{route('requests.info')}}">
<!-- /.box-body -->
<div class="box-footer clearfix">
    {!! $devices->links('pagging.default')!!}
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-change-status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('label.common.btn_close')">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('label.devices.lbl_device_change_status_heading')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Choose status</label>
                    <select class="form-control" id="status-device">
                        @foreach (LIST_STATUS_DEVICES as $keyStatus => $textStatus)
                        <option value="{{ $keyStatus }}">{{ trans('label.devices.status.lbl_' . $textStatus) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('label.common.btn_close')</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-change-status">@lang('label.devices.btn_change_status')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- /.modal -->
<div class="modal fade" id="modal-request-info">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@include('common.modal_device_detail')