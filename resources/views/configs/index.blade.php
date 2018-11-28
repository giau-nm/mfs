@extends('layouts.master')
@section('page_title', $pageTitle)
@section('extents_css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {!! $pageTitle !!}
            </h1>
            {!! Breadcrumb::render('configs') !!}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="clearfix"></div>
            @include('flash::message')
            <div class="alert alert-success none"></div>
            <div class="clearfix"></div>
            <!-- /.row -->
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ $pageTitle }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="col-md-4">
                            {!! Form::open(['route' => ['configs.update', $config->id], 'method' => 'PUT', 'id' => 'form-update', 'style' => 'padding:10px']) !!}
                            <div class="form-group">
                                <label>{!! trans('label.configs.chatowk_token') !!}</label>
                                <input type="text" class="form-control" placeholder="{!! trans('label.configs.enter_chatwork_token') !!}" name="chatwork_token" value="{!! $config->chatwork_token !!}">
                            </div>

                            <div class="form-group">
                                <label>{!! trans('label.configs.chatwork_room_id') !!}</label>
                                <input type="text" class="form-control" placeholder="{!! trans('label.configs.enter_chatwork_room_id') !!}" name="chatwork_room_id" value="{!! $config->chatwork_room_id !!}">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">{!! trans('label.common.btn_save') !!}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-8">
                            <div class="modal-content" style="top: 20px">
                                <div class="modal-body">
                                    <div id="user-permission-display-success" class="row" style="padding-top: 10px; display: none">
                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-check"></i>{!! trans('label.common.lbl_update_success')!!}</h4>
                                        </div>
                                    </div>
                                    <div id="user-permission-display-fail" class="row" style="padding-top: 10px; display: none">
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-ban"></i>{!! trans('label.common.lbl_update_fail')!!}</h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5">
                                            <b>{!! trans('label.common.lbl_normal_user') !!}</b>
                                            {!! Form::select('user-permission', $listNormalUser, null, [
                                                'class' => 'form-control',
                                                'name'  => 'from[]',
                                                'size'  => '12',
                                                'multiple' => 'multiple',
                                                'id'    => 'user-permission',
                                                'action' => route('users.postChangeUserPermission'),
                                                'method' => 'POST',
                                                'data-waiting-text' => trans('label.common.lbl_updating')
                                            ]) !!}
                                        </div>

                                        <div class="col-sm-2" style="padding-top: 20px">
                                            <button type="button" id="user-permission_undo" class="btn btn-primary btn-block">{!! trans('label.common.btn_undo') !!}</button>
                                            <button type="button" id="user-permission_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                            <button type="button" id="user-permission_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                            <button type="button" id="user-permission_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                            <button type="button" id="user-permission_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                            <button type="button" id="user-permission_redo" class="btn btn-warning btn-block">{!! trans('label.common.btn_redo') !!}</button>
                                        </div>

                                        <div class="col-sm-5">
                                            <b>{!! trans('label.common.lbl_admin_user') !!}</b>
                                            {!! Form::select('user-permission_to', $listAdminlUser, null, [
                                                'class' => 'form-control',
                                                'name'  => 'to[]',
                                                'size'  => '12',
                                                'multiple' => 'multiple',
                                                'id'    => 'user-permission_to'
                                            ]) !!}

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('label.common.btn_close')</button>
                                </div>
                            </div>
                                <!-- /.modal-content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('extents_js')
    <script src="{{ url('js/config/config.js') }}"></script>
@endsection

