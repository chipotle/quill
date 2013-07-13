@extends('layouts.master')

@section('title'){{ $title }}@endsection

@section('head'){{ $head }}@endsection

@section('content')
<article class="page">
{{ $body }}
</article>
@endsection
