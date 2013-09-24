@extends('layouts.master')

@section('title')C&amp;Q #{{ $volnum}}: {{ $title }}@endsection

@section('head')
<link rel="canonical" href="{{ URL::action('IssueController@showStory', [$issue_id, $slug]) }}">
@endsection

@section('content')
<header class="story">
  <p>Claw &amp; Quill &middot; Issue #{{ $volnum }} &middot; {{ $date }}</p>
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
{{ HTML::script('js/footnote.js') }}
@endsection
