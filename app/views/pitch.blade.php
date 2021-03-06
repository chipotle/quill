@extends('layouts.master')

@section('title') Pitch a story to C&amp;Q! @endsection

@section('content')
<article class="page">

<h1>Pitch a story!</h1>

<p>You&#8217;ve probably come to this page from the <a href="/page/guidelines">guideline page</a>, but if perchance you didn&#8217;t, you definitely want to review those to know what we&#8217;re looking for. What we&#8217;re looking for <em>now</em> is a short description of your proposed article, the “elevator pitch” as to why it&#8217;s an interesting story to tell. (If it&#8217;s a review, this is easy&mdash;just tell us what you want to review!)</p>

<p>If you&#8217;ve published with us before, please use the same email address as you did with your previous submission if you can&#8212;that helps us keep track of things a little better.</p>

{{ Form::model($pitch) }}

<p>{{ Form::label('email', 'Your email address') }}<br>
{{ Form::email('email') }}</p>

<p>{{ Form::label('name', 'Your name') }}<br>
{{ Form::text('name') }}</p>

<p>{{ Form::label('blurb', 'Your story idea') }}<br>
{{ Form::textarea('blurb') }}</p>

<p>{{ Form::submit('Pitch') }}</p>

{{ Form::close() }}
</article>
@endsection
