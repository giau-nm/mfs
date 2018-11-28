<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{ trans('request.requestDetail') }}</h4>
        </div>
        <div class="modal-body col-mb-20">
            <div class="row">
                <div class="col-md-3">
                    {{ trans('request.lbl_column_username') }}:
                </div>
                <div class="col-md-3">
                    {{ $request->userWithTrashed ? $request->userWithTrashed->name : null }}
                </div>
                <div class="col-md-3">
                    {{ trans('request.lbl_column_project_name') }}:
                </div>
                <div class="col-md-3">
                    {{ $request->projectWithTrashed ? $request->projectWithTrashed->name : null}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('request.lbl_column_device_name') }}:
                </div>
                <div class="col-md-3">
                    {{ $request->deviceWithTrashed ? $request->deviceWithTrashed->name : null }}
                </div>
                <div class="col-md-3">
                    {{ trans('request.lbl_column_status') }}:
                </div>
                <div class="col-md-3">
                    {!! $request->getStatusText() !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('request.lbl_column_is_long_time') }}:
                </div>
                <div class="col-md-3">
                    {{ $request->getLongTimeText() }}
                </div>
                <div class="col-md-3">
                    {{ trans('request.lbl_column_start_time') }}:
                </div>
                <div class="col-md-3">
                    {{ $request->start_time->format('Y-m-d') }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('request.lbl_column_end_time') }}:
                </div>
                <div class="col-md-3">
                    {{ $request->end_time->format('Y-m-d') }}
                </div>
                <div class="col-md-3">
                    {{ trans('request.lbl_column_actual_start_time') }}:
                </div>
                <div class="col-md-3">
                    @if (isset($request->actual_start_time)) {{ $request->actual_start_time->format('Y-m-d') }} @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    {{ trans('request.lbl_column_actual_end_time') }}:
                </div>
                <div class="col-md-3">
                    @if (isset($request->actual_end_time)) {{ $request->actual_end_time->format('Y-m-d') }} @endif
                </div>
                <div class="col-md-3">
                    {{ trans('request.lbl_column_note') }}:
                </div>
                <div class="col-md-3">
                    {{ $request->note }}
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('label.common.btn_close')}}</button>
        </div>
    </div>
</div>
