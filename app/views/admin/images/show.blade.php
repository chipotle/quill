@extends('layouts.admin')

@section('title') {{ $author->name }} @endsection

@section('content')

<p>
  <a href='{{ URL::route("sysop.authors.edit", [$author->id]) }}' class="btn"><i class="icon-edit"></i> Edit</a>
  <a href='mailto:{{ $author->email }}' class="btn"><i class="icon-envelope"></i> Mail</a>
</p>

<div class="row">

  <div class="span6">
    <h2>Stories</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Issue</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($author->stories as $story)
        <tr>
          <td>{{ HTML::linkRoute('sysop.stories.show', $story->title, [$story->id]) }}</td>
          <td>
            @if ($story->issue_id)
              {{ HTML::linkRoute('sysop.issues.show', 'Issue ' . $story->issue->volnum(), [$story->issue_id]) }}
            @else
              &mdash;
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <a href='{{ URL::route("sysop.stories.createwith", [$author->id]) }}' class="btn btn-success" style="color:white"><i class="icon-plus icon-white"></i> New</a>
  </div>

  <div class="span6">
    <h2>Pending Pitches</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Blurb</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($author->pitches as $pitch)
        <tr>
          <td>{{ HTML::linkRoute('sysop.pitches.show', HTML::truncate($pitch->blurb), [$pitch->id]) }}</td>
          <td>{{ Pitch::$statusList[$pitch->status] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>

@endsection
