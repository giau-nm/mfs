<div class="box-body table-responsive no-padding">
    <table class="table table-hover table-bordered" id="requests-table">
        <thead>
            <tr>
                @can('requestAdmin', \App\Models\Request::class)
                <th><a href="{{ $sortLinks['users.name']['url'] }}" data-url="{{ $sortLinks['users.name']['url'] }}" class="sort {{ $sortLinks['users.name']['class'] }}">@lang('request.lbl_column_username')</a></th>
                @endcan
                <th><a href="{{ $sortLinks['projects.name']['url'] }}" data-url="{{ $sortLinks['projects.name']['url'] }}" class="sort {{ $sortLinks['projects.name']['class'] }}">@lang('request.lbl_column_project_name')</a></th>
                <th><a href="{{ $sortLinks['devices.name']['url'] }}" data-url="{{ $sortLinks['devices.name']['url'] }}" class="sort {{ $sortLinks['devices.name']['class'] }}">@lang('request.lbl_column_device_name')</a></th>
                <th><a href="{{ $sortLinks['is_long_time']['url'] }}" data-url="{{ $sortLinks['is_long_time']['url'] }}" class="sort {{ $sortLinks['is_long_time']['class'] }}">@lang('request.lbl_column_is_long_time')</a></th>
                <th><a href="{{ $sortLinks['start_time']['url'] }}" data-url="{{ $sortLinks['start_time']['url'] }}" class="sort {{ $sortLinks['start_time']['class'] }}">@lang('request.lbl_column_start_time')</a></th>
                <th><a href="{{ $sortLinks['end_time']['url'] }}" data-url="{{ $sortLinks['end_time']['url'] }}" class="sort {{ $sortLinks['end_time']['class'] }}">@lang('request.lbl_column_end_time')</a></th>
                <th><a href="{{ $sortLinks['requests.status']['url'] }}" data-url="{{ $sortLinks['requests.status']['url'] }}" class="sort {{ $sortLinks['requests.status']['class'] }}">@lang('request.lbl_column_status')</a></th>
                @can('requestAdmin', \App\Models\Request::class)
                <th>@lang('label.devices.lbl_approve') | @lang('label.devices.lbl_reject')</th>
                @endcan
                <th>@lang('label.common.lbl_action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach($requests as $request)
            @include('requests.table_row', ['request' => $request])
        @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="request-modal-change-status" method="PUT">
        <div class="modal-dialog">
            <div class="modal-content" id="request-modal-change-status-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('label.common.lbl_change_status') }}</h4>
                </div>
                <div class="modal-body">
                    <div id="request-modal-display-fail" class="row" style="padding-top: 10px; display: none">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4 id="request-modal-display-fail-content"><i class="icon fa fa-ban"></i></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-3">
                            <button type="button" class="btn request-btn-change-status" id="request-btn-approve" data-status="{!! STATUS_REQUEST_ACCEPT !!}" data-class-after="btn-success" data-class-before="btn-success btn-primary">@lang('label.devices.lbl_approve')</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn request-btn-change-status" id="request-btn-reject" data-status="{!! STATUS_REQUEST_REJECT !!}" data-class-after="btn-danger" data-class-before="btn-danger btn-primary">@lang('label.devices.lbl_reject')</button>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            <button type="button" class="btn request-btn-change-status" id="request-btn-paid" data-status="{!! STATUS_REQUEST_PAID !!}" data-class-after="btn-primary" data-class-before="btn-primary">@lang('label.devices.lbl_paid')</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">@lang('label.common.btn_close')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('request.deleteRequest') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('request.confirmDeleteRequest') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('label.common.btn_close')</button>
                    <button type="button" class="btn btn-danger" id="btn-delete">@lang('label.common.btn_delete')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="box-footer clearfix">
    {!! $requests->links('pagging.default')!!}
</div>