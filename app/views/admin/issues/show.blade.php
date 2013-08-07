@extends('layouts.admin')

@section('title') Issue {{ $issue->volume }}.{{ $issue->number }} @endsection

@section('content')

<p>Status: {{ ($issue->published ? 'Published' : 'Unpublished') }}
<div class="row">
  <div class="span6">
    <h2>Stories</h2>
    <ul>
      @foreach ($issue->stories as $story)
      <li>{{ $story->title }}</li>
      @endforeach
    </ul>
  </div>
  <div class="span6">
    <h2>Unassigned Stories</h2>
    <ul>
      @foreach ($unassigned as $story)
      <li>{{ $story->title }}</li>
      @endforeach
    </ul>
  </div>
</div>

@endsection
