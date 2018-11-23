@extends('layouts.app')

@section('content')
    <div data-reactroot="">
        <h1><a href="/" class="nav-button transform" title="Quay lại trang chủ."><span></span></a><!-- react-text: 5 -->Thông tin cá nhân
        </h1>
        <hr>
        <div class="flex-grid">
            <form method="POST" action="{{ route('profile.update', $user->id) }}">
                @csrf
                <div class="row">
                    <div class="cell size4">
                        <div><label>Họ tên</label>
                            <div><small class=""></small></div>
                            <div class="input-control text full-size">
                                <input type="text" name="name" value="{{ $user->name  }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="cell size4">
                        <div><label>Số điện thoại</label>
                            <div><small class=""></small></div>
                            <div class="input-control text full-size">
                                <input type="text" name="phone" value="{{ $user->phone  }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="cell size4">
                        <div><label>Email</label>
                            <div><small class=""></small></div>
                            <div class="input-control text full-size">
                                <input type="text" name="email" value="{{ $user->email  }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="cell size4">
                        <div><label>Địa chỉ</label>
                            <div><small class=""></small></div>
                            <div class="input-control text full-size">
                                <input type="text" name="address" value="{{ $user->address  }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="cell size4">
                        <button class="button fg-white bg-green" type="submit">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('footer_scripts')

@endsection
