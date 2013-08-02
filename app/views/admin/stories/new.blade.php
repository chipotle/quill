@extends('layouts.admin')

@section('title') New Story @endsection

@section('content')

{{ Form::model($story, array('route' => 'sysop.stories.store')) }}

  {{ Form::label('title', 'Title') }}
  {{ Form::text('title', null, ['class' => 'input-xxlarge']) }}

  {{ Form::label('subhead', 'Subhead') }}
  {{ Form::text('subhead', null, ['class' => 'input-xxlarge', 'placeholder' => '(Optional)']) }}

  <div id="author-control" class="control-group">
    {{ Form::label('author', 'Author') }}
    {{ Form::text('author', null, ['class' => 'input-xxlarge', 'autocomplete' => 'off']) }} <a href='{{ URL::route("sysop.authors.create") }}' class="btn btn-success" target="_blank" title="Opens in new window/tab" style="margin-top:-10px;margin-left:1em;color:white"><i class="icon-plus icon-white"></i> New</a>
  </div>

  {{ Form::hidden('author_id', null, ['id' => 'author_id', 'data-return' => 'x']) }}

  {{ Form::label('slug', 'Slug (must be unique within issue)') }}
  {{ Form::text('slug', null, ['class'=>'input-xxlarge']) }}

  {{ Form::label('blurb', 'Blurb or Excerpt (Markdown)') }}
  {{ Form::textarea('blurb', null, ['class'=>'input-block-level']) }}

  {{ Form::label('body', 'Body (Markdown)') }}
  {{ Form::textarea('body', null, ['class'=>'input-block-level long']) }}

  <p>
    {{ Form::submit('Submit', ['class'=>'btn', 'id'=>'submit']) }}
    {{ HTML::linkRoute('sysop.pages.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
</p>
{{ Form::close() }}

@endsection

@section('scripts')
<script>
$(function() {
  $('#author').typeahead({
    source: function getTypeahead(query, process) {
      return $.get('/sysop/authors/search', { term: query }, function(data) {
        var keys = Object.keys(data);
        if (keys.length > 0) {
          $('#author_id').data('return', data);
        }
        return process(keys);
      });
    }
  });

  $('#author').on('blur', function() {
    var data = $('#author_id').data('return');
    var name = $('#author').val();
    if (data[name]) {
      $('#author_id').val(data[name]);
      $('#author-control').addClass('success');
      $('#author-control').removeClass('error');
    }
    else {
      $('#author_id').val('');
      $('#author-control').addClass('error');
      $('#author-control').removeClass('success');
    }
  });
});
</script>
@endsection

