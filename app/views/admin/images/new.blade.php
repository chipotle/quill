@extends('layouts.admin')

@section('title') New Image @endsection

@section('content')

{{ Form::open(['route' => 'sysop.images.store', 'files' => true]) }}

  <div>
    {{ Form::label('file', 'File:') }}
    {{ Form::file('file') }}
  </div>

  <div>
    {{ Form::label('params[caption]', 'Caption:') }}
    {{ Form::text('params[caption]', null, ['placeholder'=>'optional']) }}
  </div>

  <div>
    {{ Form::label('params[alt_text]', 'Alternate Text:') }}
    {{ Form::text('params[alt_text]', null, ['placeholder'=>'optional']) }}
  </div>

  <label class="checkbox" for="params[make_thumb]">
    {{ Form::checkbox('params[make_thumb]') }} Make thumbnail?
  </label>

  <label class="checkbox" for="params[make_retina]">
    {{ Form::checkbox('params[make_retina]') }} Process as double-sized 'retina' image?
  </label>

  <p>&nbsp;</p>

  <div>
      {{ Form::submit('Submit', ['class'=>'btn', 'id'=>'submit']) }}
      {{ HTML::linkRoute('sysop.images.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
  </div>
{{ Form::close() }}

@endsection
