@extends('layouts.admin')

@section('title') {{ $author->name }} @endsection

@section('content')

<a href='{{ URL::route("sysop.stories.createwith", [$author->id]) }}' class="btn btn-success" style="color:white"><i class="icon-plus icon-white"></i> New Story</a>

<div class="row">
  <div class="span6">
    <h2>Stories</h2>
    <ul>
      @foreach ($author->stories as $story)
      <li>{{ HTML::linkRoute('sysop.stories.show', $story->title, [$story->id]) }}</li>
      @endforeach
    </ul>
  </div>
  <div class="span6">
    <h2>Pitches</h2>
    <ul>
      @foreach ($author->pitches as $pitch)
      <li>{{ HTML::linkRoute('sysop.pitches.show', HTML::truncate($pitch->blurb), [$pitch->id]) }} ({{ Pitch::$statusList[$pitch->status] }})</li>
      @endforeach
    </ul>
  </div>
</div>

@endsection
