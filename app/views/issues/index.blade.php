@extends('layouts.master')

@section('title')
Claw &amp; Quill: Issues
@endsection

@section('content')
<header id="header">
  <h1>Claw &amp; Quill Issue Index</h1>
  <img src="/img/cnq-logo.png" alt="Claw &amp; Quill">
</header>

<article class="toc">
@if ($issues->getLastPage() > 1)
<p>Page {{ $issues->getCurrentPage() }} of {{ $issues->getLastPage() }}</p>
@endif

@foreach ($issues as $issue)
  <h2>{{ HTML::linkAction('IssueController@showIssue', 'Issue #' . $issue->volnum(), [$issue->id]) }}</h2>
  <ul>
  @foreach ($issue->storiesSorted() as $story)
    <li>{{ HTML::linkAction('IssueController@showStory', $story->title, [$issue->id, $story->slug]) }}</li>
  @endforeach
  </ul>
@endforeach
</article>

<footer class="toc">
  <p>{{ HTML::link('/', 'Home') }}
    @if ($issues->getLastPage() > 1)
    &middot; {{ $issues->links() }}
    @endif
  </p>
  <p>Copyright 2013 Claw &amp; Quill</p>
</footer>
@endsection
