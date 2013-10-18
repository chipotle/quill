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
  p { margin: 0.201em auto; }
  h1 {
    font-weight: 700;
    font-size: 1.25em;
  }
</style>
@endsection

@section('content')
<div id="logo">
  <img src="/img/cnq-logo.png" alt="Claw &amp; Quill">

  <h1>Page Not Found</h1>
  <p><em>We’re not sure what you were looking for,<br>but we’re sure this isn’t it.</em></p>
  <p>&#10086;</p>
  <p><a href="/">Home</a></p>
</div>
@endsection
