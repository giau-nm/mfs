<table class="table table-responsive" id="criterias-table">
    <thead>
        <tr>
            <th>Thứ tự</th>
            <th>mã</th>
            <th>Tiêu chí lớn</th>
            <th>Tiêu chí nhỏ</th>
            <th colspan="3">Hành động</th>
        </tr>
    </thead>
    <tbody>
    @foreach($criterias as $criterias)
        <tr>
            <td>{!! $criterias->id !!}</td>
            <td>{!! $criterias->ma !!}</td>
            <td>{!! $criterias->tieu_chi_lon !!}</td>
            <td>{!! $criterias->tieu_chi_nho !!}</td>
            <td>
                {!! Form::open(['route' => ['criterias.destroy', $criterias->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('criterias.edit', [$criterias->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>