<!-- Ten Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ten', 'Tên:') !!}
    {!! Form::text('ten', null, ['class' => 'form-control']) !!}
</div>

<!-- Tieu De Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('tieu_de', 'Tiêu Dề:') !!}
    {!! Form::textarea('tieu_de', null, ['class' => 'form-control']) !!}
</div>

<!-- Mo Ta Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('mo_ta', 'Mô Tả:') !!}
    {!! Form::textarea('mo_ta', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('workgroups.index') !!}" class="btn btn-default">Hủy bỏ</a>
</div>
