<table class="table table-responsive" id="ratingLevels-table">
    <thead>
        <tr>
            <th>Mã</th>
            <th>Tên</th>
            <th>Điểm từ</th>
            <th>Điểm đến</th>
            <th>Mô tả</th>
            <th colspan="3">Hành động</th>
        </tr>
    </thead>
    <tbody>
    @foreach($ratingLevels as $ratingLevels)
        <tr>
            <td>{!! $ratingLevels->ma !!}</td>
            <td>{!! $ratingLevels->ten !!}</td>
            <td>{!! $ratingLevels->diem_tu !!}</td>
            <td>{!! $ratingLevels->diem_den !!}</td>
            <td>{!! $ratingLevels->mo_ta !!}</td>
            <td>
                {!! Form::open(['route' => ['ratingLevels.destroy', $ratingLevels->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ratingLevels.edit', [$ratingLevels->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Bạn có chắc chắn muốn xóa?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>