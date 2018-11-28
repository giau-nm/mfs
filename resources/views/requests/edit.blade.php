<div class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(['route' => ['requests.update', $request->id], 'method' => 'PUT', 'id' => 'form-update']) !!}
            <input type="hidden" name="start_time" value="{{ $request->start_time->format('Y-m-d') }}">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('request.editRequest') }}</h4>
            </div>
            <div class="modal-body">
                    @if(isset($message))
                        <div class="alert alert-danger">{{ $message }}</div>
                    @endif
                    <div id="form-update-display-fail" class="row" style="padding-top: 10px; display: none">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i></h4>
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('status')) {{'has-error'}} @endif">
                        <label>{{ trans('request.lbl_column_status') }}</label>
                        <select class="form-control" name="status" required>
                            @foreach (REQUEST_STATUS_TEXT as $key => $status)
                                <option @if ($request->status == $key || old('status') == $key) selected @endif value="{{ $key }}">{{ trans($status) }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('status'))
                            <span class="help-block">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('is_long_time')) {{'has-error'}} @endif">
                        <label>{{ trans('request.lbl_column_is_long_time') }}</label>
                        <select class="form-control" name="is_long_time" required>
                            @foreach (REQUEST_LONG_TIME_TEXT as $key => $longTime)
                                <option @if ($request->is_long_time == $key || old('is_long_time') == $key) selected @endif value="{{ $key }}">{{ trans($longTime) }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('is_long_time'))
                            <span class="help-block">{{ $errors->first('is_long_time') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('actual_start_time')) {{'has-error'}} @endif">
                        <label>{{ trans('request.lbl_column_actual_start_time') }}</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {!! Form::text('actual_start_time', old('actual_start_time',  isset($request->actual_start_time) ? $request->actual_start_time->format('Y-m-d') : null), [
                                'id' => 'actualStartTime',
                                'class' => 'form-control datepicker',
                                'data-date-start-date' => $request->start_time->format('Y-m-d'),
                                'required' => 'required',
                                'readonly' => 'readonly'
                            ]) !!}
                        </div>
                        @if ($errors->has('actual_start_time'))
                            <span class="help-block">{{ $errors->first('actual_start_time') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('actual_end_time')) {{'has-error'}} @endif">
                        <label>{{ trans('request.lbl_column_actual_end_time') }}</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {!! Form::text('actual_end_time', old('actual_end_time', isset($request->actual_end_time) ? $request->actual_end_time->format('Y-m-d') : null), [
                                'id' => 'actualEndTime',
                                'class' => 'form-control datepicker',
                                'data-date-start-date' => isset($request->actual_start_time) ? $request->actual_start_time->format('Y-m-d') : $request->start_time->format('Y-m-d'),
                                'readonly' => 'readonly'
                            ]) !!}
                        </div>
                        @if ($errors->has('actual_end_time'))
                            <span class="help-block">{{ $errors->first('actual_end_time') }}</span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('note')) {{'has-error'}} @endif">
                        <label>{{ trans('request.lbl_column_note') }}</label>
                        <textarea class="form-control" name="note">{{ old('note',  isset($request->note) ? $request->note : null) }}</textarea>
                        @if ($errors->has('note'))
                            <span class="help-block">{{ $errors->first('note') }}</span>
                        @endif
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('label.common.btn_close')}}</button>
                <div class="lds-css ng-scope" id="loading-right">
                    <div class="lds-spinner" style="width:100%;height:100%"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
                <button type="submit" class="btn btn-danger" id="btn-update">{{ trans('label.common.btn_save')}}</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>