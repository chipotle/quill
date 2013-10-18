@extends('layouts.master')

@section('title')
Claw &amp; Quill
@endsection

@section('head')
<link href="{{ URL::action('HomeController@feed') }}" type="application/atom+xml" rel="alternate" title="Syndication Feed">
@endsection

@section('content')
<header id="header">
  <div><img src="/img/cnq-logo.png" alt="Claw &amp; Quill"></div>
  <h1>No. {{ $issue->number }} &middot; {{ $issue->pub_date->toFormattedDateString() }}</h1>
</header>

<article class="toc">
@if ($issue->title)
<h1>{{ $issue->title }}</h1>
@endif
@foreach ($issue->storiesSorted() as $story)
<h2>{{ HTML::linkAction('IssueController@showStory', $story->title, [$issue->id, $story->slug]) }} <span class="author">{{ $story->author->getPreferredName() }}</span></h2>
{{ $story->getBlurb() }}
@endforeach
</article>

<footer class="toc">
  <p class="pull-right"><a href="http://twitter.com/clawandquill">Twitter</a> &middot; {{ HTML::linkAction('HomeController@feed', 'Feed') }}</p>
  <p>{{ HTML::linkRoute('page', 'About C&amp;Q', ['about']) }} &middot; {{ HTML::linkRoute('page', 'Submission Guidelines', ['guidelines']) }} &middot; {{ HTML::linkAction('IssueController@getIndex', 'Issue Index') }} &middot; {{ HTML::linkRoute('page', 'Colophon', ['colophon']) }}</p>
  <p>{{ HTML::linkRoute('page', 'Copyright', ['copyright']) }} 2013 Claw &amp; Quill &middot; <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" title="Creative Commons Attribution-NonCommercial-ShareAlike 3.0">CC BY-NC-SA</a></p>
</footer>
@endsection
