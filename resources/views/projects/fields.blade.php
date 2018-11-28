<div class="form-group @if ($errors->has('name')) {{'has-error'}} @endif">
    <label>{{ trans('project.projectName') }}</label>
    <div class="form-group">
        {!! Form::text('name', old('name'), [
            'id'       => 'name',
            'class'    => 'form-control',
            'required'    => 'required'
        ]) !!}
    </div>
    @if ($errors->has('name'))
        <span class="help-block">{{ $errors->first('name') }}</span>
    @endif
</div>

<div class="form-group @if ($errors->has('manager')) {{'has-error'}} @endif">
    <label>{{ trans('project.manager') }}</label>
    {!! Form::select('manager', $listUser, old('manager'), [
        'class'            => 'form-control select2',
        'required'         => 'required',
        'placeholder'      => '',
        'style'            => 'width: 100%;',
        'id'               => 'manager'
    ]) !!}
    @if ($errors->has('manager'))
        <span class="help-block">{{ $errors->first('manager') }}</span>
    @endif
</div>