@extends('layouts.admin')

@section('head')
  <script type="text/javascript" src="//use.typekit.net/fky8rov.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
@endsection

@section('content')

<header class="preview">Preview: {{ $title }}</header>

<div id="preview">
  <article class="page">
    {{ $body }}
  </article>
</div>

<footer class="preview">
  <a href="{{ URL::route('sysop.pages.index') }}" class="btn"><i class="icon-backward"></i> Back</a>
  <a href="{{ URL::route('sysop.pages.edit', [$id]) }}" class="btn"><i class="icon-edit"></i> Edit</a>
</footer>

@endsection
