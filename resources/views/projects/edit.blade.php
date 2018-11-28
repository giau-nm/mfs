<div class="modal-dialog">
    <div class="modal-content">
        {!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'patch', 'id' => 'form-update-project']) !!}
        <input type="hidden" name="id" value="{{ $project->id }}">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">{{ $pageTitle }}</h4>
        </div>
        <div class="modal-body">
            @include('projects.fields')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('label.common.btn_close')}}</button>
            <button type="submit" class="btn btn-danger" id="btn-update">{{ trans('label.common.btn_save')}}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>