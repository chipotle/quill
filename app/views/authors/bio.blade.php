@extends('layouts.master')

@section('title')
C&amp;Q Author: {{ $author->getPreferredName() }}
@endsection

@section('content')

<header id="header">
  <div><a class="image" href="/"><img src="/img/cnq-logo.png" alt="Claw &amp; Quill"></a></div>
</header>

<article class="author">

<h1>{{ $author->getPreferredName() }}</h1>

@if ($author->bio)
<p>{{ $author->getBio() }}</p>
@else
<p><em>(We haven’t been provided an author bio yet!)</em></p>
@endif

@if ($author->website)
<p><strong>Website:</strong> {{ HTML::link($author->website) }}</p>
@endif

@if ($author->twitter)
<p><strong>Twitter: @</strong>{{ HTML::link("http://twitter.com/{$author->twitter}", $author->twitter) }}</p>
@endif

<h2>Stories:</h2>

<ul>
@foreach ($author->stories as $story)
<li>{{ HTML::linkAction('IssueController@showStory', $story->title, [$story->issue_id, $story->slug]) }} (Issue #{{ $story->issue->number }})</li>
@endforeach
</ul>

</article>

<footer class="toc">
  <p>{{ HTML::link('/', 'Home') }} &middot; {{ HTML::linkAction('AuthorController@getIndex', 'Author Index') }}</p>
</footer>

@endsection
