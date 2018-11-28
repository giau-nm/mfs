@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Chi tiết: Lỗi vi phạm
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($mistakes, ['route' => ['mistakes.update', $mistakes->id], 'method' => 'patch']) !!}

                        @include('mistakes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection