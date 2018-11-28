@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tiêu chí đánh giá cuộc gọi
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($criterias, ['route' => ['criterias.update', $criterias->id], 'method' => 'patch']) !!}

                        @include('criterias.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection