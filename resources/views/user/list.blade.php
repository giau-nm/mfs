@extends('layouts.app')


@section('content')
    <section class="content-header">
        <h1 class="pull-left">Danh sách tài khoản</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('account.create') !!}">Thêm mới</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Email đăng nhập</th>
                            <th>Nhóm tài khoản</th>
                            <th>Số điện thoại</th>
                            <th colspan="3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->nhom_tai_khoan !!}</td>
                            <td>{!! $user->so_dien_thoai !!}</td>
                            <td>
                                {!! Form::open(['route' => ['account.destroy', $user->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{!! route('account.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Bạn có chắc chắn muốn xóa??')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

@section('extents_js')
@endsection

