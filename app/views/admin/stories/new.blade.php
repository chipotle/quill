@extends('layouts.admin')

@section('title') New Story @endsection

@section('content')

{{ Form::model($story, array('route' => 'sysop.stories.store')) }}

  {{ Form::label('title', 'Title') }}
  {{ Form::text('title', null, ['id'=>'title', 'class' => 'input-xxlarge']) }}

  {{ Form::label('subhead', 'Subhead') }}
  {{ Form::text('subhead', null, ['class' => 'input-xxlarge', 'placeholder' => '(Optional)']) }}

  <div id="author-control" class="control-group">
    {{ Form::label('author', 'Author') }}
    @if ($author_name)
    {{ Form::text('author', $author_name, ['class' => 'input-xxlarge disabled', 'autocomplete' => 'off', 'disabled'=>true]) }}
    @else
    {{ Form::text('author', null, ['class' => 'input-xxlarge', 'autocomplete' => 'off']) }} <a href='{{ URL::route("sysop.authors.create") }}' class="btn btn-success buttonfix" target="_blank" title="Opens in new window/tab" style="color:white"><i class="icon-plus icon-white"></i> New</a>
    @endif
  </div>

  {{ Form::hidden('author_id', null, ['id' => 'author_id', 'data-return' => 'x']) }}

  {{ Form::label('slug', 'Slug (must be unique within issue)') }}
  {{ Form::text('slug', null, ['id'=>'slug', 'class'=>'input-xxlarge']) }}

  {{ Form::label('blurb', 'Blurb or Excerpt (Markdown)') }}
  {{ Form::textarea('blurb', null, ['class'=>'input-block-level']) }}

  {{ Form::label('body', 'Body (Markdown)') }}
  {{ Form::textarea('body', null, ['class'=>'input-block-level long']) }}

  <p>
    {{ Form::submit('Submit', ['class'=>'btn', 'id'=>'submit']) }}
    @if ($author_name)
    {{ HTML::linkRoute('sysop.authors.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
    @else
    {{ HTML::linkRoute('sysop.stories.index', 'Cancel', null, ['class'=>'btn btn-danger'])}}
    @endif
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

  $('#title').on('blur', function() {
    var title = $('#title').val();
    if (title.length > 0) {
      $('#slug').val(makeSlug(title));
    }
  })

});

function makeSlug(slug) {
  slug = slug.toLowerCase().replace(/\ba\b/g, '').replace(/\bthe\b/g, '').trim();
  slug = slug.replace(/\s+/g, '-').replace('/_/g', '-').replace(/[^a-z0-9-]/g, '');
  slug = slug.replace(/-{2,}/g, '-');
  return slug;
}
</script>
@endsection
