@extends('layouts.admin')

@section('title') {{ $author->name }} @endsection

@section('content')

<div class="row">
  <div class="span6">
    <h2>Stories</h2>
    <ul>
      @foreach ($author->stories as $story)
      <li>{{ $story->title }}</li>
      @endforeach
    </ul>
  </div>
  <div class="span6">
    <h2>Pitches</h2>
    <ul>
      @foreach ($author->pitches as $pitch)
      <li>{{ HTML::truncate($pitch->blurb) }} ({{ Pitch::$statusList[$pitch->status] }})</li>
      @endforeach
    </ul>
  </div>
</div>

@endsection
