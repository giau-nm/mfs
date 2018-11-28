<tr class="added" data-id="{{ $project->id }}">
    <td>{!! $project->name !!}</td>
    <td>{!! $project->projectManagerName() !!}</td>
    <td>
        {!! Form::open(['route' => ['projects.destroy', $project->id], 'method' => 'delete']) !!}
        <div class='btn-group'>
            <a href="{!! route('projects.edit', [$project->id]) !!}" class='btn btn-default btn-xs item-edit-project'><i class="glyphicon glyphicon-edit"></i></a>
            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('" . trans('project.confirm_delete') . "')"]) !!}
        </div>
        {!! Form::close() !!}
    </td>
</tr>