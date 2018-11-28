<!-- Ma Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ma', 'Mã:') !!}
    {!! Form::text('ma', null, ['class' => 'form-control']) !!}
</div>

<!-- Ten Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ten', 'Tên:') !!}
    {!! Form::text('ten', null, ['class' => 'form-control']) !!}
</div>

<!-- Diem Tu Field -->
<div class="form-group col-sm-6">
    {!! Form::label('diem_tu', 'Điểm từ:') !!}
    {!! Form::number('diem_tu', null, ['class' => 'form-control']) !!}
</div>

<!-- Diem Den Field -->
<div class="form-group col-sm-6">
    {!! Form::label('diem_den', 'Điểm đến:') !!}
    {!! Form::number('diem_den', null, ['class' => 'form-control']) !!}
</div>

<!-- Mo Ta Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('mo_ta', 'Mô tả:') !!}
    {!! Form::textarea('mo_ta', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ratingLevels.index') !!}" class="btn btn-default">Hủy bỏ</a>
</div>
