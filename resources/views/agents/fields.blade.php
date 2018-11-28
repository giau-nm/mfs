<!-- Doanh So Field -->
<div class="form-group col-sm-6">
    {!! Form::label('doanh_so', 'Danh số') !!}
    {!! Form::number('doanh_so', null, ['class' => 'form-control']) !!}
</div>

<!-- Ho Ten Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('ho_ten', 'Họ tên') !!}
    {!! Form::textarea('ho_ten', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- So Dien Thoai Field -->
<div class="form-group col-sm-6">
    {!! Form::label('so_dien_thoai', 'Số điện thoại') !!}
    {!! Form::text('so_dien_thoai', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('agents.index') !!}" class="btn btn-default">Hủy bỏ</a>
</div>
