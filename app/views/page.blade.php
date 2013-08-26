@extends('layouts.master')

@section('title'){{ $title }}@endsection

@section('head'){{ $head }}@endsection

@section('content')
<article class="page">
{{ $body }}
</article>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
{{ HTML::script('js/footnote.js') }}
@endsection
