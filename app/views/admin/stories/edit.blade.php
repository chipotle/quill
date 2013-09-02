@extends('layouts.admin')

@section('title') Edit Story @endsection

@section('content')

{{ Form::model($story, array('route' => ['sysop.stories.update', $story->id], 'method' => 'put')) }}

  {{ Form::label('title', 'Title') }}
  {{ Form::text('title', null, ['id'=>'title', 'class' => 'input-xxlarge']) }}

  {{ Form::label('subhead', 'Subhead') }}
  {{ Form::text('subhead', null, ['class' => 'input-xxlarge', 'placeholder' => '(Optional)']) }}

  <p>Author<br>
    <a href="{{ URL::route('sysop.authors.edit', [$story->author->id]) }}" title="Author Record"><strong>{{ $story->author->name }}</strong> <i class="icon-circle-arrow-right"></i></a>
  </p>

  {{ Form::label('slug', 'Slug (must be unique within issue)') }}
  {{ Form::text('slug', null, ['id'=>'slug', 'class'=>'input-xxlarge']) }}

  {{ Form::label('blurb', 'Blurb or Excerpt (Markdown)') }}
  {{ Form::textarea('blurb', null, ['class'=>'input-block-level']) }}

  {{ Form::label('body', 'Body (Markdown)') }}
  {{ Form::textarea('body', null, ['class'=>'input-block-level long']) }}

  <p>
    {{ Form::submit('Submit', ['class'=>'btn', 'id'=>'submit']) }}
    {{ HTML::linkRoute('sysop.stories.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
</p>
{{ Form::close() }}

@endsection

@section('scripts')
<script>
$(function() {
  $('#title').on('blur', function() {
    var title = $('#title').val();
    var slug = $('#slug').val();
    if (title.length > 0 && slug.length == 0) {
      $('#slug').val(makeSlug(title));
    }
  })

});
</script>
@endsection
