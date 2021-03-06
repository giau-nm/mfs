<table class="table table-responsive" id="results-table">
    <thead>
        <tr>
            <th>Mã</th>
            <th>Tên</th>
            <th>Mo Ta</th>
            <th colspan="3">Hành động</th>
        </tr>
    </thead>
    <tbody>
    @foreach($results as $results)
        <tr>
            <td>{!! $results->ma !!}</td>
            <td>{!! $results->ten !!}</td>
            <td>{!! $results->mo_ta !!}</td>
            <td>
                {!! Form::open(['route' => ['results.destroy', $results->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('results.edit', [$results->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Bạn có chắc chắn muốn xóa?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>