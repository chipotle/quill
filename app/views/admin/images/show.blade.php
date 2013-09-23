@extends('layouts.admin')

@section('title') Image @endsection

@section('content')

<p><img src="{{ $image->getFileURL() }}" alt="{{ $image->alt_text }}"></p>

<h3>Markdown (straight image):</h3>

<pre>
@if ($image->caption)
![{{ $image->alt_text }}]({{ $image->getFileURL() }} "{{ $image->caption }}")
@else
![{{ $image->alt_text }}]({{ $image->getFileURL() }})
@endif
</pre>

<h3>HTML (straight image):</h3>

<pre>
@if ($image->caption)
&lt;img src="{{ $image->getFileURL() }}" alt="{{ $image->alt_text }}" title="{{ $image->caption }}"&gt;
@else
&lt;img src="{{ $image->getFileURL() }}" alt="{{ $image->alt_text }}"&gt;
@endif
</pre>

<h3>HTML (link from thumbnail):</h3>

<p>(To come)</p>

@endsection
