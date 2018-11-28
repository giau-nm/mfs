<div class="modal-dialog">
    <div class="modal-content">

        @if (is_numeric($devices))
            {!! Form::open(['route' => ['requests.store', 'device_id' => $devices], 'method' => 'POST', 'id' => 'form-add-request']) !!}
            {!! Form::hidden('device_id', $devices, ['id' => 'deviceId']) !!}
        @else
            {!! Form::open(['route' => ['requests.store'], 'method' => 'POST', 'id' => 'form-add-request']) !!}
        @endif
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">{{ trans('request.addNew') }}</h4>
        </div>
        <div class="modal-body">
            <div class="form-group @if ($errors->has('project_id')) {{'has-error'}} @endif">
                <label>{{ trans('request.project') }}</label>
                {!! Form::select('project_id', $projects, old('project_id'), [
                    'class'            => 'form-control select2',
                    'placeholder'      => '',
                    'data-placeholder' => trans('request.select_project'),
                    'style'            => 'width: 100%;'
                ]) !!}
                @if ($errors->has('project_id'))
                    <span class="help-block">{{ $errors->first('project_id') }}</span>
                @endif
            </div>
            @if (!is_numeric($devices))
                <div class="form-group @if ($errors->has('device_id')) {{'has-error'}} @endif">
                    <label>{{ trans('request.device') }}</label>
                    {!! Form::select('device_id', $devices, old('device_id'), [
                        'class'            => 'form-control select2',
                        'required'         => 'required',
                        'placeholder'      => '',
                        'data-placeholder' => trans('request.select_device'),
                        'style'            => 'width: 100%;'
                    ]) !!}
                    @if ($errors->has('device_id'))
                        <span class="help-block">{{ $errors->first('device_id') }}</span>
                    @endif
                </div>
            @endif
            <div class="form-group @if ($errors->has('start_time')) {{'has-error'}} @endif">
                <label>{{ trans('request.lbl_column_start_time') }}</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('start_time', old('start_time'), [
                        'id'       => 'startTime',
                        'class'    => 'form-control datepicker',
                        'required' => 'required',
                        'readonly' => 'readonly'
                    ]) !!}
                </div>
                @if ($errors->has('start_time'))
                    <span class="help-block">{{ $errors->first('start_time') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('end_time')) {{'has-error'}} @endif">
                <label>{{ trans('request.lbl_column_end_time') }}</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('end_time', old('end_time'), [
                        'id'       => 'endTime',
                        'class'    => 'form-control datepicker',
                        'required' => 'required',
                        'readonly' => 'readonly'
                    ]) !!}
                </div>
                @if ($errors->has('end_time'))
                    <span class="help-block">{{ $errors->first('end_time') }}</span>
                @endif
            </div>
            <div class="form-group @if ($errors->has('note')) {{'has-error'}} @endif">
                <label>{{ trans('request.lbl_column_note') }}</label>
                {!! Form::textarea('note', old('note'), [
                    'class' => 'form-control',
                    'rows'  => 5
                ]) !!}
                @if ($errors->has('note'))
                    <span class="help-block">{{ $errors->first('note') }}</span>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('label.common.btn_close')}}</button>
            <button type="submit" class="btn btn-danger" id="btn-add">{{ trans('label.common.btn_add_new')}}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>