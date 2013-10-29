@extends('layouts.master')

@section('title')C&amp;Q #{{ $volnum}}: {{ $title }}@endsection

@section('head')
<link rel="canonical" href="{{ URL::action('IssueController@showStory', [$issue_id, $slug]) }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $blurb }}">
@endsection

@section('content')
<header class="story">
  <p>
    {{ HTML::linkAction('IssueController@showIssue', "Issue #$volnum", [$issue_id]) }} &middot; {{ $date }}
    <span class="pull-right">{{ HTML::link('/', 'Claw &amp; Quill') }}</span>
  </p>
</header>

<article itemscope itemtype="http://schema.org/Article">
  <h1 itemprop="name">{{ $title }}</h1>

  @if ($subhead)
  <p class="subhead">{{ $subhead }}</p>
  @endif

  <p class="author" itemprop="author">{{ HTML::linkAction('AuthorController@showBio', $author, [$author_id]) }}</p>

  @if ($blurb)
  <div class="excerpt" itemprop="description">
    {{ $blurb }}
  </div>
  @endif

  <div itemprop="articleBody">
  {{ $body }}
  </div>
</article>

<footer class="story">
  <p class="share">
    Share<span>:
    <a href="https://www.twitter.com/share?url={{ urlencode(URL::action('IssueController@showStory', [$issue_id, $slug])) }}">Twitter</a>
    <a data-width="626" data=height="436" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(URL::action('IssueController@showStory', [$issue_id, $slug])) }}" target="_blank">Facebook</a>
    <a href="https://plus.google.com/share?url={{ urlencode(URL::action('IssueController@showStory', [$issue_id, $slug])) }}">Google+</a></span>
  </p>
  <p class="back">{{ HTML::linkAction('IssueController@showIssue', "Return to Issue #$volnum", [$issue_id]) }}</p>
</footer>

@endsection
