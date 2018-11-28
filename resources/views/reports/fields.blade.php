<!-- Project Id Field -->
<div class="box-body">
    <div class="row">
        <div class="form-group col-sm-6 @if ($errors->has('project_id')) {{'has-error'}} @endif">
            {!! Form::label('project_id', trans('report.projectName')) !!}
            {!! Form::select('project_id', $projects, old('project_id'), ['class' => 'form-control', 'required' => 'required']) !!}
            @if ($errors->has('project_id'))
                <span class="help-block">{{ $errors->first('project_id') }}</span>
            @endif
        </div>

        <!-- Device Id Field -->
        <div class="form-group col-sm-6 @if ($errors->has('device_id')) {{'has-error'}} @endif">
            {!! Form::label('device_id', trans('report.deviceName')) !!}
            {!! Form::select('device_id', $devices, old('device_id'), ['class' => 'form-control',  'required' => 'required']) !!}
            @if ($errors->has('device_id'))
                <span class="help-block">{{ $errors->first('device_id') }}</span>
            @endif
        </div>

        <!-- Content Field -->
        <div class="form-group col-sm-12 col-lg-12 @if ($errors->has('content')) {{'has-error'}} @endif">
            {!! Form::label('content', trans('report.content')) !!}
            {!! Form::textarea('content', old('content'), ['class' => 'form-control',  'required' => 'required']) !!}
            @if ($errors->has('content'))
                <span class="help-block">{{ $errors->first('content') }}</span>
            @endif
        </div>

        <!-- Submit Field -->
        <div class="form-group col-sm-12">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('reports.index') !!}" class="btn btn-default">Cancel</a>
        </div>
    </div>
</div>