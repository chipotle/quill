@extends('layouts.admin')

@section('title') Pitch #{{ $pitch->id }} @endsection

@section('content')

{{ Form::model($pitch, ['route' => ['sysop.pitches.update', $pitch->id], 'method' => 'put']) }}

{{ Form::label('name', 'From') }}
{{ Form::text('name') }}

{{ Form::label('email', 'Email') }}
{{ Form::email('email') }}

{{ Form::label('status', 'Submission Status') }}
{{ Form::select('status', $menu) }}

{{ Form::label('blurb', 'The Pitch') }}
{{ Form::textarea('blurb', null, ['class'=>'input-block-level', 'rows'=>15]) }}

{{ Form::label('notes', 'Editorial Notes') }}
{{ Form::textarea('notes', null, ['class'=>'input-block-level', 'rows'=>10]) }}

<p><em>To Do: link author_id and story_id up here</em></p>

<p>
  {{ Form::submit('Update', ['class'=>'btn btn-primary']) }}
  {{ Html::linkRoute('sysop.pitches.index', 'Back', null, ['class'=>'btn'])}}
</p>

{{ Form::close() }}
@endsection
