@extends('layouts.master')

@section('title')
Claw &amp; Quill {{ $issue->volnum() }}
@endsection

@section('content')
<header id="header">
  <h1>#{{ $issue->volnum() }} &middot; {{ $issue->pub_date->toFormattedDateString() }} @if ($issue->title) <br><span>{{ $issue->title }}</span> @endif </h1>
  <img src="/img/cnq-logo.png" alt="Claw &amp; Quill">
</header>

<article class="toc">
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quid enim est a Chrysippo praetermissum in Stoicis? Apud imperitos tum illa dicta sunt, aliquid etiam coronae datum; Animi enim quoque dolores percipiet omnibus partibus maiores quam corporis. Et harum quidem rerum facilis est et expedita distinctio. Illis videtur, qui illud non dubitant bonum dicere; Illud non continuo, ut aeque incontentae. Duo Reges: constructio interrete.</p>
</article>
@endsection
