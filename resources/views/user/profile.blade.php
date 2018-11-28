@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')

@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $pageTitle }}
            </h1>
            {!! Breadcrumb::render('profile', $user) !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>

            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="{{request()->session()->get('avatar')}}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $user->name}}</h3>
                            <p class="text-muted text-center">{{ $user->email}}</p>
                            <p class="text-muted text-center" id="profile-chatwork-id">{!! is_null($user->chatwork_id) ? trans('profile.fill_chatwork_id') : trans('profile.chatwork_id') . ': ' . $user->chatwork_id !!}</p>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>@lang('label.users.lbl_total_devices')</b>
                                    <a class="pull-right">{{ number_format($allDevices->total(), 0, ',', ' ') }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>@lang('label.users.lbl_total_devices_expired')</b>
                                    <a class="pull-right">{{ number_format($allDevicesExpired->total(), 0, ',', ' ') }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>@lang('label.users.lbl_total_devices_requesting')</b>
                                    <a class="pull-right">{{ number_format($allRequests->total(), 0, ',', ' ') }}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        @php
                            $firstTab = false;
                            if (is_null(app('request')->input(KEY_PAGINATE_ALL_DEVICE)) && is_null(app('request')->input(KEY_PAGINATE_ALL_DEVICE_EXPIRED)) && is_null(app('request')->input(KEY_PAGINATE_ALL_REQUESTING))) {
                                $firstTab = true;
                            }
                        @endphp
                        <ul class="nav nav-tabs">
                            <li class="@if(!is_null(app('request')->input(KEY_PAGINATE_ALL_DEVICE)) || $firstTab) {{ 'active'}} @endif">
                                <a href="#all-devices" data-toggle="tab">@lang('label.users.lbl_tab_devices')</a>
                            </li>
                            <li class="@if(!is_null(app('request')->input(KEY_PAGINATE_ALL_DEVICE_EXPIRED))) {{ 'active'}} @endif">
                                <a href="#devices-expried" data-toggle="tab">@lang('label.users.lbl_tab_devices_expired')</a>
                            </li>
                            <li class="@if(!is_null(app('request')->input(KEY_PAGINATE_ALL_REQUESTING))) {{ 'active'}} @endif">
                                <a href="#all-requests" data-toggle="tab">@lang('label.users.lbl_tab_devices_requesting')</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane @if(!is_null(app('request')->input(KEY_PAGINATE_ALL_DEVICE)) || $firstTab) {{ 'active'}} @endif" id="all-devices">
                                @if($allDevices->count())
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover table-bordered table-sorter">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('label.devices.lbl_column_id') }}</th>
                                                <th>{{ trans('label.devices.lbl_column_name') }}</th>
                                                <th>{{ trans('label.devices.lbl_column_code') }}</th>
                                                <th>@lang('label.common.lbl_status')</th>
                                                <th>@lang('label.common.lbl_created_at')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allDevices as $request)
                                            <tr>
                                                <td>{!! $request->id !!}</td>
                                                <td>{!! $request->device_name !!}</td>
                                                <td>{!! $request->device_code !!}</td>
                                                <td>{!! $request->getStatusText() !!}</td>
                                                <td>{!! $request->created_at !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    {!! $allDevices->links('pagging.default')!!}
                                </div>
                                @else
                                <p>@lang('label.users.msg_not_found_devices')</p>
                                @endif
                            </div>
                            <div class="tab-pane @if(!is_null(app('request')->input(KEY_PAGINATE_ALL_DEVICE_EXPIRED))) {{ 'active'}} @endif" id="devices-expried">
                                @if($allDevicesExpired->count())
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover table-bordered table-sorter">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('label.devices.lbl_column_id') }}</th>
                                                <th>{{ trans('label.devices.lbl_column_name') }}</th>
                                                <th>{{ trans('label.devices.lbl_column_code') }}</th>
                                                <th>@lang('label.common.lbl_status')</th>
                                                <th>@lang('label.common.lbl_created_at')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allDevicesExpired as $requestExpired)
                                            <tr>
                                                <td>{!! $requestExpired->id !!}</td>
                                                <td>{!! $requestExpired->device_name !!}</td>
                                                <td>{!! $requestExpired->device_code !!}</td>
                                                <td>{!! $requestExpired->getStatusText() !!}</td>
                                                <td>{!! $requestExpired->created_at !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    {!! $allDevicesExpired->links('pagging.default')!!}
                                </div>
                                @else
                                <p>@lang('label.users.msg_not_found_devices_expired')</p>
                                @endif
                            </div>
                            <div class="tab-pane @if(!is_null(app('request')->input(KEY_PAGINATE_ALL_REQUESTING))) {{ 'active'}} @endif" id="all-requests">
                                @if ($allRequests->count())
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover table-bordered table-sorter">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('label.devices.lbl_column_id') }}</th>
                                                <th>{{ trans('label.devices.lbl_column_name') }}</th>
                                                <th>{{ trans('label.devices.lbl_column_code') }}</th>
                                                <th>@lang('label.common.lbl_status')</th>
                                                <th>@lang('label.common.lbl_created_at')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allRequests as $item)
                                            <tr>
                                                <td>{!! $item->id !!}</td>
                                                <td>{!! $item->device_name !!}</td>
                                                <td>{!! $item->device_code !!}</td>
                                                <td>{!! $item->getStatusText() !!}</td>
                                                <td>{!! $item->created_at !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    {!! $allRequests->links('pagging.default')!!}
                                </div>
                                @else
                                <p>@lang('label.users.msg_not_found_devices_requesting')</p>
                                @endif
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="profile-modal-chatwork-id">
        <div class="modal-dialog">
            <div class="modal-content" id="profile-modal-chatwork-id-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('profile.label_change_chatwork_id') }}</h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="chatwork-id" placeholder="Nhập chatwork ID" value="{!! $user->chatwork_id !!}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('label.common.btn_close')</button>
                    <button type="button" data-url="{!! route('users.change_cw_id') !!}" method="POST" class="btn btn-primary" id="profile-modal-change-chatworkid-btnsave">@lang('label.common.btn_save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extents_js')
    <script src="{{ url('js/profile/profile.js') }}"></script>
@endsection