@extends('layouts.master')

@section('title')
Claw &amp; Quill: Authors
@endsection

@section('content')
<header id="header">
  <div><a class="image" href="/"><img src="/img/cnq-logo.png" alt="Claw &amp; Quill"></a></div>
  <h1>Claw &amp; Quill Author Index</h1>
</header>

<article class="toc">
@if ($authors->getLastPage() > 1)
<p>Page {{ $authors->getCurrentPage() }} of {{ $authors->getLastPage() }}</p>
@endif

@foreach ($authors as $author)
  <h2>{{ HTML::linkAction('AuthorController@showBio', $names[$author->id], [$author->id]) }}</h2>
  <ul>
  @foreach ($stories[$author->id] as $story)
    <li>{{ HTML::linkAction('IssueController@showStory', $story->title, [$story->issue_id, $story->slug]) }}</li>
  @endforeach
  </ul>
@endforeach
</article>

<footer class="toc">
  <p>{{ HTML::link('/', 'Home') }}
    @if ($authors->getLastPage() > 1)
    &middot; {{ $authors->links() }}
    @endif
  </p>
  <p>Copyright 2013 Claw &amp; Quill</p>
</footer>
@endsection
