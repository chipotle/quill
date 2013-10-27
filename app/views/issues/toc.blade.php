@extends('layouts.master')

@section('title')
Claw &amp; Quill: No. {{ $issue->number }}
@endsection

@section('content')
<header id="header">
  <div><a class="image" href="/"><img src="/img/cnq-logo.png" alt="Claw &amp; Quill"></a></div>
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
  <div class="pull-right">
    <p>{{ HTML::linkAction('IssueController@getIndex', 'Issue Index') }} &middot; {{ HTML::linkAction('AuthorController@getIndex', 'Author Index') }}</p>
    <p><a href="http://twitter.com/clawandquill">Twitter</a> &middot; {{ HTML::linkAction('HomeController@feed', 'Feed') }}</p>
  </div>
  <p>{{ HTML::link('/', 'Home') }}</p>
  <p>&copy; 2013 Claw &amp; Quill &middot; {{ HTML::linkRoute('page', 'CC BY-NC-SA', ['colophon']) }}</p>
</footer>
@endsection
