<table class="table table-responsive" id="agents-table">
    <thead>
        <tr>
            <th>Doanh Số</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Số Diện Thoại</th>
            <th colspan="3">Hành động</th>
        </tr>
    </thead>
    <tbody>
    @foreach($agents as $agents)
        <tr>
            <td>{!! $agents->doanh_so !!}</td>
            <td>{!! $agents->ho_ten !!}</td>
            <td>{!! $agents->email !!}</td>
            <td>{!! $agents->so_dien_thoai !!}</td>
            <td>
                {!! Form::open(['route' => ['agents.destroy', $agents->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('agents.edit', [$agents->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Bạn có chắc chắn muốn xóa?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>