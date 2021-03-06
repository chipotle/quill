@extends('layouts.admin')

@section('head')
  <script type="text/javascript" src="//use.typekit.net/fky8rov.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
@endsection

@section('content')

<header class="preview">Preview</header>

<div id="preview">
  <article>
    <h1>{{ $title }}</h1>

    @if ($subhead)
    <p class="subhead">{{ $subhead }}</p>
    @endif

    <p class="author">{{ $author }}</p>

    @if ($blurb)
    <div class="excerpt">
      {{ $blurb }}
    </div>
    @endif

    {{ $body }}
  </article>
</div>

<footer class="preview">
  <a href="{{ URL::route('sysop.stories.index') }}" class="btn"><i class="icon-backward"></i> Back</a>
  <a href="{{ URL::route('sysop.stories.edit', [$id]) }}" class="btn"><i class="icon-edit"></i> Edit</a>
</footer>

@endsection
