@extends('layouts.admin')

@section('title') New Page @endsection

@section('content')

{{ Form::model($page, ['method' => 'post', 'route' => ['sysop.pages.update', $page->id], 'method' => 'put']) }}

<label class="checkbox pull-right">
  {{ Form::checkbox('is_visible') }} Visible (Published)
</label>

{{ Form::label('title', 'Page Title') }}
{{ Form::text('title', null, ['class'=>'input-xxlarge', 'style'=>'font-size:150%']) }}

{{ Form::label('slug', 'URL (slug)') }}
{{ Form::text('slug', null, ['class'=>'input-xxlarge']) }}

{{ Form::label('body', 'Body (Markdown)') }}

{{ Form::textarea('body', null, ['class'=>'input-block-level long']) }}

{{ Form::label('head', 'Extra HTML for <head>') }}
{{ Form::textarea('head', null, ['class'=>'input-block-level']) }}

<p>
  {{ Form::submit('Submit', ['class'=>'btn', 'id'=>'submit']) }}
  {{ HTML::linkRoute('sysop.pages.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
</p>

{{ Form::close() }}

@endsection
