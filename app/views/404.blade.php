@extends('layouts.master')

@section('title')
404 Not Found
@endsection

@section('head')
<style type="text/css">
  #logo {
    text-align: center;
    margin: 30% auto 1em auto;
    clear: both;
  }
  #logo img {
    width: 302px;
    height: 86px;
  }
  p { font-style: italic; margin: 0.201em auto; }
</style>
@endsection

@section('content')
<div id="logo">
  <img src="/img/cnq-logo.png" alt="Claw &amp; Quill">

  <p><strong>Page Not Found</strong></p>
  <p>We’re not sure what you were looking for, but this isn’t it.</p>
  <p>&#10086;</p>
  <p><a href="/">Home</a></p>
</div>
@endsection
