@extends('layouts.admin')

@section('title') Issue {{ $issue->volume }}.{{ $issue->number }} @endsection

@section('content')

@if ($issue->is_published)

<h2>Stories</h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Title</th>
      <th>Author</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($issue->stories as $story)
    <tr>
      <td>{{ HTML::linkRoute('sysop.stories.show', $story->title, [$story->id]) }}</td>
      <td>{{ HTML::linkRoute('sysop.authors.show', $story->author->name, [$story->author->id]) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<p><a href='{{ URL::route("sysop.issues.edit", [$issue->id]) }}' title="Edit Metadata" class="btn"><i class="icon-edit"></i> Edit</a></p>

@else

<p>
  <button class="btn btn-primary" id="action">Publish</button>
  <button class="btn btn-danger" id="revert" style="display:none">Revert</button>
</p>

<div class="row">
  <div class="span6">
    <h2>Stories</h2>
    <ul id="toc" class="connectedSortable">
      @foreach ($issue->stories as $story)
      <li class="draggable"><b>{{ $story->title }}</b> {{ $story->author->name }}</li>
      @endforeach
    </ul>
  </div>
  <div class="span6">
    <h2>Unassigned Stories</h2>
    <ul id="unassigned" class="connectedSortable">
      @foreach ($unassigned as $story)
      <li class="draggable"><b>{{ $story->title }}</b> {{ $story->author->name }}</li>
      @endforeach
    </ul>
  </div>
</div>

@endif

@endsection

@section('scripts')
@if ( ! $issue->is_published)
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
$(function() {
  $('#toc, #unassigned').sortable({
    connectWith: '.connectedSortable',
    update: function(event, ui) {
      $('#action').removeClass('btn-primary').addClass('btn-warning').text('Commit');
      $('#action').removeAttr('disabled');
      $('#revert').show();
    }
  }).disableSelection();
  $('#revert').on('click', function() { location.reload(); })
  $('#action').on('click', function() {
    var type = $(this).text();
    alert(type);
    return false;
  })
  if ($('#toc li').length == 0) {
    $('#action').attr('disabled', 'disabled');
  }
});
</script>
@endif
@endsection
