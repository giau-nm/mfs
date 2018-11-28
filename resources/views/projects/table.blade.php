<table class="table table-responsive" id="projects-table">
    <thead>
        <tr>
            <th>{{ trans('project.projectName') }}</th>
            <th>{{ trans('project.manager') }}</th>
            <th>{{ trans('project.action') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($projects as $project)
        <tr data-id="{{ $project->id }}">
            <td>{!! $project->name !!}</td>
            <td>{!! $project->projectManagerName() !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('projects.edit', [$project->id]) !!}" class='btn btn-default btn-xs item-edit-project'><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="{{route('projects.destroy', $project->id)}}" class="btn btn-danger btn-xs btn-delete-item"><i class="glyphicon glyphicon-trash"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>