
{!! trans('request.mail.dear') !!} {!! trans('request.mail.mr_ms') !!} {!! $requestModel->user->name !!},<br>
{!! trans('request.mail.mr_ms') !!} <strong>{!! \Auth::user()->name !!}</strong> đã {!! ($data['status'] == STATUS_REQUEST_ACCEPT)? trans('label.devices.lbl_approve') : trans('label.devices.lbl_reject') !!} {!! trans('request.mail.after_accept_reject') !!}.<br>
<br>
{!! trans('request.mail.device_info') !!}:
<table>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_name') !!}: </td>
        <td>{!! $requestModel->device->name !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_type') !!}: </td>
        <td>{!! $requestModel->device->type !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_code') !!}: </td>
        <td>{!! $requestModel->device->code !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_os') !!}: </td>
        <td>{!! $requestModel->device->os !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_screen_size') !!}: </td>
        <td>{!! $requestModel->device->screen_size !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_manufacture') !!}: </td>
        <td>{!! $requestModel->device->manufacture !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_note') !!}: </td>
        <td>{!! $requestModel->device->note !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_phone_number') !!}: </td>
        <td>{!! $requestModel->device->phone_number !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_imei') !!}: </td>
        <td>{!! $requestModel->device->imei !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_udid') !!}: </td>
        <td>{!! $requestModel->device->udid !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_serial') !!}: </td>
        <td>{!! $requestModel->device->serial !!}</td>
    </tr>
    <tr>
        <td>- {!! trans('label.devices.lbl_column_checked_at') !!}: </td>
        <td>{!! $requestModel->device->checked_at !!}</td>
    </tr>
</table>

<br>
