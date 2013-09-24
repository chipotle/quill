@extends('layouts.master')

@section('title')
Claw &amp; Quill: No. {{ $issue->volnum() }}
@endsection

@section('content')
<header id="header">
  <h1>No. {{ $issue->volnum() }} &middot; {{ $issue->pub_date->toFormattedDateString() }} @if ($issue->title) <br><span>{{ $issue->title }}</span> @endif </h1>
  <img src="/img/cnq-logo.png" alt="Claw &amp; Quill">
</header>

<article class="toc">
@foreach ($stories as $story)
<h2>{{ HTML::linkAction('IssueController@showStory', $story->title, [$issue->id, $story->slug]) }} <span class="author">{{ $story->author->getPreferredName() }}</span></h2>
{{ $story->getBlurb() }}
@endforeach
</article>

<footer class="toc">
  <p>{{ HTML::link('/', 'Home') }} &middot; {{ HTML::linkAction('IssueController@getIndex', 'Issue Index') }}</p>
  <p>Copyright 2013 Claw &amp; Quill</p>
</footer>
@endsection