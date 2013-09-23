@extends('layouts.master')

@section('title')
Claw &amp; Quill {{ $issue->volnum() }}
@endsection

@section('content')
<header id="header">
  <h1>#{{ $issue->volnum() }} &middot; {{ $issue->pub_date->toFormattedDateString() }} @if ($issue->title) <br><span>{{ $issue->title }}</span> @endif </h1>
  <img src="/img/cnq-logo.png" alt="Claw &amp; Quill">
</header>

<article class="toc">
@foreach ($issue->stories as $story)
<h2>{{ $story->title }} <span class="author">{{ $story->author->getPreferredName() }}</span></h2>
{{ $story->getBlurb() }}
@endforeach
</article>
@endsection
