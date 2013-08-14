@extends('layouts.admin')

@section('title') Issue {{ $issue->volume }}.{{ $issue->number }} @endsection

@section('content')

@if ($issue->is_published)

<p><i>The contents cannot be edited once an issue is published.</i></p>

<div class="row">
  <div class="span6">
    <h2>Stories</h2>
    <ol>
      @foreach ($issue->stories as $story)
      <li><b>{{ $story->title }}</b> {{ $story->author->name }}</li>
      @endforeach
    </ol>
  </div>
</div>

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
