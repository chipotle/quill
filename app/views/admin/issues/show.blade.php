@extends('layouts.admin')

@section('title')
Issue {{ $issue->volnum() }}
@endsection

@section('content')

@if ($issue->is_published)

<p class="alert alert-info">This issue&rsquo;s contents are frozen. If you need to change the contents, {{ HTML::linkRoute('sysop.issues.edit', 'edit the metadata', [$issue->id]) }} and uncheck &ldquo;Published.&rdquo;</p>

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

<p id="publishctrl"><button class="btn btn-primary" id="publish">Publish</button></p>
<p id="changectrls">
  <button class="btn btn-warning" id="commit">Commit</button>
  <button class="btn btn-danger" id="revert">Revert</button>
</p>


<div class="row">
  <div class="span6">
    <h2>Stories</h2>
    <ul id="toc" class="connectedSortable">
      @foreach ($issue->stories as $story)
      <li class="draggable" data-id="{{ $story->id }}"><b>{{ $story->title }}</b> {{ $story->author->name }}</li>
      @endforeach
    </ul>
  </div>
  <div class="span6">
    <h2>Unassigned Stories</h2>
    <ul id="unassigned" class="connectedSortable">
      @foreach ($unassigned as $story)
      <li class="draggable" data-id="{{ $story->id }}"><b>{{ $story->title }}</b> {{ $story->author->name }}</li>
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

  function setPublishButton(test) {
    if (test.length == 0) {
      $('#publish').attr('disabled', 'disabled');
    }
    else {
      $('#publish').removeAttr('disabled');
    }
  }

  $('#toc, #unassigned').sortable({
    connectWith: '.connectedSortable',
    update: function(event, ui) {
      $('#publishctrl').hide();
      $('#changectrls').show('bounce');
    }
  }).disableSelection();

  $('#revert').on('click', function() { location.reload(); });

  $('#commit').on('click', function() {
    var toc = [];
    $('#toc li').each(function(i, li) {
      toc.push($(li).data('id'));
    });
    $.post(
      '{{ URL::route("sysop.issues.commit") }}',
      {contents: toc, issue: {{ $issue->id }} }
    ).fail(function(jqxhr) {
      var rt = jqxhr.responseText;
      if (rt.error) {
        alert(rt.message);
      }
      else {
        alert(rt);
      }
    });
    console.log(toc);
    setPublishButton(toc);
    $('#changectrls').hide();
    $('#publishctrl').show('bounce');
  });

  $('#publish').on('click', function() {
    location.href = "{{ URL::route('sysop.issues.publish', [$issue->id]) }}";
  });

  setPublishButton($('#toc li'));
});
</script>
@endif
@endsection
