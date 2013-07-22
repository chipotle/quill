@extends('layouts.admin')

@section('title') New Author @endsection

@section('content')

{{ Form::model($author, array('route' => 'sysop.authors.update')) }}
  <div>
    {{ Form::label('name', 'Name:') }}
    {{ Form::text('name') }}
  </div>

  <div>
    {{ Form::label('nickname', 'Nickname:') }}
    {{ Form::text('nickname', null, ['placeholder' => '(Optional)']) }}
  </div>

  <div>
    <label class="radio inline">
      {{ Form::radio('show', Author::SHOW_NAME) }}
      Show name
    </label>
    <label class="radio inline">
      {{ Form::radio('show', Author::SHOW_NICK) }}
      Show nickname
    </label>
    <label class="radio inline">
      {{ Form::radio('show', Author::SHOW_BOTH) }}
      Show both
    </label>
  </div>
  <br>

  <div>
    {{ Form::label('email', 'Email:') }}
    {{ Form::email('email') }}
  </div>

  <div>
    {{ Form::label('website', 'Website:') }}
    {{ Form::input('url', 'website', null, ['placeholder' => '(Optional)']) }}
  </div>

  <div>
    {{ Form::label('twitter', 'Twitter:') }}
    {{ Form::text('twitter', null, ['placeholder' => '(Optional)']) }}
  </div>

  <div>
    {{ Form::label('bio', 'Bio:') }}
    {{ Form::textarea('bio', null, ['class' => 'input-xxlarge']) }}
  </div>

  <div>
    {{ Form::label('user_id', 'Existing Quill User?') }}
    {{ Form::select('user_id', $users) }}
  </div>

  <div>
      {{ Form::submit('Submit', ['class'=>'btn', 'id'=>'submit']) }}
      {{ HTML::linkRoute('sysop.authors.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
  </div>
{{ Form::close() }}

@endsection
