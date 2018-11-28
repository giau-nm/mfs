<!-- Ma Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ma', 'Mã:') !!}
    {!! Form::text('ma', null, ['class' => 'form-control']) !!}
</div>

<!-- Tieu De Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tieu_de', 'Tiêu đề:') !!}
    {!! Form::text('tieu_de', null, ['class' => 'form-control']) !!}
</div>

<!-- Mo Ta Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('mo_ta', 'Mô tả:') !!}
    {!! Form::textarea('mo_ta', null, ['class' => 'form-control']) !!}
</div>

<!-- Chao Don Khach Hang Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chao_don_khach_hang', 'Chào đón khách hàng (Tỷ trọng %)') !!}
    {!! Form::number('chao_don_khach_hang', null, ['class' => 'form-control']) !!}
</div>

<!-- Nam Bat Nhu Cau Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nam_bat_nhu_cau', 'Nắm bắt khu cầu KH (Tỷ trọng %)') !!}
    {!! Form::number('nam_bat_nhu_cau', null, ['class' => 'form-control']) !!}
</div>

<!-- Dua Phuong An Dung Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dua_phuong_an_dung', 'Đưa phương án đúng (Tỷ trọng %)') !!}
    {!! Form::number('dua_phuong_an_dung', null, ['class' => 'form-control']) !!}
</div>

<!-- Dien Dat Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dien_dat', 'Diễn đạt (Tỷ trọng %)') !!}
    {!! Form::number('dien_dat', null, ['class' => 'form-control']) !!}
</div>

<!-- Thuyet Phuc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('thuyet_phuc', 'Thuyết phục (Tỷ trọng %)') !!}
    {!! Form::number('thuyet_phuc', null, ['class' => 'form-control']) !!}
</div>

<!-- Y Thuc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('y_thuc', 'Ý thức/Thái độ (Tỷ trọng %)') !!}
    {!! Form::number('y_thuc', null, ['class' => 'form-control']) !!}
</div>

<!-- Cam On Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cam_on', 'Cảm ơn/chào KH (Tỷ trọng %)') !!}
    {!! Form::number('cam_on', null, ['class' => 'form-control']) !!}
</div>

<!-- Ghi Nhan Thong Tin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ghi_nhan_thong_tin', 'Ghi nhận thông tin (Tỷ trọng %)') !!}
    {!! Form::number('ghi_nhan_thong_tin', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('requestTypes.index') !!}" class="btn btn-default">Hủy bỏ</a>
</div>
