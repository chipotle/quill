@extends('layouts.admin')

@section('title') Story Preview @endsection

@section('head')
  <script type="text/javascript" src="//use.typekit.net/fky8rov.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
@endsection

@section('content')

<div id="preview">
  <article>
    <h1>{{ $story->title }}</h1>

    @if ($story->subhead)
    <h2>{{ $story->subhead }}</h2>
    @endif

    <p class="author">{{ $story->author->getPreferredName() }}</p>

    <div class="excerpt">
      {{ $story->blurb }}
    </div>

    {{ $story->body }}
  </article>
</div>

@endsection
