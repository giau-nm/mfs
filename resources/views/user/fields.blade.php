<!-- Ma Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Họ và tên') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Tieu Chi Lon Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('email', 'Email đăng nhập:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<!-- Tieu Chi Nho Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('nhom_tai_khoan', 'Nhóm tài khoản:') !!}
    {!! Form::select('nhom_tai_khoan', [
        'Quản trị hệ thống(administrator)' => 'Quản trị hệ thống(administrator)',
        'Điện thoại viên' => 'Điện thoại viên',
        'Quản lý' => 'Quản lý',
    ] , null, ['class' => 'form-control']) !!}
</div>

<!-- Dat Neu Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('phone', 'Số điện thoại') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- So Diem Duoc Neu Dat Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('address', 'Địa chỉ') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
</div>
