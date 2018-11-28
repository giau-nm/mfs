<table class="table table-responsive" id="requestTypes-table">
    <thead>
        <tr>
            <th>Mã</th>
            <th>Tiêu đề</th>
            <th>Mô tả</th>
            <th colspan="3">Hành động</th>
        </tr>
    </thead>
    <tbody>
    @foreach($requestTypes as $requestType)
        <tr>
            <td>{!! $requestType->ma !!}</td>
            <td>{!! $requestType->tieu_de !!}</td>
            <td>{!! $requestType->mo_ta !!}</td>
            <td>
                {!! Form::open(['route' => ['requestTypes.destroy', $requestType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('requestTypes.edit', [$requestType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>