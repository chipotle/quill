@extends('layouts.admin')

@section('title') Issue {{ $issue->volume }}.{{ $issue->number }} @endsection

@section('content')

<div class="row">
  <div class="span6">
    <h2>Stories</h2>
    <ul>
      @foreach ($stories as $story)
      <li>{{ $story->title }}</li>
      @endforeach
    </ul>
  </div>
  <div class="span6">
    <h2>Unassigned Stories</h2>
    <ul>
      @foreach ($unassigned as $story)
      <li>{{ $unassigned->title }}</li>
      @endforeach
    </ul>
  </div>
</div>

@endsection
