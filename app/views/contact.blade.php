@extends('layouts.master')

@section('title') Contact C&amp;Q @endsection

@section('content')
<article class="page">

<h1>Contact Us</h1>

<p>Let us know what&#8217;s on your mind! While we don&#8217;t promise you&#8217;ll get a response, we promise that we do read everything. (Keep in mind that if you don&#8217;t give a real email address, we <em>can&#8217;t</em> give you a response.)</p>

<p>If you want to pitch us a submission, please use the <a href="/pitch">pitch form</a> instead.</p>

{{ Form::open() }}

<p>{{ Form::label('name', 'Your name') }}<br>
{{ Form::text('name') }}</p>

<p>{{ Form::label('email', 'Your email address') }}<br>
{{ Form::email('email') }}</p>

<p>{{ Form::label('body', 'Your message') }}<br>
{{ Form::textarea('body') }}</p>

<p>{{ Form::submit('Send') }} or <a href="/">Cancel</a></p>

{{ Form::close() }}


</article>
@endsection
