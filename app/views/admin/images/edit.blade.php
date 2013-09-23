@extends('layouts.admin')

@section('title') Edit Image @endsection

@section('content')

<p><strong>Current file:</strong> {{ $image->name }}</p>

<p><img src="{{ $image->getFileURL() }}" alt="{{ $image->alt_text }}"></p>

{{ Form::open(['route' => ['sysop.images.update', $image->id], 'files' => true, 'method' => 'put']) }}

  <div>
    {{ Form::label('file', 'Replacement file:') }}
    {{ Form::file('file') }}
  </div>

  <div>
    {{ Form::label('params[caption]', 'Caption:') }}
    {{ Form::text('params[caption]', $image->caption, ['placeholder'=>'optional']) }}
  </div>

  <div>
    {{ Form::label('params[alt_text]', 'Alternate Text:') }}
    {{ Form::text('params[alt_text]', $image->alt_text, ['placeholder'=>'optional']) }}
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
