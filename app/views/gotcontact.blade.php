@extends('layouts.master')

@section('title') Got it! @endsection

@section('content')
<article class="page">

<p><strong>Thank you, {{ $name }}!</strong></p>

<p>Your message has been sent to the editors.</p>

<p><a href="/">Back to front page</a></p>
@endsection
