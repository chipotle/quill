@extends('layouts.admin')

@section('title'){{ $title }}@endsection

@section('content')

{{ Form::model($page, ['url' => $url, 'method' => $method]) }}

<label class="checkbox pull-right">
  {{ Form::checkbox('is_visible') }} Visible (Published)
</label>

{{ Form::label('title', 'Page Title') }}
{{ Form::text('title', null, ['class'=>'input-xxlarge', 'style'=>'font-size:150%']) }}

{{ Form::label('slug', 'URL (slug)') }}
{{ Form::text('slug', null, ['class'=>'input-xxlarge']) }}

{{ Form::label('body', 'Body (Markdown)') }}
{{ Form::textarea('body', null, ['class'=>'input-block-level', 'rows'=>20]) }}

{{ Form::label('head', 'Extra HTML for <head>') }}
{{ Form::textarea('head', null, ['class'=>'input-block-level']) }}

<p>
  {{ Form::submit('Submit', ['class'=>'btn']) }}
  {{ Html::linkRoute('sysop.pages.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
</p>

{{ Form::close() }}
@endsection
