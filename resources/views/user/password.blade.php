@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Đổi mật khẩu</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <div class="row">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="form-group col-sm-6">
                                <label>Mật khẩu hiện tại</label>
                                <div class="input-control text full-size"><input type="password" name="currentPassword" value=""></div>
                            </div>

                            <!-- Tieu Chi Lon Field -->
                            <div class="form-group col-sm-12 col-lg-12">
                                <label>Mật khẩu mới</label>
                                <div class="input-control text full-size"><input type="password" name="newPassword" value=""></div>
                            </div>

                            <div class="form-group col-sm-12">
                                {!! Form::submit('Lưu', ['class' => 'btn btn-primary']) !!}
                            </div>

                        </form>
                    </div>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection


