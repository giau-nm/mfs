@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Chi tiết: Nhóm điện thoại viên
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($workgroups, ['route' => ['workgroups.update', $workgroups->id], 'method' => 'patch']) !!}

                        @include('workgroups.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection