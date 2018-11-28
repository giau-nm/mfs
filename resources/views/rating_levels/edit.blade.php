@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Chi tiết: Mức xếp loại
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($ratingLevels, ['route' => ['ratingLevels.update', $ratingLevels->id], 'method' => 'patch']) !!}

                        @include('rating_levels.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection