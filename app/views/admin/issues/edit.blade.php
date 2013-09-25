@extends('layouts.admin')

@section('title') Edit Issue @endsection

@section('content')

{{ Form::model($issue, ['method' => 'put', 'route' => ['sysop.issues.update', $issue->id], 'class' => 'form-horizontal']) }}

<div class="control-group">
  <label for="is_published" class="control-label">Published?</label>
  <div class="controls">
    {{ Form::checkbox('is_published') }}
  </div>
</div>

<div class="control-group">
  <label for="number" class="control-label">Number</label>
  <div class="controls">{{ Form::text('number', null, ['class' => 'input-mini']) }}</div>
</div>

<div class="control-group">
  <label for="title" class="control-label">Title</label>
  <div class="controls">{{ Form::text('title', null, ['class' => 'input-xxlarge', 'placeholder' => '(Optional)']) }}</div>
</div>


<div class="control-group">
  <label for="pub_date" class="control-label">Publication Date</label>
  <div class="controls">{{ Form::text('pub_date', $issue->pub_date->toDateString(), ['class' => 'input-small', 'placeholder' => 'YYYY-MM-DD']) }}</div>
</div>

<p>
  {{ Form::submit('Submit', ['class'=>'btn', 'id'=>'submit']) }}
  {{ HTML::linkRoute('sysop.issues.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
</p>

{{ Form::close() }}
@endsection
