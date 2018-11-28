<div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{ trans('label.devices.detail') }}</h4>
        </div>
        <div class="modal-body col-mb-20">
            <div class="row">
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_name') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->name }}
                </div>
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_code') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->code}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_screen_size') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->screen_size }}
                </div>
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_os') }}:
                </div>
                <div class="col-md-3">
                    {!! $data->os !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_type') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->type }}
                </div>
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_manufacture') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->manufacture }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_carrier') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->carrier }}
                </div>
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_phone_number') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->phone_number }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_imei') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->imei }}
                </div>
                <div class="col-md-3 word-br">
                    {{ trans('label.devices.lbl_column_udid') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->udid }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_serial') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->serial }}
                </div>
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_checked_at') }}:
                </div>
                <div class="col-md-3">
                    @if (isset($data->checked_at)) {{ $data->checked_at->format('Y-m-d') }} @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_status') }}:
                </div>
                <div class="col-md-3">
                    {!! $data->getStatusText() !!}
                </div>
                <div class="col-md-3">
                    {{ trans('label.devices.lbl_column_note') }}:
                </div>
                <div class="col-md-3">
                    {{ $data->note }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('label.common.btn_close')}}</button>
        </div>
    </div>
