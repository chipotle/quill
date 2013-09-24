@extends('layouts.master')

@section('title')C&amp;Q #{{ $volnum}}: {{ $title }}@endsection

@section('head')
<link rel="canonical" href="{{ URL::action('IssueController@showStory', [$issue_id, $slug]) }}">
@endsection

@section('content')
<header class="story">
  <p>{{ HTML::link('/', 'Claw &amp; Quill') }} &middot; {{ HTML::linkAction('IssueController@showIssue', "Issue #$volnum", [$issue_id]) }} &middot; {{ $date }}</p>
</header>

<article>
  <h1>{{ $title }}</h1>

  @if ($subhead)
  <p class="subhead">{{ $subhead }}</p>
  @endif

  <p class="author">{{ $author }}</p>

  <div class="excerpt">
    {{ $blurb }}
  </div>

  {{ $body }}
</article>

<footer class="story">
  <p>{{ HTML::linkAction('IssueController@showIssue', "Return to Issue #$volnum &rarr;", [$issue_id]) }}</p>
</footer>

@endsection
