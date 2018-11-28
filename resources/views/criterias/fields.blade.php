<!-- Ma Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ma', 'Mã:') !!}
    {!! Form::text('ma', null, ['class' => 'form-control']) !!}
</div>

<!-- Tieu Chi Lon Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('tieu_chi_lon', 'Tiêu chí lớn:') !!}
    {!! Form::textarea('tieu_chi_lon', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<!-- Tieu Chi Nho Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('tieu_chi_nho', 'Tiêu chí nhỏ:') !!}
    {!! Form::textarea('tieu_chi_nho', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<!-- Dat Neu Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('dat_neu', 'Đạt nếu:') !!}
    {!! Form::textarea('dat_neu', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<!-- So Diem Duoc Neu Dat Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('so_diem_duoc_neu_dat', 'Số điểm được nếu đạt') !!}
    {!! Form::select('so_diem_duoc_neu_dat', array(
        'Toàn bộ điểm của tiêu chí' => 'Toàn bộ điểm của tiêu chí',
        'Toàn bộ điểm cuộc gọi' => 'Toàn bộ điểm cuộc gọi',
        'Không có điểm' => 'Không có điểm',
        ), null, ['class' => 'form-control']) !!}
</div>

<!-- Khong Dat Neu Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('khong_dat_neu', 'Không đạt nếu') !!}
    {!! Form::textarea('khong_dat_neu', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<!-- So Diem Mat Neu Khong Dat Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('so_diem_mat_neu_khong_dat', 'Số điểm mất nếu không đạt') !!}
    {!! Form::select('so_diem_mat_neu_khong_dat', array(
        'Toàn bộ điểm của tiêu chí' => 'Toàn bộ điểm của tiêu chí',
        'Toàn bộ điểm cuộc gọi' => 'Toàn bộ điểm cuộc gọi',
        'Không có điểm' => 'Không có điểm',
        ), null, ['class' => 'form-control']) !!}
</div>

<!-- Mac Loi Nghiem Trong Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('mac_loi_nghiem_trong', 'Mắc lỗi nghiêm trọng nếu') !!}
    {!! Form::textarea('mac_loi_nghiem_trong', null, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<!-- So Diem Mat Neu Mac Loi Nghiem Trong Field -->
<div class="form-group col-sm-6">
    {!! Form::label('so_diem_mat_neu_mac_loi_nghiem_trong', 'Số điểm mất nếu mắc lỗi nghiêm trọng') !!}
    {!! Form::select('so_diem_mat_neu_mac_loi_nghiem_trong', array(
        'Toàn bộ điểm của tiêu chí' => 'Toàn bộ điểm của tiêu chí',
        'Toàn bộ điểm cuộc gọi' => 'Toàn bộ điểm cuộc gọi',
        'Không có điểm' => 'Không có điểm',
        ), null, ['class' => 'form-control']) !!}

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('criterias.index') !!}" class="btn btn-default">Cancel</a>
</div>
