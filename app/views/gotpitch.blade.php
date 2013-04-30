@extends('layouts.master')

@section('title') Got it! @endsection

@section('content')
<article class="page">

<p><strong>Thank you, {{ $pitch->name }}.</strong></p>

<p>Your pitch has been duly filed away and we&#8217;ll be in touch with you when we&#8217;re able. You can always write the editor at <a href="&#x6D;&#97;&#105;&#x6C;&#x74;&#x6F;:&#108;&#97;&#121;&#111;&#x74;&#108;&#64;&#x67;&#109;&#97;&#x69;&#108;.&#x63;&#111;&#x6D;">&#108;&#97;&#121;&#111;&#x74;&#108;&#64;&#x67;&#109;&#97;&#x69;&#108;.&#x63;&#111;&#x6D;</a> and ask for an update&#8212;although do give it a couple weeks!</p>

<p><a href="/">Back to front page</a></p>
@endsection
