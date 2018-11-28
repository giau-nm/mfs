<table class="table table-responsive" id="workgroups-table">
    <thead>
        <tr>
            <th>Tên</th>
            <th>Tiêu Dề</th>
            <th>Mô Tả</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($workgroups as $workgroups)
        <tr>
            <td>{!! $workgroups->ten !!}</td>
            <td>{!! $workgroups->tieu_de !!}</td>
            <td>{!! $workgroups->mo_ta !!}</td>
            <td>
                {!! Form::open(['route' => ['workgroups.destroy', $workgroups->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('workgroups.edit', [$workgroups->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Bạn có chắc chắn muốn xóa?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>