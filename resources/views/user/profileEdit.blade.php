@extends('layouts.app')

@section('extents_css')
    <link rel="stylesheet" href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <style type="text/css">
        .table.border {
            border: 1px #999999 solid;
        }
        .table.bordered th, .table.bordered td {
            border: 1px #999999 solid;
            vertical-align: middle;
        }
        .table thead th, .table thead td {
            cursor: default;
            color: #52677a;
            border-color: transparent;
            text-align: left;
            font-style: normal;
            font-weight: 700;
            line-height: 100%;
        }
        .table th, .table td {
            padding: 0.625rem;
        }
        td, th {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Thông tin cá nhân</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <div class="row">
                        <form method="POST" action="{{ route('profile.update', $user->id) }}">
                            @csrf
                            <div class="form-group col-sm-6">
                                {!! Form::label('hoten', 'Họ tên') !!}
                                {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                            </div>

                            <!-- Tieu Chi Lon Field -->
                            <div class="form-group col-sm-12 col-lg-12">
                                {!! Form::label('phone', 'Số điện thoại') !!}
                                {!! Form::textarea('phone', $user->phone, ['class' => 'form-control', 'rows' => '2']) !!}
                            </div>

                            <!-- Tieu Chi Nho Field -->
                            <div class="form-group col-sm-12 col-lg-12">
                                {!! Form::label('Email', 'Email') !!}
                                {!! Form::textarea('email', $user->email, ['class' => 'form-control', 'rows' => '2']) !!}
                            </div>

                            <!-- Dat Neu Field -->
                            <div class="form-group col-sm-12 col-lg-12">
                                {!! Form::label('address', 'Địa chỉ') !!}
                                {!! Form::textarea('address', $user->address, ['class' => 'form-control', 'rows' => '2']) !!}
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

@section('extents_js')
    <link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"><script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#datepicker").datepicker({         
                autoclose: true,         
                todayHighlight: true 
            }).datepicker('update', new Date());

            $("#datepicker2").datepicker({         
                autoclose: true,         
                todayHighlight: true 
            }).datepicker('update', new Date());
            $("#select2_dienthoaivien").select2();
        })
    </script>
@endsection

