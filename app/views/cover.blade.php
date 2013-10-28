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
<h2>{{ HTML::linkAction('IssueController@showStory', $story->title, [$issue->id, $story->slug]) }} <span class="author">{{ HTML::linkAction('AuthorController@showBio', $story->author->getPreferredName(), [$story->author_id]) }}</span></h2>
{{ $story->getBlurb() }}
@endforeach
</article>

<footer class="toc">
  <div class="pull-right">
    <p>{{ HTML::linkAction('IssueController@getIndex', 'Issue Index') }} &middot; {{ HTML::linkAction('AuthorController@getIndex', 'Author Index') }}</p>
    <p><a href="http://twitter.com/clawandquill">Twitter</a> &middot; {{ HTML::linkAction('HomeController@feed', 'Feed') }}</p>
  </div>
  <p>{{ HTML::linkRoute('page', 'About', ['about']) }} &middot; {{ HTML::linkRoute('page', 'FAQ', ['faq']) }} &middot; {{ HTML::linkRoute('page', 'Colophon', ['colophon']) }} &middot; {{ HTML::link('contact', 'Contact') }}</p>
  <p>&copy; 2013 Claw &amp; Quill &middot; {{ HTML::linkRoute('page', 'CC BY-NC-SA', ['colophon']) }}</p>
</footer>
@endsection
