@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tạo mới: Điện thoại viên
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'agents.store']) !!}

                        @include('agents.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection