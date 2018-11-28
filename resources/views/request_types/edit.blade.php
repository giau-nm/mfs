@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Request Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($requestType, ['route' => ['requestTypes.update', $requestType->id], 'method' => 'patch']) !!}

                        @include('request_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection