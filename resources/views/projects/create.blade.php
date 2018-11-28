<div class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(['route' => 'projects.store', 'method' => 'POST', 'id' => 'form-add-project']) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">{{ trans('request.addNew') }}</h4>
        </div>
        <div class="modal-body">
            @include('projects.fields')
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('label.common.btn_close')}}</button>
            <button type="submit" class="btn btn-danger" id="btn-add">{{ trans('label.common.btn_add_new')}}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>