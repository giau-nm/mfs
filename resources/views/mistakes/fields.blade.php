<!-- Ten Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('ten', 'Tên:') !!}
    {!! Form::textarea('ten', null, ['class' => 'form-control']) !!}
</div>

<!-- Mo Ta Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('mo_ta', 'Mô tả:') !!}
    {!! Form::textarea('mo_ta', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('mistakes.index') !!}" class="btn btn-default">Hủy bỏ</a>
</div>
