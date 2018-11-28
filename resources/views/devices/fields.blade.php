<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('name')) {{'has-error'}} @endif">
                {!! Form::label('name', trans('label.devices.lbl_column_name')) !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('label.devices.lbl_column_name')]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('code')) {{'has-error'}} @endif">
                {!! Form::label('code', trans('label.devices.lbl_column_code')) !!}
                {!! Form::text('code', old('code'), ['class' => 'form-control', 'id' => 'code', 'placeholder' => trans('label.devices.lbl_column_code')]) !!}
                @if ($errors->has('code'))
                    <span class="help-block">{{ $errors->first('code') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('screen_size')) {{'has-error'}} @endif">
                {!! Form::label('screen_size', trans('label.devices.lbl_column_screen_size')) !!}
                {!! Form::text('screen_size', old('screen_size'), ['class' => 'form-control', 'id' => 'screen_size', 'placeholder' => trans('label.devices.lbl_column_screen_size')]) !!}
                @if ($errors->has('screen_size'))
                    <span class="help-block">{{ $errors->first('screen_size') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('os')) {{'has-error'}} @endif">
                {!! Form::label('os', trans('label.devices.lbl_column_os')) !!}
                {!! Form::text('os', old('os'), ['class' => 'form-control', 'id' => 'os', 'placeholder' => trans('label.devices.lbl_column_os')]) !!}
                @if ($errors->has('os'))
                    <span class="help-block">{{ $errors->first('os') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('type')) {{'has-error'}} @endif">
                {!! Form::label('type', trans('label.devices.lbl_column_type')) !!}
                {!! Form::text('type', old('type'), ['class' => 'form-control', 'id' => 'type', 'placeholder' => trans('label.devices.lbl_column_type')]) !!}
                @if ($errors->has('type'))
                    <span class="help-block">{{ $errors->first('type') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('manufacture')) {{'has-error'}} @endif">
                {!! Form::label('manufacture', trans('label.devices.lbl_column_manufacture')) !!}
                {!! Form::text('manufacture', old('manufacture'), ['class' => 'form-control', 'id' => 'manufacture', 'placeholder' => trans('label.devices.lbl_column_manufacture')]) !!}
                @if ($errors->has('manufacture'))
                    <span class="help-block">{{ $errors->first('manufacture') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('carrier')) {{'has-error'}} @endif">
                {!! Form::label('carrier', trans('label.devices.lbl_column_carrier')) !!}
                {!! Form::text('carrier', old('carrier'), ['class' => 'form-control', 'id' => 'carrier', 'placeholder' => trans('label.devices.lbl_column_carrier')]) !!}
                @if ($errors->has('carrier'))
                    <span class="help-block">{{ $errors->first('carrier') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('phone_number')) {{'has-error'}} @endif">
                {!! Form::label('phone_number', trans('label.devices.lbl_column_phone_number')) !!}
                {!! Form::text('phone_number', old('phone_number'), ['class' => 'form-control', 'id' => 'phone_number', 'placeholder' => trans('label.devices.lbl_column_phone_number')]) !!}
                @if ($errors->has('phone_number'))
                    <span class="help-block">{{ $errors->first('phone_number') }}</span>
                @endif
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('imei')) {{'has-error'}} @endif">
                {!! Form::label('imei', trans('label.devices.lbl_column_imei')) !!}
                {!! Form::text('imei', old('imei'), ['class' => 'form-control', 'id' => 'imei', 'placeholder' => trans('label.devices.lbl_column_imei')]) !!}
                @if ($errors->has('imei'))
                    <span class="help-block">{{ $errors->first('imei') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('udid')) {{'has-error'}} @endif">
                {!! Form::label('udid', trans('label.devices.lbl_column_udid')) !!}
                {!! Form::text('udid', old('udid'), ['class' => 'form-control', 'id' => 'udid', 'placeholder' => trans('label.devices.lbl_column_udid')]) !!}
                @if ($errors->has('udid'))
                    <span class="help-block">{{ $errors->first('udid') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('serial')) {{'has-error'}} @endif">
                {!! Form::label('serial', trans('label.devices.lbl_column_serial')) !!}
                {!! Form::text('serial', old('serial'), ['class' => 'form-control', 'id' => 'serial', 'placeholder' => trans('label.devices.lbl_column_serial')]) !!}
                @if ($errors->has('serial'))
                    <span class="help-block">{{ $errors->first('serial') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('checked_at')) {{'has-error'}} @endif">
                {!! Form::label('checked_at', trans('label.devices.lbl_column_checked_at')) !!}
                {!! Form::date('checked_at', (isset($device) && !is_null($device->checked_at)) ? $device->getCheckedAt() : old('checked_at'), ['class' => 'form-control', 'id' => 'checked_at', 'placeholder' => trans('label.devices.lbl_column_checked_at')]) !!}
                @if ($errors->has('checked_at'))
                    <span class="help-block">{{ $errors->first('checked_at') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group @if ($errors->has('status')) {{'has-error'}} @endif">
                {!! Form::label('status', trans('label.devices.lbl_column_status')) !!}
                <div class="radio has-error">
                    <label>
                        <input type="radio" name="status" id="status-{{STATUS_DEVICES_BREAK}}" value="{{STATUS_DEVICES_BREAK}}" @if(old('status') == STATUS_DEVICES_BREAK || (isset($device->status) && $device->status == STATUS_DEVICES_BREAK)) {{ 'checked="checked"'}} @endif}}> <span class="help-block">{{ trans('label.devices.status.lbl_break') }}</span>
                    </label>
                </div>
                <div class="radio has-warning">
                    <label>
                        <input type="radio" name="status" id="status-{{STATUS_DEVICES_BUZY}}" value="{{STATUS_DEVICES_BUZY}}" @if(old('status') == STATUS_DEVICES_BUZY || (isset($device->status) && $device->status == STATUS_DEVICES_BUZY)) {{ 'checked="checked"'}} @endif}}> <span class="help-block">{{ trans('label.devices.status.lbl_buzy') }}</span>
                    </label>
                </div>
                <div class="radio has-success">
                    <label>
                        <input type="radio" name="status" id="status-{{STATUS_DEVICES_AVAIABLE}}" value="{{STATUS_DEVICES_AVAIABLE}}" @if(old('status') == STATUS_DEVICES_AVAIABLE || (isset($device->status) && $device->status == STATUS_DEVICES_AVAIABLE)) {{ 'checked="checked"'}} @endif}}> <span class="help-block">{{ trans('label.devices.status.lbl_avaiable') }}</span>
                    </label>
                </div>
                @if ($errors->has('status'))
                    <span class="help-block">{{ $errors->first('status') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group @if ($errors->has('note')) {{'has-error'}} @endif">
                {!! Form::label('note', trans('label.devices.lbl_column_note')) !!}
                {!! Form::textarea('note', old('note'), ['class' => 'form-control', 'id' => 'note', 'placeholder' => trans('label.devices.lbl_column_note'), 'rows' => 6, 'autocomplete' => 'off']) !!}
                @if ($errors->has('note'))
                    <span class="help-block">{{ $errors->first('note') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /.box-body -->

<div class="box-footer">
    {!! Form::submit(trans('label.common.btn_save'), ['class' => 'btn btn-primary pull-right']) !!}
    <a href="{!! route('devices.index') !!}" style="margin-right: 10px;" class="btn btn-default pull-right">{{ trans('label.common.btn_back') }}</a>
</div>