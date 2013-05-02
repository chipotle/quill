@extends('layouts.master')

@section('title'){{ $title }}@endsection

@section('head'){{ $head }}@endsection

@section('content')
<article class="page hyphenate">
{{ $body }}
</article>
@endsection
